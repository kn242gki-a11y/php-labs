<?php

require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Programmer.php';

$programmer1 = new Programmer('Віктор Юрченко', 'PHP', 'Senior');
$programmer2 = new Programmer('Катерина Ковальчук', 'JavaScript', 'Middle');
$programmer3 = new Programmer('Денис Хоменко', 'Python', 'Junior');

$programmers = [
    ['obj' => $programmer1, 'avatar' => 'avatar-indigo', 'initial' => 'В', 'var' => '$programmer1'],
    ['obj' => $programmer2, 'avatar' => 'avatar-green', 'initial' => 'К', 'var' => '$programmer2'],
    ['obj' => $programmer3, 'avatar' => 'avatar-amber', 'initial' => 'Д', 'var' => '$programmer3'],
];

ob_start();
?>

<div class="task-header">
    <h1>Конструктор</h1>
    <p>Початкові значення задаються одразу при створенні об'єкта класу Programmer</p>
</div>

<div class="code-block">
<span class="code-comment">// Конструктор класу Programmer</span>
<span class="code-keyword">public function</span> <span class="code-method">__construct</span>(<span class="code-class">string</span> <span class="code-variable">$name</span>, <span class="code-class">string</span> <span class="code-variable">$language</span>, <span class="code-class">string</span> <span class="code-variable">$level</span>)
{
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-variable">$name</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">language</span> = <span class="code-variable">$language</span>;
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">level</span> = <span class="code-variable">$level</span>;
}

<span class="code-comment">// Створення об'єктів одним рядком</span>
<span class="code-variable">$programmer1</span> = <span class="code-keyword">new</span> <span class="code-class">Programmer</span>(<span class="code-string">'Віктор Юрченко'</span>, <span class="code-string">'PHP'</span>, <span class="code-string">'Senior'</span>);
<span class="code-variable">$programmer2</span> = <span class="code-keyword">new</span> <span class="code-class">Programmer</span>(<span class="code-string">'Катерина Ковальчук'</span>, <span class="code-string">'JavaScript'</span>, <span class="code-string">'Middle'</span>);
<span class="code-variable">$programmer3</span> = <span class="code-keyword">new</span> <span class="code-class">Programmer</span>(<span class="code-string">'Денис Хоменко'</span>, <span class="code-string">'Python'</span>, <span class="code-string">'Junior'</span>);
</div>

<div class="section-divider">
    <span class="section-divider-text">Об'єкти створені через конструктор</span>
</div>

<div class="users-grid">
    <?php foreach ($programmers as $data): ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $data['avatar'] ?>"><?= $data['initial'] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($data['obj']->name) ?></div>
                <div class="user-card-label"><?= $data['var'] ?> <span class="user-card-badge badge-constructor">constructor</span></div>
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

<div class="section-divider">
    <span class="section-divider-text">Виклик getInfo()</span>
</div>

<div class="info-output">
    <div class="info-output-header">Результати роботи методу</div>
    <div class="info-output-body">
        <?php foreach ($programmers as $data): ?>
        <div class="info-output-row">
            <span class="info-output-label"><?= $data['var'] ?></span>
            <span class="info-output-text"><?= htmlspecialchars($data['obj']->getInfo()) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 3: Конструктор', 'task3-body');