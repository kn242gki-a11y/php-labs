<?php

require_once __DIR__ . '/layout.php';

function findDuplicates(array $arr): array
{
    if (empty($arr)) {
        return [];
    }

    $counts = array_count_values($arr);
    $duplicates = [];

    foreach ($counts as $value => $count) {
        if ($count > 1) {
            $duplicates[] = $value;
        }
    }

    return $duplicates;
}

$input = $_POST['array'] ?? '17, 3, 11, 5, 17, 3, 8, 11, 21, 5, 13';
$submitted = isset($_POST['array']);

$arr = array_map('trim', explode(',', $input));
$arr = array_filter($arr, fn($v) => $v !== '');

$duplicates = findDuplicates($arr);

ob_start();
?>
<div class="demo-card">
    <h2>Пошук дублікатів</h2>
    <p class="demo-subtitle">Виводить список елементів, які зустрічаються в масиві два або більше разів</p>

    <form method="post" class="demo-form">
        <div>
            <label for="array">Введіть числа (через кому)</label>
            <input type="text" id="array" name="array" value="<?= htmlspecialchars($input) ?>" placeholder="17, 3, 11, 5...">
        </div>
        <button type="submit" class="btn-submit">Знайти дублікати</button>
    </form>

    <?php if (!empty($arr)): ?>
    <div class="demo-section">
        <h3>Вхідний масив</h3>
        <div class="array-display">
            <?php foreach ($arr as $item): ?>
            <span class="array-item <?= in_array($item, $duplicates) ? 'array-item-unique' : '' ?>">
                <?= htmlspecialchars($item) ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="demo-result">
        <h3>Виявлені дублікати</h3>
        <?php if (!empty($duplicates)): ?>
            <div class="demo-result-value">[<?= implode(', ', $duplicates) ?>]</div>
            <p class="mt-15">Всього знайдено: <?= count($duplicates) ?> унікальних значень, що повторюються.</p>
        <?php else: ?>
            <div class="demo-result-value">Дублікатів не знайдено</div>
        <?php endif; ?>
    </div>

    <div class="demo-section">
        <h3>Детальна статистика частоти</h3>
        <table class="demo-table">
            <thead>
                <tr>
                    <th>Елемент</th>
                    <th>Кількість повторів</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counts = array_count_values($arr);
                foreach ($counts as $value => $count):
                ?>
                <tr>
                    <td><?= htmlspecialchars($value) ?></td>
                    <td><?= $count ?></td>
                    <td>
                        <?php if ($count > 1): ?>
                        <span class="demo-tag demo-tag-error">Дублікат</span>
                        <?php else: ?>
                        <span class="demo-tag demo-tag-primary">Унікальний</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="demo-code">
// Логіка роботи:
// findDuplicates([<?= htmlspecialchars(implode(', ', $arr)) ?>])
// Результат: [<?= implode(', ', $duplicates) ?>]
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 6');