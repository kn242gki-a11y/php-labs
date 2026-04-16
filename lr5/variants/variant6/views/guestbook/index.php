<?php
$appointments = $appointments ?? [];
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Запис до ветеринара</h1>
<p>Записи зберігаються у файлі <code>data/appointments.jsonl</code> (формат: JSON Lines).</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<h2>Записатися на прийом</h2>
<form method="POST" action="index.php?route=guestbook/index" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['name']) ? 'form__group--error' : '' ?>">
            <label for="gb_name" class="form__label">Ім'я власника <span class="required">*</span></label>
            <input type="text" id="gb_name" name="name" class="form__input"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   placeholder="Ваше ім'я">
            <?php if (isset($errors['name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['phone']) ? 'form__group--error' : '' ?>">
            <label for="gb_phone" class="form__label">Телефон <span class="required">*</span></label>
            <input type="tel" id="gb_phone" name="phone" class="form__input"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                   placeholder="+380 123 456 789">
            <?php if (isset($errors['phone'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['phone']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['animal_name']) ? 'form__group--error' : '' ?>">
            <label for="gb_animal" class="form__label">Кличка тварини <span class="required">*</span></label>
            <input type="text" id="gb_animal" name="animal_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['animal_name'] ?? '') ?>"
                   placeholder="Шарік">
            <?php if (isset($errors['animal_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['animal_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="gb_reason" class="form__label">Причина візиту</label>
            <input type="text" id="gb_reason" name="reason" class="form__input"
                   value="<?= htmlspecialchars($_POST['reason'] ?? '') ?>"
                   placeholder="Щеплення, огляд...">
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['appointment_date']) ? 'form__group--error' : '' ?>">
            <label for="gb_date" class="form__label">Дата запису <span class="required">*</span></label>
            <input type="date" id="gb_date" name="appointment_date" class="form__input"
                   value="<?= htmlspecialchars($_POST['appointment_date'] ?? '') ?>"
                   min="<?= date('Y-m-d') ?>">
            <?php if (isset($errors['appointment_date'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['appointment_date']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['appointment_time']) ? 'form__group--error' : '' ?>">
            <label for="gb_time" class="form__label">Час запису <span class="required">*</span></label>
            <input type="time" id="gb_time" name="appointment_time" class="form__input"
                   value="<?= htmlspecialchars($_POST['appointment_time'] ?? '') ?>">
            <?php if (isset($errors['appointment_time'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['appointment_time']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Записатися</button>
    </div>
</form>

<h2>Записи на прийом (<?= count($appointments) ?>)</h2>

<?php if (empty($appointments)): ?>
    <p class="text-muted">Поки що записів немає.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Дата запису</th>
                <th>Час</th>
                <th>Власник</th>
                <th>Телефон</th>
                <th>Тварина</th>
                <th>Причина</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($a['appointment_time']) ?></td>
                    <td><?= htmlspecialchars($a['name']) ?></td>
                    <td><?= htmlspecialchars($a['phone']) ?></td>
                    <td><?= htmlspecialchars($a['animal_name']) ?></td>
                    <td><?= htmlspecialchars($a['reason'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
