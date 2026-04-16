<?php
$message = $message ?? '';
$error = $error ?? '';
$folders = $folders ?? [];
?>

<h1>📁 Створення каталогу</h1>
<p>Введіть логін — буде створено папку <code>data/users/{логін}/</code> з підпапками <code>video</code>, <code>music</code>, <code>photo</code>.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="index.php?route=folder/create" class="form">
    <div class="form__row">
        <div class="form__group">
            <label for="folder_login" class="form__label">Логін <span class="required">*</span></label>
            <input type="text" id="folder_login" name="login" class="form__input"
                   value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                   placeholder="Латинські літери, цифри, _">
        </div>
        <div class="form__group">
            <label for="folder_password" class="form__label">Пароль <span class="required">*</span></label>
            <input type="password" id="folder_password" name="password" class="form__input"
                   placeholder="Для видалення папки">
        </div>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Створити каталог</button>
        <a href="index.php?route=folder/delete" class="btn btn--secondary">Видалити каталог</a>
        <a href="index.php?route=folder/browse" class="btn btn--secondary">Перейти до перегляду</a>
    </div>
</form>

<?php if (!empty($folders)): ?>
    <h2>📂 Існуючі каталоги</h2>
    <div class="folders-overview">
        <?php foreach ($folders as $folder): ?>
            <div class="folder-summary">
                <h3>🗂️ <?= htmlspecialchars($folder['name']) ?></h3>
                <div class="folder-subfolders">
                    <?php foreach ($folder['subfolders'] as $sub): ?>
                        <span class="badge">
                            <strong><?= htmlspecialchars($sub['name']) ?></strong>
                            <span class="badge__count">📄 <?= $sub['files'] ?></span>
                        </span>
                    <?php endforeach; ?>
                </div>
                <p class="folder-hint">
                    <small>💡 Виконайте вхід на <a href="index.php?route=folder/browse">сторінці перегляду</a> щоб керувати файлами</small>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.folders-overview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.folder-summary {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.folder-summary h3 {
    margin: 0 0 1rem 0;
    color: #333;
    font-size: 1.1rem;
}

.folder-subfolders {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #f0f0f0;
    padding: 0.4rem 0.8rem;
    border-radius: 4px;
    font-size: 0.9rem;
}

.badge__count {
    background: #007bff;
    color: white;
    padding: 0.2rem 0.6rem;
    border-radius: 3px;
    font-size: 0.8rem;
    font-weight: bold;
}

.folder-hint {
    margin: 0;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    color: #666;
}

.folder-hint a {
    color: #007bff;
    text-decoration: none;
}

.folder-hint a:hover {
    text-decoration: underline;
}
</style>

