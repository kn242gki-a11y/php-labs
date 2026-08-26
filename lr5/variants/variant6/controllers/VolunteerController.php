<?php

class VolunteerController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_index(): void
    {
        $volunteers = [];
        $fundraisers = [];
        try {
            $stmt = $this->db->query('SELECT * FROM volunteers WHERE status = "approved" ORDER BY created_at DESC');
            $volunteers = $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
        }

        try {
            $stmt = $this->db->prepare(
                'SELECT * FROM fundraisers WHERE status = :status ORDER BY created_at DESC'
            );
            $stmt->execute([':status' => 'active']);
            $fundraisers = $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
        }

        $this->render('volunteer/index', [
            'volunteers' => $volunteers,
            'fundraisers' => $fundraisers,
        ], 'Волонтери');
    }

    public function action_signup(): void
    {
        $message = '';
        $errors = [];

        if ($this->request->isPost()) {
            $data = [
                'name' => trim($this->request->post('name', '')),
                'email' => trim($this->request->post('email', '')),
                'phone' => trim($this->request->post('phone', '')),
                'position' => $this->request->post('position', ''),
                'experience' => trim($this->request->post('experience', '')),
                'availability' => trim($this->request->post('availability', '')) ?: 'За узгодженням',
            ];

            $errors = $this->validateSignup($data);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO volunteers (name, email, phone, position, experience, availability, status)
                         VALUES (:name, :email, :phone, :position, :experience, :availability, :status)'
                    );
                    $stmt->execute([
                        ':name' => $data['name'],
                        ':email' => $data['email'],
                        ':phone' => $data['phone'],
                        ':position' => $data['position'],
                        ':experience' => $data['experience'],
                        ':availability' => $data['availability'],
                        ':status' => 'pending',
                    ]);

                    $message = 'Дякуємо за вашу заяву! Ми скоро з вами зв\'яжемося для підтвердження.';
                } catch (PDOException $e) {
                    $errors['general'] = 'Помилка при взяття: ' . $e->getMessage();
                }
            }
        }

        $this->render('volunteer/signup', [
            'message' => $message,
            'errors' => $errors,
        ], 'Стати волонтером');
    }

    public function action_donate(): void
    {
        $id = (int)$this->request->get('id', 0);
        $stmt = $this->db->prepare('SELECT * FROM fundraisers WHERE id = :id AND status = :status');
        $stmt->execute([':id' => $id, ':status' => 'active']);
        $fundraiser = $stmt->fetch();

        if (!$fundraiser) {
            $this->redirect('volunteer/index');
            return;
        }

        $errors = [];
        if ($this->request->isPost()) {
            $amount = trim((string)$this->request->post('amount', ''));
            $normalizedAmount = str_replace(',', '.', $amount);

            if ($amount === '' || !is_numeric($normalizedAmount) || (float)$normalizedAmount <= 0) {
                $errors['amount'] = 'Вкажіть суму допомоги більше 0 грн.';
            } elseif ((float)$normalizedAmount > 1000000) {
                $errors['amount'] = 'Сума допомоги не може перевищувати 1 000 000 грн.';
            }

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'UPDATE fundraisers
                         SET collected_amount = MIN(target_amount, collected_amount + :amount)
                         WHERE id = :id AND status = :status'
                    );
                    $stmt->execute([
                        ':amount' => (float)$normalizedAmount,
                        ':id' => $id,
                        ':status' => 'active',
                    ]);

                    $_SESSION['flash_success'] = 'Дякуємо! Вашу допомогу додано до збору.';
                    $this->redirect('volunteer/index');
                    return;
                } catch (PDOException $e) {
                    $errors['general'] = 'Не вдалося зберегти допомогу. Спробуйте ще раз.';
                }
            }
        }

        $this->render('volunteer/donate', [
            'fundraiser' => $fundraiser,
            'errors' => $errors,
        ], 'Допомогти тварині');
    }

    private function validateSignup(array $data): array
    {
        $errors = [];

        if ($data['name'] === '') {
            $errors['name'] = "Ім'я є обов'язковим.";
        }

        if ($data['email'] === '') {
            $errors['email'] = 'Email є обов\'язковим.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email повинен бути коректним.';
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Телефон є обов\'язковим.';
        } elseif (strlen($data['phone']) < 10) {
            $errors['phone'] = 'Телефон мав мати мінімум 10 символів.';
        }

        if ($data['position'] === '') {
            $errors['position'] = 'Виберіть посаду.';
        }

        if (!in_array($data['position'], ['опікун', 'організатор', 'соціальний'], true)) {
            $errors['position'] = 'Невірна посада.';
        }

        return $errors;
    }
}
