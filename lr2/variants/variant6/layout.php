<?php
/**
 * Shared layout template for LR2 Variant 6 task pages
 */

require_once dirname(__DIR__, 3) . '/shared/helpers/dev_reload.php';
require_once dirname(__DIR__, 3) . '/shared/helpers/paths.php';

/**
 * Renders the full variant page layout with fixed header
 *
 * @param string $content HTML content for the page
 * @param string $taskName Task name for title
 * @param string $bodyClass CSS class for body
 */
function renderVariantLayout(string $content, string $taskName, string $bodyClass = ''): void
{
    $currentTask = basename($_SERVER['SCRIPT_NAME']);

    $demoUrl = "/lr2/demo/{$currentTask}?from=variant6";

    // Demo tasks list for selector
    $demoTasks = [
        'task1_replace.php' => 'Рядки: Заміна',
        'task2_sort.php' => 'Рядки: Сортування',
        'task3_filename.php' => 'Рядки: Ім\'я файлу',
        'task4_dates.php' => 'Рядки: Різниця дат',
        'task5_password.php' => 'Рядки: Паролі',
        'task6_duplicates.php' => 'Масиви: Дублікати',
        'task7_animals.php' => 'Масиви: Імена тварин',
        'task8_arrays.php' => 'Масиви: Операції',
        'task9_assoc.php' => 'Масиви: Асоціативний',
        'task10_form.php' => 'Форма: Реєстрація',
        'task11_calc.php' => 'Функції: Калькулятор',
    ];
    ?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($taskName) ?> — Варіант 6 ЛР2</title>
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 3) . '/shared/css/base.css') ?>">
    <link rel="stylesheet" href="<?= webPath(dirname(__DIR__, 2) . '/demo/demo.css') ?>">
</head>

<body class="body-with-header <?= htmlspecialchars($bodyClass) ?>">
    <header class="header-fixed">
        <div class="header-left">
            <a href="/" class="header-btn">Головна</a>
            <a href="index.php" class="header-btn">← Варіант 6</a>
            <a href="<?= htmlspecialchars($demoUrl) ?>" class="header-btn header-btn-demo">Demo</a>
        </div>
        <div class="header-center"></div>
        <div class="header-right">
            <span class="header-variant-label">В-6</span>
            <select class="header-task-select" onchange="if(this.value) location.href=this.value">
                <?php foreach ($demoTasks as $file => $name): ?>
                <option value="<?= htmlspecialchars($file) ?>"
                    <?= $file === $currentTask ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </header>

    <div class="content-wrapper">
        <?= $content ?>
    </div>

    <?= devReloadScript() ?>
</body>

</html>
<?php
}
