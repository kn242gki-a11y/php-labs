<?php
/**
 * Завдання 2: Методи об'єкта
 * Клас Programmer та метод getInfo()
 */

require_once __DIR__ . '/layout.php';

// --- Визначення класу ---
class Programmer
{
    public string $name;
    public string $language;
    public string $level;

    /**
     * Метод getInfo() повертає рядок з інформацією про програміста
     */
    public function getInfo(): string
    {
        return "Програміст: {$this->name}, Мова: {$this->language}, Рівень: {$this->level}";
    }
}

// --- Логіка створення об'єктів ---
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

$programmers = [$programmer1, $programmer2, $programmer3];
$labels = ['$programmer1', '$programmer2', '$programmer3'];

ob_start();
?>

<div class="task-header">
    <h1>Метод getInfo()</h1>
    <p>Вивід властивостей об'єкта через метод класу</p>
</div>

<div class="code-block">
    <span class="code-comment">// Реалізація методу getInfo()</span><br>
    <span class="code-keyword">public function</span> <span class="code-method">getInfo</span>(): <span class="code-class">string</span><br>
    {<br>
    &nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">return</span> <span class="code-string">"Програміст: {$this->name}, Мова: {$this->language}, Рівень: {$this->level}"</span>;<br>
    }
</div>

<div class="section-divider">
    <span class="section-divider-text">Картки програмістів</span>
</div>

<div class="users-grid">
    <?php
    $avatars = ['avatar-indigo', 'avatar-green', 'avatar-amber'];
    $initials = ['ВЮ', 'КК', 'ДХ'];
    
    foreach ($programmers as $i => $prog):
    ?>
    <div class="user-card">
        <div class="user-card-header">
            <div class="user-card-avatar <?= $avatars[$i] ?>"><?= $initials[$i] ?></div>
            <div>
                <div class="user-card-name"><?= htmlspecialchars($prog->name) ?></div>
                <div class="user-card-label"><?= $labels[$i] ?>->getInfo()</div>
            </div>
        </div>
        <div class="user-card-body">
            <div class="user-card-field">
                <span class="user-card-field-label">name</span>
                <span class="user-card-field-value"><?= htmlspecialchars($prog->name) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">language</span>
                <span class="user-card-field-value"><?= htmlspecialchars($prog->language) ?></span>
            </div>
            <div class="user-card-field">
                <span class="user-card-field-label">level</span>
                <span class="user-card-field-value"><?= htmlspecialchars($prog->level) ?></span>
            </div>
            <div class="user-card-field" style="margin-top: 10px; border-top: 1px solid #eee; pt-2;">
                <span class="user-card-field-label">getInfo() result:</span>
                <div style="font-size: 0.85em; color: #555; margin-top: 4px;">
                    <?= htmlspecialchars($prog->getInfo()) ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 2: Програмісти', 'task2-body');