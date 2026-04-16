<?php
$animal_id = $animal_id ?? 0;
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Додати запис про щеплення</h1>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=animal/vaccination_add&id=<?= (int)$animal_id ?>" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['vaccine_name']) ? 'form__group--error' : '' ?>">
            <label for="v_name" class="form__label">Назва щеплення <span class="required">*</span></label>
            <input type="text" id="v_name" name="vaccine_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['vaccine_name'] ?? '') ?>"
                   placeholder="Наприклад: Rabies, DHPP...">
            <?php if (isset($errors['vaccine_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['vaccine_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['vaccination_date']) ? 'form__group--error' : '' ?>">
            <label for="v_date" class="form__label">Дата щеплення <span class="required">*</span></label>
            <input type="date" id="v_date" name="vaccination_date" class="form__input"
                   value="<?= htmlspecialchars($_POST['vaccination_date'] ?? '') ?>"
                   max="<?= date('Y-m-d') ?>">
            <?php if (isset($errors['vaccination_date'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['vaccination_date']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="v_next" class="form__label">Дата наступного щеплення</label>
            <input type="date" id="v_next" name="next_due_date" class="form__input"
                   value="<?= htmlspecialchars($_POST['next_due_date'] ?? '') ?>">
        </div>

        <div class="form__group">
            <label for="v_vet" class="form__label">Ім'я ветеринара</label>
            <input type="text" id="v_vet" name="vet_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['vet_name'] ?? '') ?>"
                   placeholder="ПІБ ветеринара">
        </div>
    </div>

    <div class="form__group">
        <label for="v_notes" class="form__label">Примітки</label>
        <textarea id="v_notes" name="notes" class="form__textarea"
                  placeholder="Додаткова інформація про щеплення..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти</button>
        <a href="index.php?route=animal/detail&id=<?= (int)$animal_id ?>" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
