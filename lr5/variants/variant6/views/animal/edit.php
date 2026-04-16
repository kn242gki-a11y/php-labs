<?php
$animal = $animal ?? [];
$errors = $errors ?? [];
?>

<h1>Редагувати тварину #<?= (int)($animal['id'] ?? 0) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Помилки:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=animal/edit&id=<?= (int)($animal['id'] ?? 0) ?>" class="form">
    <div class="form__group <?= isset($errors['name']) ? 'form__group--error' : '' ?>">
        <label for="a_name" class="form__label">Кличка <span class="required">*</span></label>
        <input type="text" id="a_name" name="name" class="form__input"
               value="<?= htmlspecialchars($animal['name'] ?? '') ?>">
        <?php if (isset($errors['name'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['species']) ? 'form__group--error' : '' ?>">
            <label for="a_species" class="form__label">Вид <span class="required">*</span></label>
            <input type="text" id="a_species" name="species" class="form__input"
                   value="<?= htmlspecialchars($animal['species'] ?? '') ?>">
            <?php if (isset($errors['species'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['species']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="a_breed" class="form__label">Порода</label>
            <input type="text" id="a_breed" name="breed" class="form__input"
                   value="<?= htmlspecialchars($animal['breed'] ?? '') ?>">
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['age']) ? 'form__group--error' : '' ?>">
            <label for="a_age" class="form__label">Вік (років)</label>
            <input type="number" id="a_age" name="age" class="form__input" min="0"
                   value="<?= htmlspecialchars($animal['age'] ?? '') ?>">
            <?php if (isset($errors['age'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['age']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['owner']) ? 'form__group--error' : '' ?>">
            <label for="a_owner" class="form__label">ПІБ власника <span class="required">*</span></label>
            <input type="text" id="a_owner" name="owner" class="form__input"
                   value="<?= htmlspecialchars($animal['owner'] ?? '') ?>">
            <?php if (isset($errors['owner'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['owner']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти</button>
        <a href="index.php?route=animal/list" class="btn btn--secondary">Скасувати</a>
    </div>
</form>
