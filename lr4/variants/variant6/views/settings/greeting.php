<?php
$message = $message ?? '';
$messageType = $messageType ?? 'success';
$currentName = $currentName ?? '';
$currentGender = $currentGender ?? '';
?>

<h1>👤 Налаштування профілю власника</h1>
<p>Вкажіть ваші дані для персоналізованого звернення. Ці налаштування зберігаються у вашому браузері (через Cookie) та відображаються у верхній панелі сайту.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--<?= ($messageType === 'error') ? 'error' : 'success' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($currentName !== ''): ?>
    <?php
    $titleText = ($currentGender === 'female') ? 'пані' : 'пане';
    ?>
    <div class="info-block" style="border-left: 4px solid #059669; background: #f0fdf4; padding: 15px; margin-bottom: 25px;">
        <p style="margin: 0;">Поточне привітання: 
            <strong style="color: #065f46;">Вітаємо Вас, <?= $titleText ?> <?= htmlspecialchars($currentName) ?>!</strong>
        </p>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?route=settings/greeting" class="form card" style="max-width: 500px;">
    <div class="form__group">
        <label for="greeting_name" class="form__label">Ваше ім'я (як до вас звертатися)</label>
        <input type="text" id="greeting_name" name="greeting_name"
               class="form__input"
               value="<?= htmlspecialchars($currentName) ?>"
               placeholder="Наприклад: Катерина">
    </div>

    <div class="form__group">
        <span class="form__label">Стать (для коректного звернення)</span>
        <div class="form__radio-group" style="display: flex; gap: 20px; margin-top: 10px;">
            <label class="form__radio" style="cursor: pointer;">
                <input type="radio" name="greeting_gender" value="male"
                       <?= ($currentGender === 'male') ? 'checked' : '' ?>>
                Чоловіча (пане)
            </label>
            <label class="form__radio" style="cursor: pointer;">
                <input type="radio" name="greeting_gender" value="female"
                       <?= ($currentGender === 'female') ? 'checked' : '' ?>>
                Жіноча (пані)
            </label>
        </div>
    </div>

    <div class="form__actions" style="margin-top: 25px;">
        <button type="submit" class="btn">Зберегти налаштування</button>
    </div>
</form>

<div class="info-block" style="margin-top: 30px;">
    <h3>🛠️ Як це працює?</h3>
    <p class="text-muted">
        Ми використовуємо технологію <strong>HTTP Cookie</strong>. Це дозволяє серверу «впізнати» вас при наступному візиті, навіть якщо ви закриєте вкладку браузера. Дані зберігаються локально на вашому пристрої протягом 30 днів.
    </p>
</div>