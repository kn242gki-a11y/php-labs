<?php

class ServiceController extends PageController
{
    private PDO $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
    }

    public function action_index(): void
    {
        $services = [
            [
                'name' => 'Прийом ветеринара',
                'description' => 'Огляд тварини, консультація та рекомендації щодо лікування.',
                'price' => '500 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Виїзд ветеринара додому',
                'description' => 'Огляд і допомога тварині у зручному для вас місці.',
                'price' => 'від 800 грн',
                'route' => 'service/home_visit',
                'button' => 'Замовити виїзд',
            ],
            [
                'name' => 'Вакцинація',
                'description' => 'Планова вакцинація та консультація щодо щеплень.',
                'price' => 'від 350 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Діагностика та аналізи',
                'description' => 'Загальні та біохімічні аналізи для точної діагностики.',
                'price' => 'від 450 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'УЗД-обстеження',
                'description' => 'Безпечне ультразвукове обстеження внутрішніх органів.',
                'price' => 'від 600 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Стоматологія',
                'description' => 'Огляд ротової порожнини, чистка зубів та лікування.',
                'price' => 'від 700 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Хірургічні операції',
                'description' => 'Планові операції під наглядом досвідчених ветеринарів.',
                'price' => 'від 2 000 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Стерилізація та кастрація',
                'description' => 'Безпечне проведення процедури та післяопераційний догляд.',
                'price' => 'від 1 500 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Чіпування',
                'description' => 'Встановлення мікрочипа та реєстрація тварини.',
                'price' => 'від 400 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Дерматологічна консультація',
                'description' => 'Діагностика алергій, шкірних захворювань та проблем із шерстю.',
                'price' => 'від 550 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
            [
                'name' => 'Грумінг',
                'description' => 'Стрижка, гігієнічний догляд, чистка вух та кігтів.',
                'price' => 'від 450 грн',
                'route' => 'guestbook/index',
                'button' => 'Записатися',
            ],
        ];

        $this->render('service/index', ['services' => $services], 'Послуги');
    }

    public function action_emergency(): void
    {
        $message = '';
        $errors = [];

        if ($this->request->isPost()) {
            $data = [
                'owner_name' => trim($this->request->post('owner_name', '')),
                'phone' => trim($this->request->post('phone', '')),
                'animal_name' => trim($this->request->post('animal_name', '')),
                'problem' => trim($this->request->post('problem', '')),
                'urgency' => $this->request->post('urgency', 'normal'),
            ];

            $errors = $this->validateEmergency($data);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO emergency_requests (owner_name, phone, animal_name, problem, urgency)
                         VALUES (:owner_name, :phone, :animal_name, :problem, :urgency)'
                    );
                    $stmt->execute([
                        ':owner_name' => $data['owner_name'],
                        ':phone' => $data['phone'],
                        ':animal_name' => $data['animal_name'],
                        ':problem' => $data['problem'],
                        ':urgency' => $data['urgency'],
                    ]);

                    $message = 'Запит на екстрену допомогу надіслано! Ми зв\'яжемося з вами протягом 30 хвилин.';
                } catch (PDOException $e) {
                    $errors['general'] = 'Помилка при збереженні запиту: ' . $e->getMessage();
                }
            }
        }

        $requests = [];
        $isAdmin = ($_SESSION['user_role'] ?? '') === 'admin'
            || ($_SESSION['user_login'] ?? '') === 'admin';
        if ($isAdmin) {
            $stmt = $this->db->query('SELECT * FROM emergency_requests ORDER BY urgency DESC, created_at DESC LIMIT 10');
            $requests = $stmt->fetchAll() ?: [];
        }

        $this->render('service/emergency', [
            'requests' => $requests,
            'isAdmin' => $isAdmin,
            'message' => $message,
            'errors' => $errors,
        ], 'Швидка ветеринарна допомога');
    }

    public function action_emergency_delete(): void
    {
        $isAdmin = ($_SESSION['user_role'] ?? '') === 'admin'
            || ($_SESSION['user_login'] ?? '') === 'admin';

        if (!$isAdmin) {
            http_response_code(403);
            return;
        }

        if ($this->request->isPost()) {
            $id = (int)$this->request->post('id', 0);
            if ($id > 0) {
                $stmt = $this->db->prepare('DELETE FROM emergency_requests WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $_SESSION['flash_success'] = 'Запит на екстрену допомогу видалено.';
            }
        }

        $this->redirect('service/emergency');
    }

    public function action_home_visit(): void
    {
        $message = '';
        $errors = [];

        if ($this->request->isPost()) {
            $data = [
                'owner_name' => trim($this->request->post('owner_name', '')),
                'phone' => trim($this->request->post('phone', '')),
                'address' => trim($this->request->post('address', '')),
                'animal_name' => trim($this->request->post('animal_name', '')),
                'problem' => trim($this->request->post('problem', '')),
                'visit_date' => trim($this->request->post('visit_date', '')),
                'visit_time' => trim($this->request->post('visit_time', '')),
            ];

            $errors = $this->validateHomeVisit($data);

            if (empty($errors)) {
                try {
                    $stmt = $this->db->prepare(
                        'INSERT INTO home_visits (owner_name, phone, address, animal_name, problem, visit_date, visit_time)
                         VALUES (:owner_name, :phone, :address, :animal_name, :problem, :visit_date, :visit_time)'
                    );
                    $stmt->execute([
                        ':owner_name' => $data['owner_name'],
                        ':phone' => $data['phone'],
                        ':address' => $data['address'],
                        ':animal_name' => $data['animal_name'],
                        ':problem' => $data['problem'],
                        ':visit_date' => $data['visit_date'],
                        ':visit_time' => $data['visit_time'],
                    ]);

                    $message = 'Запит на виїзд ветеринара надіслано! Ми зв\'яжемося для підтвердження.';
                } catch (PDOException $e) {
                    $errors['general'] = 'Помилка при збереженні запиту: ' . $e->getMessage();
                }
            }
        }

        $visits = [];
        try {
            $stmt = $this->db->query('SELECT * FROM home_visits ORDER BY visit_date ASC, visit_time ASC LIMIT 20');
            $visits = $stmt->fetchAll() ?: [];
        } catch (PDOException $e) {
        }

        $this->render('service/home_visit', [
            'visits' => $visits,
            'message' => $message,
            'errors' => $errors,
        ], 'Виїзд ветеринара додому');
    }

    private function validateEmergency(array $data): array
    {
        $errors = [];

        if ($data['owner_name'] === '') {
            $errors['owner_name'] = "Ім'я власника є обов'язковим.";
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Телефон є обов\'язковим.';
        } elseif (strlen($data['phone']) < 10) {
            $errors['phone'] = 'Телефон мав мати мінімум 10 символів.';
        }

        if ($data['animal_name'] === '') {
            $errors['animal_name'] = 'Кличка тварини є обов\'язковою.';
        }

        if ($data['problem'] === '') {
            $errors['problem'] = 'Опис проблеми є обов\'язковим.';
        }

        if (!in_array($data['urgency'], ['low', 'normal', 'high', 'critical'])) {
            $errors['urgency'] = 'Невірний рівень терміновості.';
        }

        return $errors;
    }

    private function validateHomeVisit(array $data): array
    {
        $errors = [];

        if ($data['owner_name'] === '') {
            $errors['owner_name'] = "Ім'я власника є обов'язковим.";
        }

        if ($data['phone'] === '') {
            $errors['phone'] = 'Телефон є обов\'язковим.';
        } elseif (strlen($data['phone']) < 10) {
            $errors['phone'] = 'Телефон мав мати мінімум 10 символів.';
        }

        if ($data['address'] === '') {
            $errors['address'] = 'Адреса є обов\'язковою.';
        }

        if ($data['animal_name'] === '') {
            $errors['animal_name'] = 'Кличка тварини є обов\'язковою.';
        }

        if ($data['visit_date'] === '') {
            $errors['visit_date'] = 'Дата візиту є обов\'язковою.';
        } else {
            try {
                $visitDate = new DateTime($data['visit_date']);
                $today = new DateTime('today');
                
                if ($visitDate < $today) {
                    $errors['visit_date'] = 'Дата повинна бути в майбутньому.';
                }
                
                if ($visitDate->format('N') == 7) {
                    $errors['visit_date'] = 'Виїзди неможливі у неділю.';
                }
            } catch (Exception $e) {
                $errors['visit_date'] = 'Невірний формат дати.';
            }
        }

        if ($data['visit_time'] === '') {
            $errors['visit_time'] = 'Час візиту є обов\'язковим.';
        } else {
            try {
                $time = DateTime::createFromFormat('H:i', $data['visit_time']);
                if (!$time || $time->format('H:i') < '09:00' || $time->format('H:i') > '18:00') {
                    $errors['visit_time'] = 'Виїзди можливі з 9:00 до 18:00.';
                }
            } catch (Exception $e) {
                $errors['visit_time'] = 'Невірний формат часу.';
            }
        }

        return $errors;
    }
}
