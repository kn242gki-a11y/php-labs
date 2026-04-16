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
        try {
            $stmt = $this->db->query('SELECT * FROM volunteers WHERE status = "approved" ORDER BY created_at DESC');
            $volunteers = $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
        }

        $this->render('volunteer/index', [
            'volunteers' => $volunteers,
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
