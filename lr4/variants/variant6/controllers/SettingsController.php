<?php

class SettingsController extends PageController
{
    private array $availableColors = [
        '#e0f0ff' => 'Стандартний білий',
        '#80c596' => 'Зелений чай',
        '#6dbec2' => 'Небесна лазур',
        '#f6b1d7' => 'Ніжна троянда',
        '#e0d5a9' => 'Тепла ваніль',
        '#d0bb95' => 'Світлий камінь',
    ];

    public function action_color(): void
    {
        $message = '';
        $messageType = 'success';

        if ($this->request->isPost()) {
            $color = $this->request->postString('bg_color', '#f9fafb');

            if (array_key_exists($color, $this->availableColors)) {
                $_SESSION['bg_color'] = $color;
                $message = 'Колір інтерфейсу успішно оновлено!';
            } else {
                $message = 'Обраний колір недоступний.';
                $messageType = 'error';
            }
        }

        $this->render('settings/color', [
            'colors'       => $this->availableColors,
            'currentColor' => $_SESSION['bg_color'] ?? '#f9fafb',
            'message'      => $message,
            'messageType'  => $messageType,
        ], 'Налаштування кольору');
    }

    public function action_greeting(): void
    {
        $message = '';
        $messageType = 'success';

        if ($this->request->isPost()) {
            $name = trim($this->request->postString('greeting_name'));
            $gender = $this->request->postString('greeting_gender');

            if ($name === '') {
                $message = "Будь ласка, вкажіть ваше ім'я.";
                $messageType = 'error';
            } elseif (!in_array($gender, ['male', 'female'], true)) {
                $message = 'Будь ласка, оберіть стать для коректного звернення.';
                $messageType = 'error';
            } else {
                $expiry = time() + 30 * 24 * 3600; 
                
                setcookie('greeting_name', $name, [
                    'expires' => $expiry,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
                
                setcookie('greeting_gender', $gender, [
                    'expires' => $expiry,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);

                $_COOKIE['greeting_name'] = $name;
                $_COOKIE['greeting_gender'] = $gender;

                $message = 'Профіль успішно оновлено!';
            }
        }

        $this->render('settings/greeting', [
            'message'       => $message,
            'messageType'   => $messageType,
            'currentName'   => $_COOKIE['greeting_name'] ?? '',
            'currentGender' => $_COOKIE['greeting_gender'] ?? '',
        ], 'Налаштування профілю');
    }
}