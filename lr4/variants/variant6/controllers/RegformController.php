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
                    'about' => trim($old['about'] ?? 'Не вказано'),
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

        $about = isset($data['about']) ? trim($data['about']) : '';
        if (mb_strlen($about) < 10) {
            $errors['about'] = "Опишіть вашого улюбленця детальніше (мінімум 10 символів).";
        }

        return $errors;
    }
}