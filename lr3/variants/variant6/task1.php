<?php

require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Programmer.php';

$programmer1 = new Programmer();
$programmer1->name = 'Віктор Юрченко';
$programmer1->language = 'PHP';
$programmer1->level = 'Senior';

$programmer2 = new Programmer();
$programmer2->name = 'Катерина Ковальчук';
$programmer2->language = 'JavaScript';
$programmer2->level = 'Middle';

$programmer3 = new Programmer();
$programmer3->name = 'Денис Хоменко';
$programmer3->language = 'Python';
$programmer3->level = 'Junior';

$programmers = [
    ['obj' => $programmer1, 'avatar' => 'avatar-indigo', 'initial' => 'В'],
    ['obj' => $programmer2, 'avatar' => 'avatar-green', 'initial' => 'К'],
    ['obj' => $programmer3, 'avatar' => 'avatar-amber', 'initial' => 'Д'],
];

ob_start();
?>

<div class="task-header">
    <h1>Створення об'єктів</h1>
    <p>Клас <code>Programmer</code> з властивостями: name, language, level</p>
</div>

<div class="code-block">
    <span class="code-comment">// Приклад створення одного з об'єктів</span><br>
    <span class="code-variable">$programmer1</span> = <span class="code-keyword">new</span> <span class="code-class">Programmer</span>();<br>
    <span class="code-variable">$programmer1</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">'Віктор Юрченко'</span>;<br>
    <span class="code-variable">$programmer1</span><span class="code-arrow">-></span><span class="code-method">language</span> = <span class="code-string">'PHP'</span>;<br>
    <span class="code-variable">$programmer1</span><span class="code-arrow">-></span><span class="code-method">level</span> = <span class="code-string">'Senior'</span>;
</div>

<div class="section-divider">
    <span class="section-divider-text">Результат: 3 об'єкти Programmer</span>
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
renderVariantLayout($content, 'Завдання 1: Класи та об\'єкти', 'task1-body');