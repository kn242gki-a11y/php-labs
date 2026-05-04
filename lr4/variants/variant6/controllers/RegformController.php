<?php

class RegformController extends PageController
{
    public function action_form(): void
    {
        $errors = [];
        $old = [];

        if ($this->request->isPost()) {
            $old = $this->request->allPost();
            $errors = $this->validate($old);

            if (empty($errors)) {
                $_SESSION['reg_success'] = true;
                $_SESSION['reg_data'] = [
                    'login' => trim($old['login']),
                    'owner_name' => trim($old['owner_name'] ?? ''),
                    'email' => trim($old['email'] ?? ''),
                    'phone' => trim($old['phone'] ?? ''),
                    'pet_name' => trim($old['pet_name'] ?? ''),
                    'pet_type' => trim($old['pet_type'] ?? ''),
                    'pet_breed' => trim($old['pet_breed'] ?? ''),
                    'pet_age' => trim($old['pet_age'] ?? ''),
                    'about' => trim($old['about'] ?? ''),
                ];
                
                $this->redirect('regform/done');
                return;
            }
        }

        $this->render('regform/form', [
            'errors' => $errors,
            'old' => $old,
        ], 'Реєстрація власника — VetClinic');
    }
    public function action_done(): void
    {
        if (empty($_SESSION['reg_success'])) {
            $this->redirect('regform/form');
            return;
        }

        $data = $_SESSION['reg_data'] ?? [];
        
        unset($_SESSION['reg_success']);

        $this->render('regform/done', [
            'regData' => $data
        ], 'Реєстрація завершена');
    }

    private function validate(array $data): array
    {
        $errors = [];
        $login = isset($data['login']) ? trim($data['login']) : '';
        if ($login === '') {
            $errors['login'] = "Логін власника є обов'язковим.";
        } else {
            if (preg_match('/\s/', $login)) {
                $errors['login'] = 'Логін має бути одним словом без пробілів.';
            } elseif (mb_strlen($login) < 5) {
                $errors['login'] = 'Логін має бути не менше 5 символів.';
            } elseif (preg_match('/\d/', $login)) {
                $errors['login'] = 'Логін не може містити цифри.';
            }
        }

        $password = $data['password'] ?? '';
        if ($password === '') {
            $errors['password'] = "Пароль є обов'язковим.";
        } else {
            if (mb_strlen($password) < 5) {
                $errors['password'] = 'Пароль має бути не менше 5 символів.';
            } elseif (!preg_match('/\d/', $password)) {
                $errors['password'] = 'Пароль повинен містити хоча б одну цифру.';
            }
        }

        $passwordConfirm = $data['password_confirm'] ?? '';
        if ($passwordConfirm === '') {
            $errors['password_confirm'] = "Повторіть пароль.";
        } elseif ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Паролі не збігаються.';
        }

        $ownerName = isset($data['owner_name']) ? trim($data['owner_name']) : '';
        if ($ownerName === '') {
            $errors['owner_name'] = "ПІБ власника є обов'язковим.";
        } elseif (mb_strlen($ownerName) < 2) {
            $errors['owner_name'] = 'ПІБ має бути не менше 2 символів.';
        }

        $email = isset($data['email']) ? trim($data['email']) : '';
        if ($email === '') {
            $errors['email'] = "Email є обов'язковим.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некоректний формат email.';
        }

        $phone = isset($data['phone']) ? trim($data['phone']) : '';
        if ($phone === '') {
            $errors['phone'] = "Телефон є обов'язковим.";
        } elseif (!preg_match('/^\+?[\d\s\-\(\)]+$/', $phone)) {
            $errors['phone'] = 'Некоректний формат телефону.';
        }

        $petName = isset($data['pet_name']) ? trim($data['pet_name']) : '';
        if ($petName === '') {
            $errors['pet_name'] = "Кличка тварини є обов'язковою.";
        } elseif (mb_strlen($petName) < 2) {
            $errors['pet_name'] = 'Кличка має бути не менше 2 символів.';
        }

        $petType = isset($data['pet_type']) ? trim($data['pet_type']) : '';
        if ($petType === '') {
            $errors['pet_type'] = "Вид тварини є обов'язковим.";
        } elseif (!in_array($petType, ['dog', 'cat', 'bird', 'rabbit', 'other'])) {
            $errors['pet_type'] = 'Некоректний вид тварини.';
        }

        $petBreed = isset($data['pet_breed']) ? trim($data['pet_breed']) : '';
        if ($petBreed === '') {
            $errors['pet_breed'] = "Порода є обов'язковою.";
        }

        $petAge = isset($data['pet_age']) ? trim($data['pet_age']) : '';
        if ($petAge === '') {
            $errors['pet_age'] = "Вік тварини є обов'язковим.";
        } elseif (!is_numeric($petAge) || $petAge < 0 || $petAge > 30) {
            $errors['pet_age'] = 'Вік має бути числом від 0 до 30.';
        }

        $about = isset($data['about']) ? trim($data['about']) : '';
        if (mb_strlen($about) < 10) {
            $errors['about'] = "Додаткова інформація повинна бути не менше 10 символів.";
        }

        return $errors;
    }
}