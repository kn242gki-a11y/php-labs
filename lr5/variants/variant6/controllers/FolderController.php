<?php

class FolderController extends PageController
{
    private string $usersDir;

    public function __construct()
    {
        parent::__construct();
        $this->usersDir = DATA_DIR . '/users';

        if (!is_dir($this->usersDir)) {
            mkdir($this->usersDir, 0755, true);
        }
    }

    public function action_create(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = trim($this->request->post('password', ''));

            if ($login === '' || $password === '') {
                $error = 'Логін та пароль є обов\'язковими.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{1,64}$/', $login)) {
                $error = 'Логін: 1-64 символи (латинські літери, цифри, _).';
            } else {
                $userDir = $this->usersDir . '/' . $login;

                if (is_dir($userDir)) {
                    $error = "Папка для користувача \"{$login}\" вже існує!";
                } else {
                    mkdir($userDir, 0755, true);

                    $subfolders = ['video', 'music', 'photo'];
                    foreach ($subfolders as $sub) {
                        $subPath = $userDir . '/' . $sub;
                        mkdir($subPath, 0755, true);

                        // Create sample files
                        file_put_contents($subPath . '/readme.txt', "Папка {$sub} користувача {$login}\nСтворено: " . date('Y-m-d H:i'));
                        file_put_contents($subPath . '/example_1.txt', "Приклад файлу 1 в {$sub}");
                        file_put_contents($subPath . '/example_2.txt', "Приклад файлу 2 в {$sub}");
                    }

                    // Save password hash
                    file_put_contents($userDir . '/.password', password_hash($password, PASSWORD_DEFAULT));

                    $message = "Папку \"{$login}\" створено з підпапками video, music, photo!";
                }
            }
        }

        $folders = $this->getUserFolders();

        $this->render('folder/create', [
            'message' => $message,
            'error' => $error,
            'folders' => $folders,
        ], 'Створення каталогу');
    }

    public function action_delete(): void
    {
        $message = '';
        $error = '';

        if ($this->request->isPost()) {
            $login = trim($this->request->post('login', ''));
            $password = trim($this->request->post('password', ''));

            if ($login === '' || $password === '') {
                $error = 'Логін та пароль є обов\'язковими.';
            } elseif (!preg_match('/^[a-zA-Z0-9_]{1,64}$/', $login)) {
                $error = 'Логін: 1-64 символи (латинські літери, цифри, _).';
            } else {
                $userDir = $this->usersDir . '/' . $login;

                if (!is_dir($userDir)) {
                    $error = "Папку \"{$login}\" не знайдено.";
                } else {
                    $hashFile = $userDir . '/.password';
                    if (!file_exists($hashFile)) {
                        $error = 'Файл паролю не знайдено.';
                    } elseif (!password_verify($password, file_get_contents($hashFile))) {
                        $error = 'Невірний пароль.';
                    } else {
                        $this->deleteDirectory($userDir);
                        $message = "Папку \"{$login}\" з усім вмістом видалено!";
                    }
                }
            }
        }

        $this->render('folder/delete', [
            'message' => $message,
            'error' => $error,
        ], 'Видалення каталогу');
    }

    private function getUserFolders(): array
    {
        $folders = [];
        $dirs = glob($this->usersDir . '/*', GLOB_ONLYDIR);

        if ($dirs) {
            foreach ($dirs as $dir) {
                $name = basename($dir);
                $subfolders = [];
                $subDirs = glob($dir . '/*', GLOB_ONLYDIR);
                if ($subDirs) {
                    foreach ($subDirs as $subDir) {
                        $subName = basename($subDir);
                        $fileCount = count(glob($subDir . '/*'));
                        $subfolders[] = ['name' => $subName, 'files' => $fileCount];
                    }
                }
                $folders[] = ['name' => $name, 'subfolders' => $subfolders];
            }
        }

        return $folders;
    }

    public function action_browse(): void
    {
        $message = '';
        $error = '';
        $authenticated = false;
        $login = '';
        $userDir = '';
        $subfolder = '';
        $files = [];
        $subfolders = [];

        if ($this->request->isPost() && !isset($_GET['folder'])) {
            $login = trim($this->request->post('login', ''));
            $password = trim($this->request->post('password', ''));

            if ($login === '' || $password === '') {
                $error = 'Логін та пароль є обов\'язковими.';
            } else {
                $userDir = $this->usersDir . '/' . $login;
                $hashFile = $userDir . '/.password';

                if (!file_exists($hashFile)) {
                    $error = 'Цей каталог не існує.';
                } elseif (!password_verify($password, file_get_contents($hashFile))) {
                    $error = 'Невірний пароль.';
                } else {
                    $authenticated = true;
                    $_SESSION['folder_login'] = $login;
                    $_SESSION['folder_auth'] = true;
                }
            }
        } elseif (isset($_SESSION['folder_auth']) && isset($_SESSION['folder_login'])) {
            $authenticated = true;
            $login = $_SESSION['folder_login'];
            $userDir = $this->usersDir . '/' . $login;
        }

        if ($authenticated && $userDir) {
            $subfolder = trim($this->request->get('folder', ''));

            // Security: prevent directory traversal
            if ($subfolder && !preg_match('/^[a-zA-Z0-9_-]+$/', $subfolder)) {
                $error = 'Невірна назва підпапки.';
                $subfolder = '';
            }

            if ($subfolder) {
                $folderPath = $userDir . '/' . $subfolder;
                if (!is_dir($folderPath)) {
                    $error = 'Папка не знайдена.';
                } else {
                    // List files in subfolder
                    $items = glob($folderPath . '/*');
                    foreach ($items as $item) {
                        if (is_file($item)) {
                            $files[] = [
                                'name' => basename($item),
                                'size' => filesize($item),
                                'modified' => filemtime($item),
                            ];
                        }
                    }
                    usort($files, fn($a, $b) => $b['modified'] - $a['modified']);
                }
            } else {
                // List subfolders
                $subDirs = glob($userDir . '/*', GLOB_ONLYDIR);
                if ($subDirs) {
                    foreach ($subDirs as $subDir) {
                        $name = basename($subDir);
                        if ($name !== '.' && $name !== '..' && !str_starts_with($name, '.')) {
                            $fileCount = count(glob($subDir . '/*', GLOB_BRACE));
                            $subfolders[] = [
                                'name' => $name,
                                'files' => $fileCount,
                            ];
                        }
                    }
                }
            }
        }

        // Handle logout
        if (isset($_GET['logout'])) {
            unset($_SESSION['folder_auth']);
            unset($_SESSION['folder_login']);
            $message = 'Вихід виконано.';
            $authenticated = false;
        }

        // Handle file upload
        if ($authenticated && $subfolder && $this->request->isPost() && isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $folderPath = $userDir . '/' . $subfolder;
                $fileName = basename($file['name']);

                // Sanitize filename
                $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

                if (strlen($fileName) > 255) {
                    $fileName = substr($fileName, 0, 255);
                }

                $targetPath = $folderPath . '/' . $fileName;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $message = "Файл \"{$fileName}\" завантажено успішно!";
                } else {
                    $error = 'Помилка завантаження файлу.';
                }
            } else {
                $error = 'Помилка завантаження: ' . $this->getUploadErrorMessage($file['error']);
            }
        }

        // Handle file deletion
        if ($authenticated && $subfolder && isset($_GET['delete'])) {
            $fileName = trim($_GET['delete']);
            if ($fileName && preg_match('/^[a-zA-Z0-9._-]+$/', $fileName)) {
                $filePath = $userDir . '/' . $subfolder . '/' . $fileName;

                if (file_exists($filePath) && is_file($filePath)) {
                    if (unlink($filePath)) {
                        $message = "Файл \"{$fileName}\" видалено.";
                        // Reload file list
                        header('Location: index.php?route=folder/browse&folder=' . urlencode($subfolder));
                        exit;
                    }
                }
            }
        }

        $this->render('folder/browse', [
            'authenticated' => $authenticated,
            'login' => $login,
            'message' => $message,
            'error' => $error,
            'subfolder' => $subfolder,
            'files' => $files,
            'subfolders' => $subfolders,
        ], 'Перегляд каталогу');
    }

    public function action_download(): void
    {
        // Check authentication
        if (!isset($_SESSION['folder_auth']) || !isset($_SESSION['folder_login'])) {
            http_response_code(403);
            echo 'Доступ заборонено.';
            exit;
        }

        $login = $_SESSION['folder_login'];
        $subfolder = trim($this->request->get('folder', ''));
        $fileName = trim($this->request->get('file', ''));

        // Security validation
        if (!$subfolder || !preg_match('/^[a-zA-Z0-9_-]+$/', $subfolder)) {
            http_response_code(400);
            echo 'Невірна папка.';
            exit;
        }

        if (!$fileName || !preg_match('/^[a-zA-Z0-9._-]+$/', $fileName)) {
            http_response_code(400);
            echo 'Невірна назва файлу.';
            exit;
        }

        $filePath = $this->usersDir . '/' . $login . '/' . $subfolder . '/' . $fileName;

        // Additional security check: ensure file is within user directory
        if (!file_exists($filePath) || !is_file($filePath)) {
            http_response_code(404);
            echo 'Файл не знайдено.';
            exit;
        }

        // Ensure it's in the right directory (no directory traversal)
        $realPath = realpath($filePath);
        $userDir = realpath($this->usersDir . '/' . $login);
        if (!$userDir || strpos($realPath, $userDir) !== 0) {
            http_response_code(403);
            echo 'Доступ заборонено.';
            exit;
        }

        // Send file
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    private function getUploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE => 'Розмір файлу перевищує максимальний.',
            UPLOAD_ERR_FORM_SIZE => 'Розмір файлу перевищує максимальний.',
            UPLOAD_ERR_PARTIAL => 'Файл завантажено частково.',
            UPLOAD_ERR_NO_FILE => 'Файл не вибрано.',
            UPLOAD_ERR_NO_TMP_DIR => 'Тимчасова папка недоступна.',
            UPLOAD_ERR_CANT_WRITE => 'Не вдалося записати файл на диск.',
            default => 'Невідома помилка.',
        };
    }

    protected function formatBytes(int $size, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = max($size, 0);
        $pow = floor(($size ? log($size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $size /= (1 << (10 * $pow));
        return round($size, $precision) . ' ' . $units[$pow];
    }

    private function deleteDirectory(string $dir): void
    {
        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($items as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        rmdir($dir);
    }
}
