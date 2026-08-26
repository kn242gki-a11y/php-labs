<?php
$fundraiser = $fundraiser ?? [];
$errors = $errors ?? [];
$target = (float)($fundraiser['target_amount'] ?? 0);
$collected = (float)($fundraiser['collected_amount'] ?? 0);
$progress = $target > 0 ? min(100, ($collected / $target) * 100) : 0;
?>

<div class="donate-page">
    <a href="index.php?route=volunteer/index" class="back-link">← До зборів</a>
    <h1>Допомогти тварині</h1>

    <div class="donate-card">
        <span class="fundraiser-card__animal">🐾 <?= htmlspecialchars($fundraiser['animal_name']) ?></span>
        <h2><?= htmlspecialchars($fundraiser['title']) ?></h2>
        <p><?= htmlspecialchars($fundraiser['description']) ?></p>

        <div class="fundraiser-progress" role="progressbar" aria-valuenow="<?= number_format($progress, 0) ?>" aria-valuemin="0" aria-valuemax="100">
            <span style="width: <?= number_format($progress, 2, '.', '') ?>%"></span>
        </div>
        <p class="donate-card__summary">
            Уже зібрано <strong><?= number_format($collected, 0, ',', ' ') ?> грн</strong>
            із <?= number_format($target, 0, ',', ' ') ?> грн
        </p>

        <?php if (isset($errors['general'])): ?>
            <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?route=volunteer/donate&id=<?= (int)$fundraiser['id'] ?>" class="form">
            <div class="form__group <?= isset($errors['amount']) ? 'form__group--error' : '' ?>">
                <label for="donation_amount" class="form__label">Сума допомоги, грн <span class="required">*</span></label>
                <input type="number" id="donation_amount" name="amount" class="form__input" min="1" max="1000000" step="0.01" value="<?= htmlspecialchars($_POST['amount'] ?? '') ?>" placeholder="500">
                <?php if (isset($errors['amount'])): ?>
                    <span class="form__error"><?= htmlspecialchars($errors['amount']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form__actions">
                <button type="submit" class="btn">Підтвердити допомогу</button>
                <a href="index.php?route=volunteer/index" class="btn btn--secondary">Скасувати</a>
            </div>
        </form>
    </div>
</div>

<style>
    .donate-page { max-width: 680px; margin: 0 auto; }
    .back-link { display: inline-block; margin-bottom: 16px; }
    .donate-card { padding: 28px; background: #fff; border: 1px solid #dbeafe; border-radius: 12px; box-shadow: 0 4px 14px rgba(37, 99, 235, .08); }
    .donate-card h2 { margin: 10px 0 8px; }
    .donate-card > p { color: #64748b; }
    .donate-card__summary { margin: 10px 0 24px; }
    .donate-card__summary strong { color: #15803d; }
</style>
