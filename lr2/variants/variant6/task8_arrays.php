<?php

require_once __DIR__ . '/layout.php';

function createArray(): array
{
    $length = random_int(3, 7);
    $arr = [];
    for ($i = 0; $i < $length; $i++) {
        $arr[] = random_int(10, 20);
    }
    return $arr;
}

function processArrays(array $a, array $b): array
{
    $merged = array_merge($a, $b);
    $unique = array_unique($merged);
    sort($unique);
    return array_values($unique);
}

$arr1 = createArray();
$arr2 = createArray();

$result = processArrays($arr1, $arr2);

ob_start();
?>
<div class="demo-card demo-card-wide">
    <h2>Операції з масивами</h2>
    <p class="demo-subtitle">Об'єднання, видалення дублікатів (array_unique) та сортування (sort)</p>

    <form method="post" class="demo-form">
        <button type="submit" name="regenerate" class="btn-submit">Згенерувати нові масиви</button>
    </form>

    <div class="demo-section">
        <h3>Масив 1 (довжина 3-7)</h3>
        <div class="array-display">
            <?php foreach ($arr1 as $v): ?>
            <span class="array-item"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="demo-section">
        <h3>Масив 2 (довжина 3-7)</h3>
        <div class="array-display">
            <?php foreach ($arr2 as $v): ?>
            <span class="array-item"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="array-arrow">&#8595; Об'єднання + Унікальність + Сортування</div>

    <div>
        <h3 class="demo-section-title-success">Результат (без дублікатів, за зростанням)</h3>
        <?php if (!empty($result)): ?>
        <div class="array-display">
            <?php foreach ($result as $v): ?>
            <span class="array-item array-item-unique"><?= $v ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="demo-code">
$a = [<?= implode(', ', $arr1) ?>];
$b = [<?= implode(', ', $arr2) ?>];
$result = processArrays($a, $b);

// array_merge → array_unique → sort
// Результат: [<?= implode(', ', $result) ?>]
    </div>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 8');