<?php

require_once __DIR__ . '/layout.php';

function sortByName(array $people): array
{
    ksort($people);
    return $people;
}

function sortByAge(array $people): array
{
    asort($people);
    return $people;
}

$people = [
    "Зоряна" => 31,
    "Валентин" => 44,
    "Аліна" => 22,
    "Ярослав" => 57,
    "Христина" => 35,
    "Денис" => 18,
    "Мирослава" => 40,
];
$sortBy = $_POST['sort'] ?? 'name';
$sorted = ($sortBy === 'age') ? sortByAge($people) : sortByName($people);

ob_start();
?>
<div class="demo-card">
    <h2>Асоціативний масив</h2>
    <p class="demo-subtitle">Сортування за іменем (ksort) або за віком (asort)</p>

    <div class="flex-buttons" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <form method="post">
            <input type="hidden" name="sort" value="name">
            <button type="submit" class="<?= $sortBy === 'name' ? 'btn-submit' : 'btn-secondary' ?>">За іменем (А-Я)</button>
        </form>
        <form method="post">
            <input type="hidden" name="sort" value="age">
            <button type="submit" class="<?= $sortBy === 'age' ? 'btn-submit' : 'btn-secondary' ?>">За віком (1-99)</button>
        </form>
    </div>

    <div class="demo-section">
        <h3>Вхідний масив</h3>
        <div class="demo-code">$people = [
<?php foreach ($people as $name => $age): ?>
    "<?= $name ?>" => <?= $age ?>,
<?php endforeach; ?>
];</div>
    </div>

    <div class="demo-section">
        <h3>Результат: <span class="demo-tag demo-tag-primary"><?= $sortBy === 'age' ? 'за віком' : 'за іменем' ?></span></h3>
        <table class="demo-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ім'я <?= $sortBy === 'name' ? '&#8595;' : '' ?></th>
                    <th>Вік <?= $sortBy === 'age' ? '&#8595;' : '' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($sorted as $name => $age): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($name) ?></td>
                    <td><span class="demo-tag demo-tag-success"><?= $age ?> років</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="demo-code">
// Використано функцію: <?= $sortBy === 'age' ? 'asort($people)' : 'ksort($people)' ?>
// Сортування <?= $sortBy === 'age' ? 'значень (вік)' : 'ключів (імена)' ?>
    </div>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 9');