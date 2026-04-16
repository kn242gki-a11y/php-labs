<?php
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Стати волонтером</h1>
<p>Приєднуйтесь до нашої команди! Заповніть форму, і ми розглянемо вашу заяву.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=volunteer/signup" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['name']) ? 'form__group--error' : '' ?>">
            <label for="v_name" class="form__label">Ваше повне ім'я <span class="required">*</span></label>
            <input type="text" id="v_name" name="name" class="form__input"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   placeholder="Іван Петренко">
            <?php if (isset($errors['name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['email']) ? 'form__group--error' : '' ?>">
            <label for="v_email" class="form__label">Email <span class="required">*</span></label>
            <input type="email" id="v_email" name="email" class="form__input"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="ivan@example.com">
            <?php if (isset($errors['email'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['email']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['phone']) ? 'form__group--error' : '' ?>">
            <label for="v_phone" class="form__label">Телефон <span class="required">*</span></label>
            <input type="tel" id="v_phone" name="phone" class="form__input"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                   placeholder="+380 97 123 4567">
            <?php if (isset($errors['phone'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['phone']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['position']) ? 'form__group--error' : '' ?>">
            <label for="v_position" class="form__label">Бажана посада <span class="required">*</span></label>
            <select id="v_position" name="position" class="form__input">
                <option value="">Виберіть посаду</option>
                <option value="опікун" <?= ($_POST['position'] ?? '') === 'опікун' ? 'selected' : '' ?>>Опікун тварин</option>
                <option value="організатор" <?= ($_POST['position'] ?? '') === 'організатор' ? 'selected' : '' ?>>Організатор подій</option>
                <option value="соціальний" <?= ($_POST['position'] ?? '') === 'соціальний' ? 'selected' : '' ?>>Соціальний працівник</option>
            </select>
            <?php if (isset($errors['position'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['position']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group">
        <label for="v_experience" class="form__label">Ваш досвід роботи</label>
        <textarea id="v_experience" name="experience" class="form__textarea"
                  placeholder="Розповідьте нам про ваш досвід із тваринами або суспільною роботою..."><?= htmlspecialchars($_POST['experience'] ?? '') ?></textarea>
    </div>

    <div class="form__group">
        <label for="v_availability" class="form__label">Ваша наявність</label>
        <input type="text" id="v_availability" name="availability" class="form__input"
               value="<?= htmlspecialchars($_POST['availability'] ?? '') ?>"
               placeholder="Наприклад: Вихідні, Будні з 18:00, Гнучкий графік...">
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Надіслати заяву</button>
        <a href="index.php?route=volunteer/index" class="btn btn--secondary">Скасувати</a>
    </div>
</form>

<div style="margin-top: 40px; padding: 20px; background: #f0f9ff; border-radius: 8px;">
    <h2>Чому варто стати волонтером?</h2>
    <ul>
        <li>💙 Допоможіть тваринам, які потребують захисту</li>
        <li>👨‍👩‍👧‍👦 Приєднуйтеся до дружної команди однодумців</li>
        <li>📜 Отримайте сертифікат про волонтерську діяльність</li>
        <li>🎓 Розвивайте навички та загальний рівень</li>
        <li>🌟 Робіть вклад у розвиток суспільства</li>
    </ul>
</div>
