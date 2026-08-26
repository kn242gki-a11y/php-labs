<?php

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->initDatabase();
    }

    public function run(): void
    {
        $route = $this->router->parseRoute();

        $controllerName = ucfirst($route['controller']) . 'Controller';
        $actionName = 'action_' . $route['action'];

        if (!class_exists($controllerName)) {
            $this->show404("Контролер '{$route['controller']}' не знайдено.");
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            $this->show404("Дію '{$route['action']}' не знайдено в контролері '{$route['controller']}'.");
            return;
        }

        $controller->$actionName();
    }

    private function initDatabase(): void
    {
        $dbPath = ROOT_DIR . '/database/app.db';
        $db = Database::getInstance();

        if (!file_exists($dbPath)) {
            $schemaPath = ROOT_DIR . '/database/schema.sql';
            if (file_exists($schemaPath)) {
                $db->exec(file_get_contents($schemaPath));
            }
        }

        // Додаємо поле ролі до бази, створеної старою версією застосунку.
        $columns = $db->query('PRAGMA table_info(users)')->fetchAll();
        $hasRole = false;
        foreach ($columns as $column) {
            if (($column['name'] ?? '') === 'role') {
                $hasRole = true;
                break;
            }
        }
        if (!$hasRole) {
            $db->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user'");
        }

        $animalColumns = $db->query('PRAGMA table_info(animals)')->fetchAll();
        $hasOwnerId = false;
        foreach ($animalColumns as $column) {
            if (($column['name'] ?? '') === 'owner_id') {
                $hasOwnerId = true;
                break;
            }
        }
        if (!$hasOwnerId) {
            $db->exec('ALTER TABLE animals ADD COLUMN owner_id INTEGER');
        }

        $db->exec(
            'CREATE TABLE IF NOT EXISTS fundraisers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                organizer_name VARCHAR(150) NOT NULL,
                animal_name VARCHAR(100) NOT NULL,
                title VARCHAR(150) NOT NULL,
                description TEXT DEFAULT "",
                target_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
                collected_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
                status VARCHAR(20) DEFAULT "active",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );

        $fundraiserCount = (int)$db->query('SELECT COUNT(*) FROM fundraisers')->fetchColumn();
        if ($fundraiserCount === 0) {
            $db->exec(
                "INSERT INTO fundraisers (organizer_name, animal_name, title, description, target_amount, collected_amount, status) VALUES
                ('Марія Коваль', 'Барон', 'Допомога на операцію Барону', 'Потрібні кошти на операцію та відновлення після травми.', 25000, 15750, 'active'),
                ('Іван Петренко', 'Мурка', 'Лікування Мурки', 'Збір на обстеження, ліки та курс лікування.', 12000, 8400, 'active'),
                ('Олена Іванівна', 'Рижик', 'Підтримка притулку', 'Допомога на харчування та вакцинацію тварин притулку.', 18000, 6300, 'active')"
            );
        }
    }

    private function show404(string $message): void
    {
        http_response_code(404);
        $view = new PageView();
        $view->setTitle('404 — Сторінку не знайдено');
        $view->render('layout/404', ['message' => $message]);
    }
}
