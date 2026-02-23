<?php

require_once __DIR__ . '/layout.php';

function determineSeason(int $month): string
{
    if ($month >= 3 && $month <= 5) {
        return "весна";
    } elseif ($month >= 6 && $month <= 8) {
        return "літо";
    } elseif ($month >= 9 && $month <= 11) {
        return "осінь";
    } else {
        return "зима";
    }
}

function daysInMonth(int $month, int $year = 2025): int
{
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}
$month = 8;

$season = determineSeason($month);
$days = daysInMonth($month);

$monthNames = [
    1 => "Січень", 2 => "Лютий", 3 => "Березень",
    4 => "Квітень", 5 => "Травень", 6 => "Червень",
    7 => "Липень", 8 => "Серпень", 9 => "Вересень",
    10 => "Жовтень", 11 => "Листопад", 12 => "Грудень"
];

$styles = [
    "весна" => ["class" => "spring", "color" => "#1bff49", "emoji" => "🌸"],
    "літо"  => ["class" => "summer", "color" => "#ffed26", "emoji" => "☀️"],
    "осінь" => ["class" => "autumn", "color" => "#dc4d2a", "emoji" => "🍂"],
    "зима"  => ["class" => "winter", "color" => "#7ec3ff", "emoji" => "❄️"],
];

$style = $styles[$season];

$content = '<div class="card large">
    <div class="season-emoji">' . $style['emoji'] . '</div>
    <div class="season-month" style="color:' . $style['color'] . '">Місяць ' . $month . '</div>
    <div class="season-month-name">' . $monthNames[$month] . '</div>
    <div class="season-result">' . $season . '</div>
    <div class="result mt-15">Днів у місяці: <strong>' . $days . '</strong></div>
    <p class="info">determineSeason(' . $month . ') = "' . $season . '"</p>
    <p class="info">daysInMonth(' . $month . ') = ' . $days . '</p>
</div>';

renderVariantLayout($content, 'Завдання 3', 'task4-body ' . $style['class']);