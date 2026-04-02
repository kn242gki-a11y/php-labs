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
        <label for="about" class="form__label">Про вашого улюбленця</label>
        <textarea id="about" name="about" 
                  class="form__input<?= isset($errors['about']) ? ' form__input--error' : '' ?>" 
                  rows="4"
                  placeholder="Вкажіть вид тварини, породу, кличку та вік..."><?= htmlspecialchars($old['about'] ?? '') ?></textarea>
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