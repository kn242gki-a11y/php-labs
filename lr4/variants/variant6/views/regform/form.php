<?php
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1>🐾 Реєстрація власника тварини</h1>
<p>Створіть електронну карту, щоб керувати здоров'ям ваших улюбленців та записуватися на прийом.</p>

<?php if (!empty($errors)): ?>
    <div class="alert alert--error">
        <strong>Виправте наступні помилки:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=regform/form" class="form">
    <div class="form__group">
        <label for="login" class="form__label">Логін власника</label>
        <input type="text" id="login" name="login"
               class="form__input<?= isset($errors['login']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['login'] ?? '') ?>"
               placeholder="Ваш нікнейм (без пробілів та цифр, мін. 5 симв.)">
        <?php if (isset($errors['login'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['login']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="password" class="form__label">Пароль</label>
            <input type="password" id="password" name="password"
                   class="form__input<?= isset($errors['password']) ? ' form__input--error' : '' ?>"
                   placeholder="Мін. 5 симв., обов'язкова цифра">
            <?php if (isset($errors['password'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['password']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="password_confirm" class="form__label">Підтвердження</label>
            <input type="password" id="password_confirm" name="password_confirm"
                   class="form__input<?= isset($errors['password_confirm']) ? ' form__input--error' : '' ?>"
                   placeholder="Повторіть пароль">
            <?php if (isset($errors['password_confirm'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['password_confirm']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group">
        <label for="owner_name" class="form__label">ПІБ власника</label>
        <input type="text" id="owner_name" name="owner_name"
               class="form__input<?= isset($errors['owner_name']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['owner_name'] ?? '') ?>"
               placeholder="Ваше повне ім'я">
        <?php if (isset($errors['owner_name'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['owner_name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="email" class="form__label">Email</label>
            <input type="email" id="email" name="email"
                   class="form__input<?= isset($errors['email']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                   placeholder="your@email.com">
            <?php if (isset($errors['email'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['email']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="phone" class="form__label">Телефон</label>
            <input type="tel" id="phone" name="phone"
                   class="form__input<?= isset($errors['phone']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                   placeholder="+380XXXXXXXXX">
            <?php if (isset($errors['phone'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['phone']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group">
        <label for="pet_name" class="form__label">Кличка тварини</label>
        <input type="text" id="pet_name" name="pet_name"
               class="form__input<?= isset($errors['pet_name']) ? ' form__input--error' : '' ?>"
               value="<?= htmlspecialchars($old['pet_name'] ?? '') ?>"
               placeholder="Ім'я вашого улюбленця">
        <?php if (isset($errors['pet_name'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['pet_name']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group">
            <label for="pet_type" class="form__label">Вид тварини</label>
            <select id="pet_type" name="pet_type"
                    class="form__input<?= isset($errors['pet_type']) ? ' form__input--error' : '' ?>">
                <option value="">Оберіть вид</option>
                <option value="dog" <?= ($old['pet_type'] ?? '') === 'dog' ? 'selected' : '' ?>>Собака</option>
                <option value="cat" <?= ($old['pet_type'] ?? '') === 'cat' ? 'selected' : '' ?>>Кіт</option>
                <option value="bird" <?= ($old['pet_type'] ?? '') === 'bird' ? 'selected' : '' ?>>Птах</option>
                <option value="rabbit" <?= ($old['pet_type'] ?? '') === 'rabbit' ? 'selected' : '' ?>>Кролик</option>
                <option value="other" <?= ($old['pet_type'] ?? '') === 'other' ? 'selected' : '' ?>>Інше</option>
            </select>
            <?php if (isset($errors['pet_type'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['pet_type']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="pet_breed" class="form__label">Порода</label>
            <input type="text" id="pet_breed" name="pet_breed"
                   class="form__input<?= isset($errors['pet_breed']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['pet_breed'] ?? '') ?>"
                   placeholder="Наприклад: Лабрадор, Сіамська">
            <?php if (isset($errors['pet_breed'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['pet_breed']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="pet_age" class="form__label">Вік (роки)</label>
            <input type="number" id="pet_age" name="pet_age" min="0" max="30"
                   class="form__input<?= isset($errors['pet_age']) ? ' form__input--error' : '' ?>"
                   value="<?= htmlspecialchars($old['pet_age'] ?? '') ?>"
                   placeholder="0">
            <?php if (isset($errors['pet_age'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['pet_age']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group">
        <label for="about" class="form__label">Додаткова інформація</label>
        <textarea id="about" name="about" 
                  class="form__input<?= isset($errors['about']) ? ' form__input--error' : '' ?>" 
                  rows="3"
                  placeholder="Особливості здоров'я, алергії, поведінка..."><?= htmlspecialchars($old['about'] ?? '') ?></textarea>
        <?php if (isset($errors['about'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['about']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Створити акаунт</button>
        <button type="reset" class="btn btn--secondary">Очистити форму</button>
    </div>
</form>

<div class="info-block" style="margin-top: 30px;">
    <h3>Пам'ятка щодо безпеки</h3>
    <p class="text-muted">
        Логін використовується для ідентифікації в системі. Згідно з вимогами безпеки клініки, пароль повинен бути складним і містити хоча б одну цифру.
    </p>
</div>