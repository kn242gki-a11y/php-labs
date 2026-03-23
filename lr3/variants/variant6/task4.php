<?php
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/Programmer.php';

$programmer3 = new Programmer('Денис Хоменко', 'Python', 'Junior');

$programmer4 = clone $programmer3;

ob_start();
?>

<div class="task-header">
    <h1>Клонування</h1>
    <p>Метод <code>__clone()</code> задає значення за замовчанням при копіюванні об'єкта</p>
</div>

<div class="code-block">
<span class="code-comment">// Метод __clone() у класі Programmer</span><br>
<span class="code-keyword">public function</span> <span class="code-method">__clone</span>(): <span class="code-class">void</span><br>
{<br>
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">name</span> = <span class="code-string">"Програміст"</span>;<br>
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">language</span> = <span class="code-string">""</span>;<br>
    <span class="code-variable">$this</span><span class="code-arrow">-></span><span class="code-method">level</span> = <span class="code-string">""</span>;<br>
}<br><br>
<span class="code-comment">// Створюємо 4-й об'єкт через clone</span><br>
<span class="code-variable">$programmer4</span> = <span class="code-keyword">clone</span> <span class="code-variable">$programmer3</span>;
</div>

<div class="section-divider">
    <span class="section-divider-text">Оригінал vs Клон</span>
</div>

<div class="comparison-wrapper">
    <div class="users-grid">
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-amber">Д</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($programmer3->name) ?></div>
                    <div class="user-card-label">$programmer3 <span class="user-card-badge badge-constructor">original</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($programmer3->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">language</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($programmer3->language) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">level</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($programmer3->level) ?></span>
                </div>
            </div>
        </div>

        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar avatar-rose">П</div>
                <div>
                    <div class="user-card-name"><?= htmlspecialchars($programmer4->name) ?></div>
                    <div class="user-card-label">$programmer4 <span class="user-card-badge badge-clone">clone</span></div>
                </div>
            </div>
            <div class="user-card-body">
                <div class="user-card-field">
                    <span class="user-card-field-label">name</span>
                    <span class="user-card-field-value"><?= htmlspecialchars($programmer4->name) ?></span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">language</span>
                    <span class="user-card-field-value">—</span>
                </div>
                <div class="user-card-field">
                    <span class="user-card-field-label">level</span>
                    <span class="user-card-field-value">—</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-divider">
    <span class="section-divider-text">getInfo() порівняння</span>
</div>

<div class="info-output">
    <div class="info-output-header">Результат методу для оригіналу та клону</div>
    <div class="info-output-body">
        <div class="info-output-row">
            <span class="info-output-label">$programmer3</span>
            <span class="info-output-text"><?= htmlspecialchars($programmer3->getInfo()) ?></span>
        </div>
        <div class="info-output-row">
            <span class="info-output-label">$programmer4</span>
            <span class="info-output-text"><?= htmlspecialchars($programmer4->getInfo()) ?></span>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4: Клонування', 'task4-body');