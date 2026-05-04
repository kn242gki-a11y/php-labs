<?php
$regData = $regData ?? [];
?>

<div class="success-page">
    <div class="alert alert--success">
        <h2>Реєстрація успішна!</h2>
        <p>Вітаємо! <strong><?= htmlspecialchars($regData['login'] ?? '') ?></strong>!</p>
        <p>Тепер ви можете записати свого улюбленця до лікара.</p>
    </div>

    <div class="card">
        <h3>Ваші дані</h3>
        <table class="table">
            <tr>
                <td><strong>Логін:</strong></td>
                <td><?= htmlspecialchars($regData['login'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>ПІБ власника:</strong></td>
                <td><?= htmlspecialchars($regData['owner_name'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= htmlspecialchars($regData['email'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>Телефон:</strong></td>
                <td><?= htmlspecialchars($regData['phone'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>Кличка тварини:</strong></td>
                <td><?= htmlspecialchars($regData['pet_name'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>Вид тварини:</strong></td>
                <td><?php
                    $types = [
                        'dog' => 'Собака',
                        'cat' => 'Кіт',
                        'bird' => 'Птах',
                        'rabbit' => 'Кролик',
                        'other' => 'Інше'
                    ];
                    echo htmlspecialchars($types[$regData['pet_type'] ?? ''] ?? '');
                ?></td>
            </tr>
            <tr>
                <td><strong>Порода:</strong></td>
                <td><?= htmlspecialchars($regData['pet_breed'] ?? '') ?></td>
            </tr>
            <tr>
                <td><strong>Вік:</strong></td>
                <td><?= htmlspecialchars($regData['pet_age'] ?? '') ?> років</td>
            </tr>
            <tr>
                <td><strong>Додаткова інформація:</strong></td>
                <td><?= nl2br(htmlspecialchars($regData['about'] ?? '')) ?></td>
            </tr>
        </table>
    </div>

    <div class="success-page__actions">
        <a href="index.php" class="btn">На головну</a>
        <a href="index.php?route=regform/form" class="btn btn--secondary">Ще одна реєстрація</a>
    </div>
</div>
