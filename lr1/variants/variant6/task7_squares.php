<?php

require_once __DIR__ . '/layout.php';

function generateRedSquares(int $n): string
{
    $html = "<div class='shapes-container' style='background:#111; display:flex; flex-wrap:wrap; gap:15px; padding:20px; align-content: flex-start;'>";

    for ($i = 0; $i < $n; $i++) {
        $size = 60; 
        $html .= "<div style='
            width:{$size}px;
            height:{$size}px;
            background:#ef4444;
            border: 1px solid #fff;
        '></div>";
    }

    $html .= "</div>";
    return $html;
}

$n = 12; 
$squares = generateRedSquares($n);

$content = $squares . '
    <div class="circles-func">generateRedSquares(' . $n . ')</div>
    <div class="circles-counter">🟥 Квадратів: ' . $n . ' (по 5 у рядку)</div>
    <p class="circles-info">Цикл For згенерував сітку елементів 🔄</p>';

renderVariantLayout($content, 'Завдання 6', 'task7-circles-body');