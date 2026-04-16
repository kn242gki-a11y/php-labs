<?php
$requests = $requests ?? [];
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Швидка ветеринарна допомога</h1>
<p>Екстрена ветеринарна допомога 24/7. Середній час відповіді: 30 хвилин.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<h2>Подати запит на екстрену допомогу</h2>
<form method="POST" action="index.php?route=service/emergency" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['owner_name']) ? 'form__group--error' : '' ?>">
            <label for="em_name" class="form__label">Ім'я власника <span class="required">*</span></label>
            <input type="text" id="em_name" name="owner_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['owner_name'] ?? '') ?>"
                   placeholder="Ваше повне ім'я">
            <?php if (isset($errors['owner_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['owner_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['phone']) ? 'form__group--error' : '' ?>">
            <label for="em_phone" class="form__label">Телефон <span class="required">*</span></label>
            <input type="tel" id="em_phone" name="phone" class="form__input"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                   placeholder="+380 123 456 789">
            <?php if (isset($errors['phone'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['phone']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['animal_name']) ? 'form__group--error' : '' ?>">
            <label for="em_animal" class="form__label">Кличка тварини <span class="required">*</span></label>
            <input type="text" id="em_animal" name="animal_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['animal_name'] ?? '') ?>"
                   placeholder="Шарік">
            <?php if (isset($errors['animal_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['animal_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['urgency']) ? 'form__group--error' : '' ?>">
            <label for="em_urgency" class="form__label">Рівень терміновості <span class="required">*</span></label>
            <select id="em_urgency" name="urgency" class="form__input">
                <option value="low" <?= ($_POST['urgency'] ?? 'normal') === 'low' ? 'selected' : '' ?>>Низька</option>
                <option value="normal" <?= ($_POST['urgency'] ?? 'normal') === 'normal' ? 'selected' : '' ?>>Середня</option>
                <option value="high" <?= ($_POST['urgency'] ?? 'normal') === 'high' ? 'selected' : '' ?>>Висока</option>
                <option value="critical" <?= ($_POST['urgency'] ?? 'normal') === 'critical' ? 'selected' : '' ?>>Критична</option>
            </select>
            <?php if (isset($errors['urgency'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['urgency']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group <?= isset($errors['problem']) ? 'form__group--error' : '' ?>">
        <label for="em_problem" class="form__label">Опис проблеми <span class="required">*</span></label>
        <textarea id="em_problem" name="problem" class="form__textarea"
                  placeholder="Детально опишіть симптоми та проблеми тварини..."><?= htmlspecialchars($_POST['problem'] ?? '') ?></textarea>
        <?php if (isset($errors['problem'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['problem']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn btn--danger">Подати запит на екстрену допомогу</button>
    </div>
</form>

<?php if (!empty($requests)): ?>
    <h2>Недавні запити на допомогу</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Час запиту</th>
                <th>Власник</th>
                <th>Телефон</th>
                <th>Тварина</th>
                <th>Рівень терміновості</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                    <td><?= htmlspecialchars($r['owner_name']) ?></td>
                    <td><?= htmlspecialchars($r['phone']) ?></td>
                    <td><?= htmlspecialchars($r['animal_name']) ?></td>
                    <td>
                        <?php
                        $urgencyMap = [
                            'low' => 'Низька',
                            'normal' => 'Середня',
                            'high' => 'Висока',
                            'critical' => '🚨 Критична'
                        ];
                        echo htmlspecialchars($urgencyMap[$r['urgency']] ?? $r['urgency']);
                        ?>
                    </td>
                    <td><?= htmlspecialchars(ucfirst($r['status'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
