<div class="page-doctors">
    <h1>👨‍⚕️ Наші лікарі</h1>
    <p class="page-doctors__subtitle">Команда професіоналів, які піклуються про здоров'я ваших улюбленців</p>

    <div class="doctors-grid">
        <?php foreach ($doctors as $doctor): ?>
            <div class="doctor-card">
                <div class="doctor-card__avatar">
                    👨‍⚕️
                </div>
                <h3 class="doctor-card__name"><?= htmlspecialchars($doctor['name']) ?></h3>
                <p class="doctor-card__specialty"><?= htmlspecialchars($doctor['specialty']) ?></p>
                <p class="doctor-card__experience">Досвід: <?= htmlspecialchars($doctor['experience']) ?></p>
                <p class="doctor-card__description"><?= htmlspecialchars($doctor['description']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="info-block">
        <h2>Запис на прийом</h2>
        <p>Щоб записатися до одного з наших лікарів, спочатку зареєструйтеся в системі та створіть електронну картку вашого улюбленця.</p>
        <a href="index.php?route=regform/form" class="btn">Зареєструватися</a>
    </div>
</div>