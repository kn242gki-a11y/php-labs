<?php
$images = $images ?? [];
$message = $message ?? '';
$error = $error ?? '';
$title = $title ?? 'Завантаження зображень';
$type = $type ?? 'general';
?>

<h1><?= htmlspecialchars($title) ?></h1>
<?php if ($type === 'emergency'): ?>
    <p>Надішліть фото тварини для екстреної ветеринарної допомоги. Ми зв'яжемося з вами протягом 30 хвилин.</p>
<?php elseif ($type === 'home'): ?>
    <p>Завантажте фото тварини для замовлення виїзду ветеринара додому. Вкажіть адресу та контактні дані.</p>
<?php else: ?>
    <p>Завантажте зображення (JPEG, PNG, GIF, WebP, до 5 МБ). Файли зберігаються у <code>data/uploads/</code>.</p>
<?php endif; ?>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=upload/<?= $type === 'general' ? 'index' : $type ?>" enctype="multipart/form-data" class="form">
    <div class="form__group">
        <label for="upload_image" class="form__label">Оберіть зображення <span class="required">*</span></label>
        <input type="file" id="upload_image" name="image" class="form__input" accept="image/*">
    </div>

    <?php if ($type === 'home'): ?>
        <div class="form__group">
            <label for="address" class="form__label">Адреса виїзду</label>
            <input type="text" id="address" name="address" class="form__input" placeholder="м. Київ, вул. Лесі Українки, 10">
        </div>
        <div class="form__group">
            <label for="contact_phone" class="form__label">Контактний телефон</label>
            <input type="tel" id="contact_phone" name="contact_phone" class="form__input" placeholder="+380 123 456 789">
        </div>
    <?php endif; ?>

    <div class="form__actions">
        <button type="submit" class="btn">Завантажити</button>
    </div>
</form>

<h2>Галерея (<?= count($images) ?>)</h2>

<?php if (empty($images)): ?>
    <p class="text-muted">Зображень ще немає.</p>
<?php else: ?>
    <div class="gallery">
        <?php foreach ($images as $img): ?>
            <div class="gallery__item">
                <img src="<?= htmlspecialchars($img['url']) ?>" alt="<?= htmlspecialchars($img['name']) ?>" class="gallery__img">
                <div class="gallery__info">
                    <span class="gallery__name"><?= htmlspecialchars($img['name']) ?></span>
                    <span class="gallery__meta"><?= htmlspecialchars($img['date']) ?> &middot; <?= round($img['size'] / 1024) ?> КБ</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
