<?php
$authenticated = $authenticated ?? false;
$login = $login ?? '';
$message = $message ?? '';
$error = $error ?? '';
$subfolder = $subfolder ?? '';
$files = $files ?? [];
$subfolders = $subfolders ?? [];
?>

<div class="folder-browse">
    <h1>🗂️ Перегляд каталогу</h1>

    <?php if ($message !== ''): ?>
        <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!$authenticated): ?>
        <!-- Login Form -->
        <div class="card">
            <h2>Вхід до каталогу</h2>
            <form method="POST" action="index.php?route=folder/browse" class="form">
                <div class="form__row">
                    <div class="form__group">
                        <label for="b_login" class="form__label">Логін <span class="required">*</span></label>
                        <input type="text" id="b_login" name="login" class="form__input"
                               placeholder="Введіть ваш логін"
                               autofocus>
                    </div>
                    <div class="form__group">
                        <label for="b_password" class="form__label">Пароль <span class="required">*</span></label>
                        <input type="password" id="b_password" name="password" class="form__input"
                               placeholder="Введіть ваш пароль">
                    </div>
                </div>
                <div class="form__actions">
                    <button type="submit" class="btn">Увійти</button>
                    <a href="index.php?route=folder/create" class="btn btn--secondary">Створити каталог</a>
                </div>
            </form>
        </div>

    <?php else: ?>
        <!-- Authenticated View -->
        <div class="info-bar">
            <span>👤 Користувач: <strong><?= htmlspecialchars($login) ?></strong></span>
            <a href="index.php?route=folder/browse&logout" class="btn btn--small">Вихід</a>
        </div>

        <?php if ($subfolder === ''): ?>
            <!-- Subfolders List -->
            <div class="folder-grid">
                <?php foreach ($subfolders as $sub): ?>
                    <a href="index.php?route=folder/browse&folder=<?= urlencode($sub['name']) ?>"
                       class="folder-card">
                        <div class="folder-card__icon">📁</div>
                        <div class="folder-card__name"><?= htmlspecialchars($sub['name']) ?></div>
                        <div class="folder-card__info"><?= $sub['files'] ?> файлів</div>
                    </a>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <!-- File Browser -->
            <div class="breadcrumb">
                <a href="index.php?route=folder/browse">📁 Папки</a>
                <span> / </span>
                <strong><?= htmlspecialchars($subfolder) ?></strong>
            </div>

            <!-- Upload Form -->
            <div class="card">
                <h3>📤 Завантажити файл</h3>
                <form method="POST" enctype="multipart/form-data"
                      action="index.php?route=folder/browse&folder=<?= urlencode($subfolder) ?>"
                      class="form form--inline">
                    <div class="form__row">
                        <div class="form__group">
                            <input type="file" name="file" class="form__input" required>
                        </div>
                        <button type="submit" class="btn">Завантажити</button>
                    </div>
                </form>
            </div>

            <!-- Files List -->
            <?php if (!empty($files)): ?>
                <div class="files-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>📄 Файл</th>
                                <th>Розмір</th>
                                <th>Змінено</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($files as $file): ?>
                                <tr>
                                    <td>
                                        <span class="file-icon">📄</span>
                                        <?= htmlspecialchars($file['name']) ?>
                                    </td>
                                    <td class="text-muted">
                                        <?= $this->formatBytes($file['size']) ?>
                                    </td>
                                    <td class="text-muted">
                                        <?= date('Y-m-d H:i', $file['modified']) ?>
                                    </td>
                                    <td class="action-buttons">
                                        <a href="?route=folder/download&folder=<?= urlencode($subfolder) ?>&file=<?= urlencode($file['name']) ?>"
                                           class="btn btn--small" download>⬇️ Завантажити</a>
                                        <a href="?route=folder/browse&folder=<?= urlencode($subfolder) ?>&delete=<?= urlencode($file['name']) ?>"
                                           class="btn btn--small btn--danger"
                                           onclick="return confirm('Видалити файл?');">🗑️ Видалити</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>Папка порожня. Завантажте файл щоб почати.</p>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <!-- Quick Actions -->
        <div class="card card--footer">
            <h3>Швидкі дії</h3>
            <div class="button-group">
                <a href="index.php?route=folder/create" class="btn btn--small">➕ Створити каталог</a>
                <a href="index.php?route=folder/delete" class="btn btn--small">🗑️ Видалити каталог</a>
            </div>
        </div>

    <?php endif; ?>
</div>

<style>
.folder-browse {
    padding: 1rem;
}

.info-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f5f5f5;
    border-radius: 4px;
    margin-bottom: 2rem;
    border-left: 4px solid #007bff;
}

.folder-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    margin: 2rem 0;
}

.folder-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
    cursor: pointer;
}

.folder-card:hover {
    border-color: #007bff;
    background: #f8f9ff;
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.folder-card__icon {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.folder-card__name {
    font-weight: bold;
    font-size: 1.1rem;
    text-align: center;
    word-break: break-word;
}

.folder-card__info {
    font-size: 0.9rem;
    color: #999;
    margin-top: 0.5rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    margin: 2rem 0 1rem;
    font-size: 0.95rem;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.form--inline .form__row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.form--inline .form__group {
    flex: 1;
    margin: 0;
}

.files-table {
    margin: 2rem 0;
    overflow-x: auto;
}

.file-icon {
    margin-right: 0.5rem;
}

.text-muted {
    color: #999;
    font-size: 0.9rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn--small {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}

.btn--danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn--danger:hover {
    background-color: #c82333;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #999;
}

.button-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.card--footer {
    margin-top: 3rem;
    border-top: 2px solid #f0f0f0;
}
</style>
