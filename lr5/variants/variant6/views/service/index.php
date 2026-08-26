<?php
$services = $services ?? [];
$serviceIcons = ['🩺', '🚑', '💉', '🔬', '📡', '🦷', '🩹', '✂️', '📍', '🧴', '🐾'];
?>

<div class="services-page">
    <div class="services-visual" aria-hidden="true">
        <span>🩺</span><span>🐶</span><span>🐱</span><span>💙</span>
    </div>
    <div class="page-heading">
        <div>
            <span class="eyebrow">ДОБРА ЛАПА</span>
            <h1>Наші послуги</h1>
            <p class="text-muted">Оберіть потрібну послугу та дізнайтеся її вартість.</p>
        </div>
    </div>

    <div class="services-grid">
        <?php foreach ($services as $index => $service): ?>
            <article class="service-card">
                <div class="service-card__content">
                    <div class="service-card__icon" aria-hidden="true"><?= $serviceIcons[$index] ?? '🐾' ?></div>
                    <h2><?= htmlspecialchars($service['name']) ?></h2>
                    <p><?= htmlspecialchars($service['description']) ?></p>
                </div>
                <div class="service-card__footer">
                    <strong class="service-card__price"><?= htmlspecialchars($service['price']) ?></strong>
                    <a href="index.php?route=<?= htmlspecialchars($service['route']) ?>" class="btn btn--small">
                        <?= htmlspecialchars($service['button']) ?>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .services-visual { display:flex; align-items:center; justify-content:center; gap:18px; height:112px; margin-bottom:24px; background:linear-gradient(135deg, #eff6ff, #dbeafe); border:1px solid #bfdbfe; border-radius:18px; box-shadow:0 5px 16px rgba(37,99,235,.08); }
    .services-visual span { display:flex; align-items:center; justify-content:center; width:58px; height:58px; background:#fff; border-radius:50%; font-size:2rem; box-shadow:0 3px 8px rgba(15,23,42,.08); }
    .services-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px; margin-top:24px; }
    .service-card { display:flex; flex-direction:column; justify-content:space-between; min-height:220px; padding:24px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 2px 8px rgba(15,23,42,.06); }
    .service-card h2 { margin:0 0 12px; font-size:1.2rem; }
    .service-card__icon { display:flex; align-items:center; justify-content:center; width:48px; height:48px; margin-bottom:14px; background:#eff6ff; border-radius:14px; font-size:1.6rem; }
    .service-card p { color:#64748b; margin:0; }
    .service-card__footer { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:24px; }
    .service-card__price { color:#1d4ed8; font-size:1.15rem; white-space:nowrap; }
    @media (max-width:600px) { .services-visual { gap:8px; } .services-visual span { width:48px; height:48px; font-size:1.6rem; } .service-card__footer { align-items:flex-start; flex-direction:column; } }
</style>
