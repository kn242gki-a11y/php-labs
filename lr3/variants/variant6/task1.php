<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/layout.php';

if (!class_exists('Programmer')) {
    class Programmer {
        public $name;
        public $language;
        public $level;
    }
}

$prog1 = new Programmer();
$prog1->name = 'Віктор Юрченко';
$prog1->language = 'PHP';
$prog1->level = 'Senior';

$prog2 = new Programmer();
$prog2->name = 'Катерина Ковальчук';
$prog2->language = 'JavaScript';
$prog2->level = 'Middle';

$prog3 = new Programmer();
$prog3->name = 'Денис Хоменко';
$prog3->language = 'Python';
$prog3->level = 'Junior';

$programmers = [
    ['obj' => $prog1, 'avatar' => 'avatar-indigo', 'initial' => 'В'],
    ['obj' => $prog2, 'avatar' => 'avatar-green', 'initial' => 'К'],
    ['obj' => $prog3, 'avatar' => 'avatar-amber', 'initial' => 'Д'],
];

ob_start();
?>

<div class="task-header">
    <h1>Створення об'єктів</h1>
    <p>Клас <code>Programmer</code> з властивостями: name, language, level</p>
</div>

<div class="code-block">
    <span class="code-comment">// Створення об'єкта</span><br>
    <span class="code-variable">$prog1</span> = <span class="code-keyword">new</span> <span class="code-class">Programmer</span>();<br>
    <span class="code-variable">$prog1</span>->name = <span class="code-string">'Віктор Юрченко'</span>;
</div>

<div class="section-divider">
    <span class="section-divider-text">Результат виводу</span>
</div>

<div class="users-grid">
    <?php foreach ($programmers as $i => $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label">Об'єкт #<?= $i + 1 ?></div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">language</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->language) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">level</span>
                <span class="user-card-field-value"><?= htmlspecialchars($data['obj']->level) ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();

if (function_exists('renderVariantLayout')) {
    renderVariantLayout($content, 'Завдання 1', 'task1-body');
} else {
    echo $content;
}