<?php
$volunteers = $volunteers ?? [];
$fundraisers = $fundraisers ?? [];
?>

<h1>Наші волонтери</h1>
<p>Люди, які готові допомагати нашим улюбленцям безоплатно. Приєднуйтесь до команди!</p>

<section class="fundraisers-section" aria-labelledby="fundraisers-title">
    <h2 id="fundraisers-title">Збори на допомогу тваринам</h2>
    <p class="text-muted">Підтримайте тварин, яким зараз потрібна допомога.</p>

    <?php if (empty($fundraisers)): ?>
        <p class="text-muted">Активних зборів зараз немає.</p>
    <?php else: ?>
        <div class="fundraisers-grid">
            <?php foreach ($fundraisers as $fundraiser):
                $target = (float)$fundraiser['target_amount'];
                $collected = (float)$fundraiser['collected_amount'];
                $progress = $target > 0 ? min(100, max(0, ($collected / $target) * 100)) : 0;
            ?>
                <article class="fundraiser-card">
                    <div class="fundraiser-card__top">
                        <span class="fundraiser-card__animal">🐾 <?= htmlspecialchars($fundraiser['animal_name']) ?></span>
                        <span class="fundraiser-card__percent"><?= number_format($progress, 0) ?>%</span>
                    </div>
                    <h3><?= htmlspecialchars($fundraiser['title']) ?></h3>
                    <p><?= htmlspecialchars($fundraiser['description']) ?></p>
                    <div class="fundraiser-progress" role="progressbar" aria-valuenow="<?= number_format($progress, 0) ?>" aria-valuemin="0" aria-valuemax="100" aria-label="Зібрано <?= number_format($progress, 0) ?> відсотків">
                        <span style="width: <?= number_format($progress, 2, '.', '') ?>%"></span>
                    </div>
                    <div class="fundraiser-card__amounts">
                        <strong><?= number_format($collected, 0, ',', ' ') ?> грн</strong>
                        <span>із <?= number_format($target, 0, ',', ' ') ?> грн</span>
                    </div>
                    <div class="fundraiser-card__details">
                        <span>Організатор: <?= htmlspecialchars($fundraiser['organizer_name']) ?></span>
                        <a href="index.php?route=volunteer/donate&id=<?= (int)$fundraiser['id'] ?>" class="btn btn--small">Допомогти</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

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
        .fundraisers-section {
            margin: 28px 0 36px;
        }

        .fundraisers-section h2 {
            margin-bottom: 4px;
        }

        .fundraisers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .fundraiser-card {
            padding: 22px;
            background: #fff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(37, 99, 235, 0.08);
        }

        .fundraiser-card__top,
        .fundraiser-card__amounts,
        .fundraiser-card__details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .fundraiser-card__animal,
        .fundraiser-card__percent {
            color: #2563eb;
            font-weight: 700;
        }

        .fundraiser-card h3 {
            margin: 14px 0 8px;
        }

        .fundraiser-card p {
            min-height: 48px;
            margin-bottom: 18px;
            color: #64748b;
        }

        .fundraiser-progress {
            height: 10px;
            overflow: hidden;
            margin-bottom: 10px;
            background: #e5e7eb;
            border-radius: 999px;
        }

        .fundraiser-progress span {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #60a5fa);
            border-radius: inherit;
        }

        .fundraiser-card__amounts {
            align-items: baseline;
            margin-bottom: 18px;
        }

        .fundraiser-card__amounts strong {
            color: #15803d;
            font-size: 1.2rem;
        }

        .fundraiser-card__amounts span,
        .fundraiser-card__details > span {
            color: #64748b;
            font-size: .85rem;
        }

        .fundraiser-card__details {
            align-items: flex-end;
            border-top: 1px solid #e5e7eb;
            padding-top: 14px;
        }

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
