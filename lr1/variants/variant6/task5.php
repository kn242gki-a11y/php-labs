<?php

require_once __DIR__ . '/layout.php';

function isVowelOrConsonant(string $letter): string
{
    switch (strtolower($letter)) {
       case 'а':
        case 'е':
        case 'є':
        case 'и':
        case 'і':
        case 'ї':
        case 'о':
        case 'у':
        case 'ю':
        case 'я':
            return "голосна";
        default:
            return "приголосна";
    }
}

$letter = 'м';

$result = isVowelOrConsonant($letter);
$isVowel = $result === "голосна";

$color = $isVowel ? "#790000" : "#4d61a9";
$emoji = $isVowel ? "🔊" : "🔇";

$content = '<div class="card large">
    <div class="letter-display" style="color:' . $color . '">' . $letter . '</div>
    <div class="letter-emoji" style="color:' . $color . '">' . $emoji . '</div>
    <div class="letter-result">
        Літера <strong>\'' . $letter . '\'</strong> — <span style="color:' . $color . '">' . $result . '</span>
    </div>
    <p class="info">isVowelOrConsonant(\'' . $letter . '\') = "' . $result . '"</p>
</div>';

renderVariantLayout($content, 'Завдання 4', 'task5-body');