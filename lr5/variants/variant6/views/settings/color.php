<?php
$colors = $colors ?? [];
$currentColor = $currentColor ?? '#f9fafb';
$fontSize = $fontSize ?? 'normal';
$highContrast = $highContrast ?? false;
$message = $message ?? '';
$error = $error ?? '';
?>

<h1>Колір фону</h1>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=settings/color" class="form">
    <div class="color-picker">
        <?php foreach ($colors as $hex => $label): ?>
            <label class="color-picker__item <?= $currentColor === $hex ? 'color-picker__item--active' : '' ?>">
                <input type="radio" name="bg_color" value="<?= htmlspecialchars($hex) ?>"
                    <?= $currentColor === $hex ? 'checked' : '' ?>>
                <span class="color-picker__swatch" style="background-color: <?= htmlspecialchars($hex) ?>"></span>
                <span class="color-picker__label"><?= htmlspecialchars($label) ?></span>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="form__row settings-options">
        <div class="form__group">
            <label for="font_size" class="form__label">Розмір тексту</label>
            <select id="font_size" name="font_size" class="form__select">
                <option value="normal" <?= $fontSize === 'normal' ? 'selected' : '' ?>>Звичайний</option>
                <option value="large" <?= $fontSize === 'large' ? 'selected' : '' ?>>Збільшений</option>
            </select>
        </div>

        <label class="form__checkbox settings-options__checkbox">
            <input type="checkbox" name="high_contrast" value="1" <?= $highContrast ? 'checked' : '' ?>>
            <span>Підвищений контраст</span>
        </label>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Зберегти колір</button>
    </div>
</form>

