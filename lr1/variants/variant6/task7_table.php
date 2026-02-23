<?php

require_once __DIR__ . '/layout.php';

function generateRandomTable(int $rows, int $cols): string
{
    $html = "<table class='chessboard'>";
    for ($i = 0; $i < $rows; $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < $cols; $j++) {
            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $html .= "<td style='background-color:{$randomColor}; width:40px; height:40px;'></td>";
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}

$rows = 5;
$cols = 7;

$table = generateRandomTable($rows, $cols);

$content = '
    <h1>🎨 Кольорова таблиця ' . $rows . 'x' . $cols . '</h1>
    <div class="params">generateRandomTable(' . $rows . ', ' . $cols . ')</div>
    <div style="display:flex; justify-content:center; margin-top:20px;">' . $table . '</div>
    <p class="circles-info" style="text-align:center; margin-top:10px;">Кожна комірка має унікальний колір 🌈</p>';

renderVariantLayout($content, 'Завдання 6.1', 'task7-table-body');