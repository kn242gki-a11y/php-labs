<?php
require_once __DIR__ . '/layout.php';

function convertUahToEur(float $uah, float $rate): float
{
    return round($uah / $rate, 2);
}

$uah = 42000;
$rate = 41.90;

$eurResult = convertUahToEur($uah, $rate);

$content = '<div class="card">
    <h2>Конвертер UAH → EUR</h2>
    <p><strong>Сума:</strong> ' . number_format($uah, 2, '.', ' ') . ' грн</p>
    <p><strong>Курс:</strong> 1 EUR = ' . $rate . ' грн</p>
    
    <div class="result" style="font-size: 1.2rem; color: #2c3e50; margin: 15px 0;">
        <strong>Результат:</strong> ' . $eurResult . ' євро
    </div>
    
    <hr>
    <p class="info" style="font-style: italic; color: #666;">
        Виклик функції: convertUahToEur(' . $uah . ', ' . $rate . ') = ' . $eurResult . '
    </p>
</div>';

renderVariantLayout($content, 'Завдання 2', 'task2-body');
