<?php
$animal_id = $animal_id ?? 0;
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Додати запис про здоров'я</h1>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=animal/health_add&id=<?= (int)$animal_id ?>" class="form">
    <div class="form__group <?= isset($errors['visit_date']) ? 'form__group--error' : '' ?>">
        <label for="h_date" class="form__label">Дата відвідування <span class="required">*</span></label>
        <input type="date" id="h_date" name="visit_date" class="form__input"
               value="<?= htmlspecialchars($_POST['visit_date'] ?? '') ?>"
               max="<?= date('Y-m-d') ?>">
        <?php if (isset($errors['visit_date'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['visit_date']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label for="h_diagnosis" class="form__label">Діагноз</label>
        <textarea id="h_diagnosis" name="diagnosis" class="form__textarea"
                  placeholder="Опис діагнозу..."><?= htmlspecialchars($_POST['diagnosis'] ?? '') ?></textarea>
    </div>

    <div class="form__group">
        <label for="h_treatment" class="form__label">Лікування</label>
        <textarea id="h_treatment" name="treatment" class="form__textarea"
                  placeholder="Призначене лікування..."><?= htmlspecialchars($_POST['treatment'] ?? '') ?></textarea>
    </div>

    <div class="form__group">
        <label for="h_notes" class="form__label">Примітки ветеринара</label>
        <textarea id="h_notes" name="vet_notes" class="form__textarea"
                  placeholder="Додаткові примітки..."><?= htmlspecialchars($_POST['vet_notes'] ?? '') ?></textarea>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти</button>
        <a href="index.php?route=animal/detail&id=<?= (int)$animal_id ?>" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
