<?php

require_once __DIR__ . '/layout.php';

function generatePassword(int $length = 9): string
{
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $digits = '0123456789';
    $special = '!@#$%^&*()-_=+';
    $all = $upper . $lower . $digits . $special;

    $password = '';
    $password .= $upper[random_int(0, strlen($upper) - 1)];
    $password .= $lower[random_int(0, strlen($lower) - 1)];
    $password .= $digits[random_int(0, strlen($digits) - 1)];
    $password .= $special[random_int(0, strlen($special) - 1)];

    for ($i = 4; $i < $length; $i++) {
        $password .= $all[random_int(0, strlen($all) - 1)];
    }

    return str_shuffle($password);
}

function checkPasswordStrength(string $password): array
{
    $checks = [
        'length' => ['label' => 'Довжина >= 8', 'passed' => strlen($password) >= 8],
        'upper'  => ['label' => 'Велика літера', 'passed' => (bool)preg_match('/[A-Z]/', $password)],
        'lower'  => ['label' => 'Мала літера', 'passed' => (bool)preg_match('/[a-z]/', $password)],
        'digit'  => ['label' => 'Цифра', 'passed' => (bool)preg_match('/[0-9]/', $password)],
        'special'=> ['label' => 'Спецсимвол (!@#$%^&*()-_=+)', 'passed' => (bool)preg_match('/[!@#$%^&*()\-_=+]/', $password)],
    ];

    $score = array_reduce($checks, fn($acc, $check) => $acc + ($check['passed'] ? 1 : 0), 0);

    return [
        'score' => $score,
        'checks' => $checks,
        'password' => $password
    ];
}

$action = $_POST['action'] ?? '';
$bestResult = null;
$allAttempts = [];

if ($action === 'generate') {
    for ($i = 0; $i < 3; $i++) {
        $pass = generatePassword(9);
        $res = checkPasswordStrength($pass);
        $allAttempts[] = $res;
        
        if ($bestResult === null || $res['score'] > $bestResult['score']) {
            $bestResult = $res;
        }
    }
}

ob_start();
?>
<div class="demo-card">
    <h2>Генератор найкращого пароля</h2>
    <p class="demo-subtitle">Довжина: 9. Система генерує 3 паролі та обирає найсильніший за критеріями (0-5 балів).</p>

    <form method="post" class="demo-form">
        <input type="hidden" name="action" value="generate">
        <button type="submit" class="btn-submit">Згенерувати та обрати найкращий</button>
    </form>

    <?php if ($bestResult): ?>
    <div class="demo-grid-2 mt-15">
        <div class="demo-panel">
            <h3 class="demo-panel-title-primary">Варіанти (згенеровано 3)</h3>
            <ul class="demo-list">
                <?php foreach ($allAttempts as $attempt): ?>
                <li style="margin-bottom: 10px;">
                    <code class="demo-mono"><?= htmlspecialchars($attempt['password']) ?></code> 
                    — <strong><?= $attempt['score'] ?> б.</strong>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="demo-panel">
            <h3 class="demo-panel-title-success">Найкращий пароль</h3>
            <div class="demo-result">
                <div class="demo-result-value demo-mono" style="color: #2e7d32;">
                    <?= htmlspecialchars($bestResult['password']) ?>
                </div>
                <div class="mt-15">
                    <strong>Складність: <?= $bestResult['score'] ?> / 5</strong>
                </div>
            </div>

            <table class="demo-table mt-15">
                <?php foreach ($bestResult['checks'] as $check): ?>
                <tr>
                    <td><?= $check['label'] ?></td>
                    <td>
                        <span class="demo-tag <?= $check['passed'] ? 'demo-tag-success' : 'demo-tag-error' ?>">
                            <?= $check['passed'] ? '✓' : '✗' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="demo-code">
// Логіка:
// 1. Сгенеровано 3 паролі довжиною 9
// 2. Виконано перевірку regex для кожного
// 3. Обрано пароль з max(score): <?= $bestResult['score'] ?>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 5');