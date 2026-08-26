<?php

class AnimalController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_list(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        if ($this->isAdmin()) {
            $stmt = $this->db->prepare('SELECT * FROM animals ORDER BY id DESC');
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare('SELECT * FROM animals WHERE owner_id = :owner_id ORDER BY id DESC');
            $stmt->execute([':owner_id' => (int)$_SESSION['user_id']]);
        }
        $animals = $stmt->fetchAll();

        $this->render('animal/list', [
            'animals' => $animals,
        ], 'Тварини');
    }

    public function action_create(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO animals (name, species, breed, age, owner, owner_id)
                     VALUES (:name, :species, :breed, :age, :owner, :owner_id)'
                );
                $stmt->execute([
                    ':name' => trim($old['name']),
                    ':species' => trim($old['species']),
                    ':breed' => trim($old['breed'] ?? ''),
                    ':age' => (int)($old['age'] ?? 0),
                    ':owner' => trim($old['owner']),
                    ':owner_id' => (int)$_SESSION['user_id'],
                ]);

                $_SESSION['flash_success'] = 'Тварину "' . trim($old['name']) . '" додано!';
                $this->redirect('animal/list');
                return;
            }
        }

        $this->render('animal/create', [
            'errors' => $errors,
            'old' => $old,
        ], 'Додати тварину');
    }

    public function action_edit(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $id = (int)$this->request->get('id', 0);

        if ($id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        $animal = $this->findAnimalForUser($id);

        if (!$animal) {
            $this->redirect('animal/list');
            return;
        }

        $errors = [];

        if ($this->request->isPost()) {
            $data = $this->request->allPost();
            $errors = $this->validate($data);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'UPDATE animals SET name = :name, species = :species, breed = :breed,
                     age = :age, owner = :owner WHERE id = :id'
                );
                $stmt->execute([
                    ':name' => trim($data['name']),
                    ':species' => trim($data['species']),
                    ':breed' => trim($data['breed'] ?? ''),
                    ':age' => (int)($data['age'] ?? 0),
                    ':owner' => trim($data['owner']),
                    ':id' => $id,
                ]);

                $_SESSION['flash_success'] = 'Тварину оновлено!';
                $this->redirect('animal/list');
                return;
            }

            $animal = array_merge($animal, $data);
        }

        $this->render('animal/edit', [
            'animal' => $animal,
            'errors' => $errors,
        ], 'Редагувати тварину');
    }

    public function action_delete(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);

            if ($id > 0) {
                $sql = $this->isAdmin()
                    ? 'DELETE FROM animals WHERE id = :id'
                    : 'DELETE FROM animals WHERE id = :id AND owner_id = :owner_id';
                $stmt = $this->db->prepare($sql);
                $params = [':id' => $id];
                if (!$this->isAdmin()) {
                    $params[':owner_id'] = (int)$_SESSION['user_id'];
                }
                $stmt->execute($params);
                $_SESSION['flash_success'] = 'Тварину видалено!';
            }
        }

        $this->redirect('animal/list');
    }

    public function action_detail(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $id = (int)$this->request->get('id', 0);

        if ($id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        try {
            $animal = $this->findAnimalForUser($id);

            if (!$animal) {
                $this->redirect('animal/list');
                return;
            }

            $stmt = $this->db->prepare('SELECT * FROM health_records WHERE animal_id = :id ORDER BY visit_date DESC LIMIT 10');
            $stmt->execute([':id' => $id]);
            $health_records = $stmt->fetchAll() ?: [];

            $stmt = $this->db->prepare('SELECT * FROM vaccinations WHERE animal_id = :id ORDER BY vaccination_date DESC');
            $stmt->execute([':id' => $id]);
            $vaccinations = $stmt->fetchAll() ?: [];

            $this->render('animal/detail', [
                'animal' => $animal,
                'health_records' => $health_records,
                'vaccinations' => $vaccinations,
            ], htmlspecialchars($animal['name']) . ' — Деталі');
        } catch (PDOException $e) {
            $this->redirect('animal/list');
        }
    }

    public function action_health_add(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $animal_id = (int)$this->request->get('id', 0);
        
        if ($animal_id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        if (!$this->findAnimalForUser($animal_id)) {
            $this->redirect('animal/list');
            return;
        }

        $errors = [];
        $message = '';

        if ($this->request->isPost()) {
            $data = [
                'visit_date' => trim($this->request->post('visit_date', '')),
                'diagnosis' => trim($this->request->post('diagnosis', '')),
                'treatment' => trim($this->request->post('treatment', '')),
                'vet_notes' => trim($this->request->post('vet_notes', '')),
            ];

            if ($data['visit_date'] === '') {
                $errors['visit_date'] = 'Дата відвідування є обов\'язковою.';
            }

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO health_records (animal_id, visit_date, diagnosis, treatment, vet_notes)
                         VALUES (:animal_id, :visit_date, :diagnosis, :treatment, :vet_notes)'
                    );
                    $stmt->execute([
                        ':animal_id' => $animal_id,
                        ':visit_date' => $data['visit_date'],
                        ':diagnosis' => $data['diagnosis'],
                        ':treatment' => $data['treatment'],
                        ':vet_notes' => $data['vet_notes'],
                    ]);

                    $stmt = $this->db->prepare('UPDATE animals SET last_visit = :date WHERE id = :id');
                    $stmt->execute([':date' => $data['visit_date'], ':id' => $animal_id]);

                    $message = 'Запис про здоров\'я додано!';
                } catch (PDOException $e) {
                    $errors['general'] = 'Помилка при збереженні: ' . $e->getMessage();
                }
            }
        }

        $this->render('animal/health_add', [
            'animal_id' => $animal_id,
            'message' => $message,
            'errors' => $errors,
        ], 'Додати запис про здоров\'я');
    }

    public function action_vaccination_add(): void
    {
        if (!$this->requireAdmin()) {
            return;
        }

        $animal_id = (int)$this->request->get('id', 0);
        
        if ($animal_id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        if (!$this->findAnimalForUser($animal_id)) {
            $this->redirect('animal/list');
            return;
        }

        $errors = [];
        $message = '';

        if ($this->request->isPost()) {
            $data = [
                'vaccine_name' => trim($this->request->post('vaccine_name', '')),
                'vaccination_date' => trim($this->request->post('vaccination_date', '')),
                'next_due_date' => trim($this->request->post('next_due_date', '')),
                'vet_name' => trim($this->request->post('vet_name', '')),
                'notes' => trim($this->request->post('notes', '')),
            ];

            if ($data['vaccine_name'] === '') {
                $errors['vaccine_name'] = 'Назва щеплення є обов\'язковою.';
            }
            if ($data['vaccination_date'] === '') {
                $errors['vaccination_date'] = 'Дата щеплення є обов\'язковою.';
            }

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO vaccinations (animal_id, vaccine_name, vaccination_date, next_due_date, vet_name, notes)
                         VALUES (:animal_id, :vaccine_name, :vaccination_date, :next_due_date, :vet_name, :notes)'
                    );
                    $stmt->execute([
                        ':animal_id' => $animal_id,
                        ':vaccine_name' => $data['vaccine_name'],
                        ':vaccination_date' => $data['vaccination_date'],
                        ':next_due_date' => $data['next_due_date'],
                        ':vet_name' => $data['vet_name'],
                        ':notes' => $data['notes'],
                    ]);

                    $message = 'Запис про щеплення додано!';
                } catch (PDOException $e) {
                    $errors['general'] = 'Помилка при збереженні: ' . $e->getMessage();
                }
            }
        }

        $this->render('animal/vaccination_add', [
            'animal_id' => $animal_id,
            'message' => $message,
            'errors' => $errors,
        ], 'Додати запис про щеплення');
    }

    private function requireAdmin(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return false;
        }

        if (!$this->isAdmin()) {
            http_response_code(403);
            $this->view->setTitle('Доступ заборонено');
            $this->view->render('layout/404', [
                'message' => 'Розділ «Тварини» доступний лише адміністратору.',
            ]);
            return false;
        }

        return true;
    }

    private function isAdmin(): bool
    {
        return ($_SESSION['user_role'] ?? '') === 'admin'
            || ($_SESSION['user_login'] ?? '') === 'admin';
    }

    private function findAnimalForUser(int $id): ?array
    {
        $sql = $this->isAdmin()
            ? 'SELECT * FROM animals WHERE id = :id'
            : 'SELECT * FROM animals WHERE id = :id AND owner_id = :owner_id';
        $stmt = $this->db->prepare($sql);
        $params = [':id' => $id];
        if (!$this->isAdmin()) {
            $params[':owner_id'] = (int)$_SESSION['user_id'];
        }
        $stmt->execute($params);
        $animal = $stmt->fetch();

        return $animal ?: null;
    }

    private function validate(array $data): array
    {
        $errors = [];
        if (trim((string)($data['name'] ?? '')) === '') {
            $errors['name'] = 'Вкажіть кличку тварини.';
        }
        if (trim((string)($data['species'] ?? '')) === '') {
            $errors['species'] = 'Вкажіть вид тварини.';
        }
        if (trim((string)($data['owner'] ?? '')) === '') {
            $errors['owner'] = 'Вкажіть ПІБ власника.';
        }
        if (($data['age'] ?? '') !== '' && (!ctype_digit((string)$data['age']) || (int)$data['age'] > 100)) {
            $errors['age'] = 'Вік має бути цілим числом від 0 до 100.';
        }
        return $errors;
    }
}
