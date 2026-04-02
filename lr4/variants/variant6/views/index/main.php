<div class="page-home">
    <h1>🐾 Ветклініка «Лапки»</h1>
    <p class="page-home__subtitle">Турбота про ваших улюбленців — наша головна місія. Клініка працює 24/7 для здоров'я ваших тварин.</p>

    <div class="card-grid">
        <div class="card">
            <h3 class="card__title">Наші послуги</h3>
            <p class="card__text">
                Терапія, хірургія, вакцинація та професійна гігієна. 
                Ми використовуємо сучасне обладнання для діагностики (УЗД, Рентген).
            </p>
        </div>

        <div class="card">
            <h3 class="card__title">Реєстрація власника</h3>
            <p class="card__text">
                Зареєструйте себе та свого улюбленця в нашій базі, щоб отримувати 
                нагадування про щеплення та записуватися до лікарів онлайн.
            </p>
            <a href="index.php?route=regform/form" class="btn btn--small">Створити картку</a>
        </div>

        <div class="card">
            <h3 class="card__title">Параметри запиту</h3>
            <p class="card__text">
                Технічний розділ для розробника (Катерини): перегляд поточних 
                GET та POST параметрів для відлагодження системи.
            </p>
            <a href="index.php?route=reqview/showrequest" class="btn btn--small">Перейти до дебагу</a>
        </div>

        <div class="card">
            <h3 class="card__title">Налаштування</h3>
            <p class="card__text">
                Змініть колір інтерфейсу на більш приємний для очей та 
                встановіть персональне вітання власника.
            </p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштувати</a>
        </div>
    </div>

    <div class="info-block">
        <h2>Архітектура проекту (MVC)</h2>
        <p>Система побудована на власному мікро-фреймворку з використанням об'єктно-орієнтованого підходу:</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Клас</th>
                    <th>Призначення у проекті VetClinic</th>
                </tr>
            </thead>
            <tbody>
                <tr><td><code>Application</code></td><td>Точка входу: ініціалізує сесії та запускає додаток</td></tr>
                <tr><td><code>Router</code></td><td>Аналізує URL та визначає, якого лікаря (контролер) викликати</td></tr>
                <tr><td><code>Request</code></td><td>Безпечно обробляє дані форм реєстрації та налаштувань</td></tr>
                <tr><td><code>Controller</code></td><td>Базовий клас: містить логіку перенаправлень (redirect)</td></tr>
                <tr><td><code>PageController</code></td><td>Відповідає за логіку відображення сторінок клініки</td></tr>
                <tr><td><code>View</code></td><td>Забезпечує рендеринг PHP-файлів у HTML</td></tr>
                <tr><td><code>PageView</code></td><td>Створює цілісний інтерфейс, об'єднуючи контент із Header та Footer</td></tr>
            </tbody>
        </table>
    </div>
</div>