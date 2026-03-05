<?php
/**
 * Завдання 4: Різниця дат
 * * Оновлено: додано розрахунок тижнів та днів
 * Дати за замовчуванням: 25-12-2023 та 15-08-2024
 */
require_once __DIR__ . '/layout.php';

function dateDifferenceDetails(string $date1, string $date2): array|false
{
    $d1 = DateTime::createFromFormat('d-m-Y', $date1);
    $d2 = DateTime::createFromFormat('d-m-Y', $date2);

    if (!$d1 || !$d2) {
        return false;
    }

    $interval = $d1->diff($d2);
    $totalDays = $interval->days;
    
    // Розрахунок тижнів та залишку днів
    $weeks = floor($totalDays / 7);
    $remainingDays = $totalDays % 7;

    return [
        'total_days' => $totalDays,
        'weeks' => $weeks,
        'remaining_days' => $remainingDays
    ];
}

function isValidDate(string $date): bool
{
    $d = DateTime::createFromFormat('d-m-Y', $date);
    return $d && $d->format('d-m-Y') === $date;
}

function getWeekdayUkrainian(string $date): string
{
    $days = [
        'Monday' => 'понеділок',
        'Tuesday' => 'вівторок',
        'Wednesday' => 'середа',
        'Thursday' => 'четвер',
        'Friday' => 'п\'ятниця',
        'Saturday' => 'субота',
        'Sunday' => 'неділя',
    ];
    $d = DateTime::createFromFormat('d-m-Y', $date);
    if (!$d) return '';
    return $days[$d->format('l')] ?? '';
}

// Вхідні дани з вашого прикладу
$date1 = $_POST['date1'] ?? '25-12-2023';
$date2 = $_POST['date2'] ?? '15-08-2024';
$submitted = isset($_POST['date1']);

$error = '';
$result = null;

if ($submitted) {
    if (!isValidDate($date1)) {
        $error = "Перша дата має невірний формат (ДД-ММ-РРРР)";
    } elseif (!isValidDate($date2)) {
        $error = "Друга дата має невірний формат (ДД-ММ-РРРР)";
    } else {
        $result = dateDifferenceDetails($date1, $date2);
    }
}

ob_start();
?>
<div class="demo-card">
    <h2>Різниця дат (тижні та дні)</h2>
    
    <form method="post" class="demo-form">
        <div class="form-row">
            <div>
                <label for="date1">Дата 1</label>
                <input type="text" id="date1" name="date1" value="<?= htmlspecialchars($date1) ?>">
            </div>
            <div>
                <label for="date2">Дата 2</label>
                <input type="text" id="date2" name="date2" value="<?= htmlspecialchars($date2) ?>">
            </div>
        </div>
        <button type="submit" class="btn-submit">Обчислити</button>
    </form>

    <?php if ($error): ?>
    <div class="demo-result demo-result-error">
        <div class="demo-result-value"><?= htmlspecialchars($error) ?></div>
    </div>
    <?php elseif ($result !== null): ?>
    <div class="demo-result">
        <h3>Результат:</h3>
        <div class="demo-result-value">
            <?= $result['total_days'] ?> днів 
            <small style="display:block; font-size: 0.6em; color: #666;">
                (<?= $result['weeks'] ?> тижнів і <?= $result['remaining_days'] ?> днів)
            </small>
        </div>
    </div>

    <div class="demo-section">
        <table class="demo-table">
            <tr>
                <td class="demo-table-label">Дата 1</td>
                <td><?= htmlspecialchars($date1) ?> — <?= getWeekdayUkrainian($date1) ?></td>
            </tr>
            <tr>
                <td class="demo-table-label">Дата 2</td>
                <td><?= htmlspecialchars($date2) ?> — <?= getWeekdayUkrainian($date2) ?></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 4');