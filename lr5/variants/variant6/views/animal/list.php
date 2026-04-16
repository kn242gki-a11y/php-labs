<?php
$animals = $animals ?? [];
?>

<h1>Тварини в клініці</h1>
<p>Список всіх тварин, які перебувають на обліку. Клікніть на тварину для докладної інформації.</p>

<div class="form__actions" style="margin-bottom: 20px">
    <a href="index.php?route=animal/create" class="btn">➕ Додати нову тварину</a>
</div>

<?php if (empty($animals)): ?>
    <p class="text-muted">Тварин ще немає.</p>
<?php else: ?>
    <div class="animals-grid">
        <?php foreach ($animals as $a): ?>
            <div class="animal-card">
                <div class="animal-card__header">
                    <h3><?= htmlspecialchars($a['name']) ?></h3>
                    <span class="animal-tag"><?= htmlspecialchars($a['species']) ?></span>
                </div>
                <div class="animal-card__body">
                    <p><strong>Порода:</strong> <?= htmlspecialchars($a['breed'] ?: '—') ?></p>
                    <p><strong>Вік:</strong> <?= (int)$a['age'] ?> років</p>
                    <p><strong>Власник:</strong> <?= htmlspecialchars($a['owner']) ?></p>
                    <p><strong>Статус:</strong> 
                        <span class="health-badge health-<?= $a['health_status'] === 'здорова' ? 'good' : 'caution' ?>">
                            <?= htmlspecialchars($a['health_status']) ?>
                        </span>
                    </p>
                    <?php if (!empty($a['last_visit'])): ?>
                        <p><strong>Останній візит:</strong> <?= date('d.m.Y', strtotime($a['last_visit'])) ?></p>
                    <?php endif; ?>
                </div>
                <div class="animal-card__actions">
                    <a href="index.php?route=animal/detail&id=<?= (int)$a['id'] ?>" class="btn btn--small">📋 Деталі</a>
                    <a href="index.php?route=animal/edit&id=<?= (int)$a['id'] ?>" class="btn btn--small">✏️ Редагувати</a>
                    <form method="POST" action="index.php?route=animal/delete" style="display:inline"
                          onsubmit="return confirm('Видалити тварину?')">
                        <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                        <button type="submit" class="btn btn--small btn--danger">🗑️ Видалити</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <style>
        .animals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .animal-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        .animal-card__header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        
        .animal-card__header h3 {
            margin: 0;
            color: #333;
            font-size: 1.3em;
        }
        
        .animal-tag {
            background: #e3f2fd;
            color: #1976d2;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }
        
        .animal-card__body {
            flex-grow: 1;
            margin-bottom: 15px;
        }
        
        .animal-card__body p {
            margin: 8px 0;
            font-size: 0.95em;
            color: #555;
        }
        
        .health-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: bold;
        }
        
        .health-good {
            background: #c8e6c9;
            color: #2e7d32;
        }
        
        .health-caution {
            background: #fff9c4;
            color: #f57f17;
        }
        
        .animal-card__actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        .btn--small {
            padding: 6px 10px;
            font-size: 0.9em;
        }
    </style>
<?php endif; ?>
