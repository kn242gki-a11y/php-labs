<?php

class GuestbookController extends PageController
{
    private string $filePath;

    public function __construct()
    {
        parent::__construct();
        $this->filePath = DATA_DIR . '/appointments.jsonl';
    }

    public function action_index(): void
    {
        $message = '';
        $errors = [];

        if ($this->request->isPost()) {
            $name = trim($this->request->post('name', ''));
            $phone = trim($this->request->post('phone', ''));
            $animal_name = trim($this->request->post('animal_name', ''));
            $appointment_date = trim($this->request->post('appointment_date', ''));
            $appointment_time = trim($this->request->post('appointment_time', ''));
            $reason = trim($this->request->post('reason', ''));

            if ($name === '') {
                $errors['name'] = "Ім'я є обов'язковим.";
            }
            if ($phone === '') {
                $errors['phone'] = 'Телефон є обов\'язковим.';
            }
            if ($animal_name === '') {
                $errors['animal_name'] = 'Кличка тварини є обов\'язковою.';
            }
            if ($appointment_date === '') {
                $errors['appointment_date'] = 'Дата запису є обов\'язковою.';
            }
            if ($appointment_time === '') {
                $errors['appointment_time'] = 'Час запису є обов\'язковим.';
            }

            // Validate working hours
            if ($appointment_date !== '' && $appointment_time !== '') {
                $datetime = DateTime::createFromFormat('Y-m-d H:i', $appointment_date . ' ' . $appointment_time);
                $now = new DateTime();
                if ($datetime && $datetime > $now) {
                    $dayOfWeek = (int)$datetime->format('N'); // 1=Monday, 7=Sunday
                    $time = $datetime->format('H:i');

                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Monday to Friday
                        if ($time < '09:00' || $time > '18:00') {
                            $errors['appointment_time'] = 'Запис можливий лише з 9:00 до 18:00 у робочі дні.';
                        }
                    } elseif ($dayOfWeek === 6) { // Saturday
                        if ($time < '10:00' || $time > '16:00') {
                            $errors['appointment_time'] = 'Запис можливий лише з 10:00 до 16:00 по суботах.';
                        }
                    } else { // Sunday
                        $errors['appointment_date'] = 'Запис неможливий у неділю.';
                    }
                } elseif ($datetime && $datetime <= $now) {
                    $errors['appointment_date'] = 'Дата та час запису повинні бути в майбутньому.';
                } else {
                    $errors['appointment_time'] = 'Невірний формат часу.';
                }
            }

            if (empty($errors) && $this->isAppointmentTaken($appointment_date, $appointment_time)) {
                $errors['appointment_time'] = 'Цей час уже зайнятий. Оберіть іншу дату або час.';
            }

            if (empty($errors)) {
                $name = str_replace(["\r", "\n"], ' ', $name);
                $phone = str_replace(["\r", "\n"], ' ', $phone);
                $animal_name = str_replace(["\r", "\n"], ' ', $animal_name);
                $reason = str_replace(["\r", "\n"], ' ', $reason);
                $entry = json_encode([
                    'date' => date('Y-m-d H:i'),
                    'name' => $name,
                    'phone' => $phone,
                    'animal_name' => $animal_name,
                    'appointment_date' => $appointment_date,
                    'appointment_time' => $appointment_time,
                    'reason' => $reason,
                ], JSON_UNESCAPED_UNICODE);
                file_put_contents($this->filePath, $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
                $message = 'Запис до лікаря додано!';
            }
        }

        $isAdmin = ($_SESSION['user_role'] ?? '') === 'admin'
            || ($_SESSION['user_login'] ?? '') === 'admin';
        $appointments = $isAdmin ? $this->readAppointments() : [];

        $this->render('guestbook/index', [
            'appointments' => $appointments,
            'isAdmin' => $isAdmin,
            'message' => $message,
            'errors' => $errors,
        ], 'Запис до ветеринара');
    }

    public function action_delete(): void
    {
        $isAdmin = ($_SESSION['user_role'] ?? '') === 'admin'
            || ($_SESSION['user_login'] ?? '') === 'admin';

        if (!$isAdmin) {
            if (!isset($_SESSION['user_id'])) {
                $this->redirect('auth/login');
            }
            http_response_code(403);
            return;
        }

        if ($this->request->isPost()) {
            $date = trim((string)$this->request->post('appointment_date', ''));
            $time = trim((string)$this->request->post('appointment_time', ''));
            $appointments = $this->readAppointments();
            $remaining = [];
            $deleted = false;

            foreach ($appointments as $appointment) {
                if (!$deleted
                    && $appointment['appointment_date'] === $date
                    && $appointment['appointment_time'] === $time) {
                    $deleted = true;
                    continue;
                }
                $remaining[] = json_encode($appointment, JSON_UNESCAPED_UNICODE) . PHP_EOL;
            }

            if ($deleted) {
                file_put_contents($this->filePath, implode('', array_reverse($remaining)), LOCK_EX);
                $_SESSION['flash_success'] = 'Запис на прийом видалено.';
            }
        }

        $this->redirect('guestbook/index');
    }

    private function readAppointments(): array
    {
        $appointments = [];

        if (!file_exists($this->filePath)) {
            return $appointments;
        }

        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $entry = json_decode($line, true);
            if (is_array($entry) && isset($entry['date'], $entry['name'], $entry['phone'], $entry['animal_name'], $entry['appointment_date'], $entry['appointment_time'])) {
                $appointments[] = $entry;
            }
        }

        return array_reverse($appointments);
    }

    private function isAppointmentTaken(string $date, string $time): bool
    {
        foreach ($this->readAppointments() as $appointment) {
            if ($appointment['appointment_date'] === $date
                && $appointment['appointment_time'] === $time) {
                return true;
            }
        }

        return false;
    }
}
