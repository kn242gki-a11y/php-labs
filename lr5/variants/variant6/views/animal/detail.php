<?php
$animal = $animal ?? [];
$health_records = $health_records ?? [];
$vaccinations = $vaccinations ?? [];
?>

<h1><?= htmlspecialchars($animal['name']) ?></h1>

<div class="animal-detail">
    <div class="detail-section">
        <h2>Основна інформація</h2>
        <table class="info-table">
            <tr>
                <th>Вид:</th>
                <td><?= htmlspecialchars($animal['species']) ?></td>
                <th>Порода:</th>
                <td><?= htmlspecialchars($animal['breed'] ?: '—') ?></td>
            </tr>
            <tr>
                <th>Вік:</th>
                <td><?= (int)$animal['age'] ?> років</td>
                <th>Вага:</th>
                <td><?= $animal['weight'] > 0 ? $animal['weight'] . ' кг' : '—' ?></td>
            </tr>
            <tr>
                <th>Власник:</th>
                <td colspan="3"><?= htmlspecialchars($animal['owner']) ?></td>
            </tr>
            <tr>
                <th>Мікрочип:</th>
                <td colspan="3"><?= htmlspecialchars($animal['microchip'] ?: '—') ?></td>
            </tr>
            <tr>
                <th>Статус здоров'я:</th>
                <td>
                    <span class="health-badge health-<?= $animal['health_status'] === 'здорова' ? 'good' : 'caution' ?>">
                        <?= htmlspecialchars($animal['health_status']) ?>
                    </span>
                </td>
                <th>Останній візит:</th>
                <td><?= !empty($animal['last_visit']) ? date('d.m.Y', strtotime($animal['last_visit'])) : '—' ?></td>
            </tr>
        </table>
        <div class="action-buttons">
            <a href="index.php?route=animal/edit&id=<?= (int)$animal['id'] ?>" class="btn">Редагувати</a>
            <a href="index.php?route=animal/list" class="btn btn--secondary">До списку</a>
        </div>
    </div>

    <div class="detail-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>💊 Історія лікування</h2>
            <a href="index.php?route=animal/health_add&id=<?= (int)$animal['id'] ?>" class="btn btn--small">+ Додати запис</a>
        </div>
        
        <?php if (empty($health_records)): ?>
            <p class="text-muted">Записів про лікування ще немає.</p>
        <?php else: ?>
            <div class="records-list">
                <?php foreach ($health_records as $record): ?>
                    <div class="record-item">
                        <div class="record-date"><?= date('d.m.Y', strtotime($record['visit_date'])) ?></div>
                        <div class="record-content">
                            <p><strong>Діагноз:</strong> <?= htmlspecialchars($record['diagnosis'] ?: '—') ?></p>
                            <p><strong>Лікування:</strong> <?= htmlspecialchars($record['treatment'] ?: '—') ?></p>
                            <p><strong>Примітки:</strong> <?= htmlspecialchars($record['vet_notes'] ?: '—') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="detail-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>💉 Щеплення</h2>
            <a href="index.php?route=animal/vaccination_add&id=<?= (int)$animal['id'] ?>" class="btn btn--small">+ Додати щеплення</a>
        </div>
        
        <?php if (empty($vaccinations)): ?>
            <p class="text-muted">Записів про щеплення ще немає.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Щеплення</th>
                        <th>Дата</th>
                        <th>Наступне щеплення</th>
                        <th>Ветеринар</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vaccinations as $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($v['vaccine_name']) ?></td>
                            <td><?= date('d.m.Y', strtotime($v['vaccination_date'])) ?></td>
                            <td><?= !empty($v['next_due_date']) ? date('d.m.Y', strtotime($v['next_due_date'])) : '—' ?></td>
                            <td><?= htmlspecialchars($v['vet_name'] ?: '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style>
    .animal-detail {
        max-width: 1000px;
    }
    
    .detail-section {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .detail-section h2 {
        margin-top: 0;
        color: #333;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }
    
    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    
    .info-table tr {
        border-bottom: 1px solid #eee;
    }
    
    .info-table th {
        text-align: left;
        background: #f5f5f5;
        padding: 10px;
        font-weight: bold;
        width: 25%;
    }
    
    .info-table td {
        padding: 10px;
        color: #555;
    }
    
    .health-badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.95em;
        font-weight: bold;
        display: inline-block;
    }
    
    .health-good {
        background: #c8e6c9;
        color: #2e7d32;
    }
    
    .health-caution {
        background: #fff9c4;
        color: #f57f17;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    
    .records-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .record-item {
        border: 1px solid #eee;
        border-radius: 6px;
        overflow: hidden;
    }
    
    .record-date {
        background: #f5f5f5;
        padding: 10px;
        font-weight: bold;
        color: #666;
    }
    
    .record-content {
        padding: 15px;
    }
    
    .record-content p {
        margin: 8px 0;
        color: #555;
    }
</style>
