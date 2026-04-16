<?php
$volunteers = $volunteers ?? [];
?>

<h1>Наші волонтери</h1>
<p>Люди, які готові допомагати нашим улюбленцям безоплатно. Приєднуйтесь до команди!</p>

<div class="form__actions" style="margin-bottom: 30px">
    <a href="index.php?route=volunteer/signup" class="btn">Стати волонтером</a>
</div>

<?php if (empty($volunteers)): ?>
    <p class="text-muted">Волонтери ще не розпочали свою роботу. Будьте першим!</p>
<?php else: ?>
    <h2>Активні волонтери (<?= count($volunteers) ?>)</h2>
    <div class="volunteers-grid">
        <?php foreach ($volunteers as $v): ?>
            <div class="volunteer-card">
                <h3><?= htmlspecialchars($v['name']) ?></h3>
                <p class="volunteer-position">
                    <strong>Посада:</strong>
                    <?php
                    $positionMap = [
                        'опікун' => 'Опікун тварин',
                        'організатор' => 'Організатор подій',
                        'соціальний' => 'Соціальний працівник'
                    ];
                    echo htmlspecialchars($positionMap[$v['position']] ?? $v['position']);
                    ?>
                </p>
                <p class="volunteer-availability">
                    <strong>Наявність:</strong> <?= htmlspecialchars($v['availability']) ?>
                </p>
                <?php if (!empty($v['experience'])): ?>
                    <p class="volunteer-experience">
                        <strong>Досвід:</strong> <?= htmlspecialchars($v['experience']) ?>
                    </p>
                <?php endif; ?>
                <p class="volunteer-contacts">
                    <strong>Контакти:</strong><br>
                    📧 <?= htmlspecialchars($v['email']) ?><br>
                    📱 <?= htmlspecialchars($v['phone']) ?>
                </p>
                <p class="volunteer-date">
                    Приєднався: <?= date('d.m.Y', strtotime($v['created_at'])) ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <style>
        .volunteers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .volunteer-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .volunteer-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .volunteer-card p {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        
        .volunteer-position {
            font-weight: bold;
            color: #2563eb;
        }
        
        .volunteer-date {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
    </style>
<?php endif; ?>
