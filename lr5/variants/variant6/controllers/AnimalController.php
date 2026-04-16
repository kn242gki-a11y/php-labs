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
        $stmt = $this->db->query('SELECT * FROM animals ORDER BY id DESC');
        $animals = $stmt->fetchAll();

        $this->render('animal/list', [
            'animals' => $animals,
        ], 'Тварини');
    }

    public function action_create(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $stmt = $this->db->prepare(
                    'INSERT INTO animals (name, species, breed, age, owner)
                     VALUES (:name, :species, :breed, :age, :owner)'
                );
                $stmt->execute([
                    ':name' => trim($old['name']),
                    ':species' => trim($old['species']),
                    ':breed' => trim($old['breed'] ?? ''),
                    ':age' => (int)($old['age'] ?? 0),
                    ':owner' => trim($old['owner']),
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
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        $id = (int)$this->request->get('id', 0);

        if ($id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        $stmt = $this->db->prepare('SELECT * FROM animals WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $animal = $stmt->fetch();

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
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);

            if ($id > 0) {
                $stmt = $this->db->prepare('DELETE FROM animals WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $_SESSION['flash_success'] = 'Тварину видалено!';
            }
        }

        $this->redirect('animal/list');
    }

    public function action_detail(): void
    {
        $id = (int)$this->request->get('id', 0);

        if ($id <= 0) {
            $this->redirect('animal/list');
            return;
        }

        try {
            $stmt = $this->db->prepare('SELECT * FROM animals WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $animal = $stmt->fetch();

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
        $animal_id = (int)$this->request->get('id', 0);
        
        if ($animal_id <= 0) {
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
        $animal_id = (int)$this->request->get('id', 0);
        
        if ($animal_id <= 0) {
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
}
