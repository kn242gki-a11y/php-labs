<?php
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = ($_SESSION['user_role'] ?? '') === 'admin' || ($_SESSION['user_login'] ?? '') === 'admin';
?>

<div class="page-home">
    <div class="hero">
        <div class="hero__visual" aria-hidden="true">
            <span class="hero__paw">🐾</span>
            <span class="hero__heart">♥</span>
        </div>
        <h1>Ветеринарна клініка "Добра лапа"</h1>
        <p class="hero__description">Професійна допомога вашим улюбленцям. Система управління тваринами, гостьова книга, галерея фото та електронний запис.</p>
        <div class="hero__info">
            <div class="hero__item">
                <strong>Графік роботи:</strong> Пн-Пт 9:00-18:00, Сб 10:00-16:00
            </div>
            <div class="hero__item">
                <strong>Телефон:</strong> +380 123 456 789
            </div>
            <div class="hero__item">
                <strong>Адреса:</strong> вул. Ветеринарна, 10, Житомир
            </div>
        </div>
    </div>

    <div class="card card--urgent card--urgent-top">
            <div class="card__icon" aria-hidden="true">🚨</div>
            <h3 class="card__title">Швидка ветеринарна допомога</h3>
            <p class="card__text">Екстрена допомога тваринам 24/7. Опишіть проблему та отримайте можливо найшвидшої допомоги.</p>
            <a href="index.php?route=service/emergency" class="btn btn--small">Подати запит</a>
    </div>

    <h2>Наші послуги</h2>
    <div class="card-grid">

        <div class="card">
            <div class="card__icon" aria-hidden="true">🩺</div>
            <h3 class="card__title">Запис до лікаря</h3>
            <p class="card__text">Запишіться на прийом до ветеринара онлайн. Вкажіть дату, час та причину візиту.</p>
            <a href="index.php?route=service/index" class="btn btn--small">Записатися</a>
        </div>

        <div class="card">
            <div class="card__icon" aria-hidden="true">🚑</div>
            <h3 class="card__title">Виїзд ветеринара додому</h3>
            <p class="card__text">Викличте ветеринара на дім у зручний час. Виїзди вся Київ.</p>
            <a href="index.php?route=service/home_visit" class="btn btn--small">Замовити виїзд</a>
        </div>

        <div class="card">
            <div class="card__icon" aria-hidden="true">🤝</div>
            <h3 class="card__title">Волонтерство</h3>
            <p class="card__text">Приєднуйтесь до нашої команди волонтерів. Допомагайте тваринам і розвивайте себе.</p>
            <a href="index.php?route=volunteer/index" class="btn btn--small">Волонтери</a>
        </div>

    </div>

    <h2>Електронний кабінет</h2>
    <div class="card-grid">
        <?php if ($isAdmin): ?>
        <div class="card">
            <h3 class="card__title">База тварин</h3>
            <p class="card__text">Електронний запис ваших тварин з усією інформацією про лікування та догляд.</p>
            <a href="index.php?route=animal/list" class="btn btn--small">До тварин</a>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card__icon" aria-hidden="true">👤</div>
            <h3 class="card__title">Особистий кабінет</h3>
            <p class="card__text">Реєстрація, вхід до системи, управління профілем власника.</p>
            <a href="index.php?route=auth/login" class="btn btn--small">Увійти</a>
        </div>

        <div class="card">
            <div class="card__icon" aria-hidden="true">⚙️</div>
            <h3 class="card__title">Налаштування</h3>
            <p class="card__text">Персональні налаштування інтерфейсу та привітання.</p>
            <a href="index.php?route=settings/color" class="btn btn--small">Налаштування</a>
        </div>
    </div>

    <section class="clinic-info" aria-labelledby="clinic-info-title">
        <h2 id="clinic-info-title">Додаткова інформація про клініку</h2>
        <div class="clinic-info__grid">
            <div>
                <h3>Про нас</h3>
                <p>«Добра лапа» — це турбота, професійний догляд і безпечне лікування домашніх улюбленців.</p>
            </div>
            <div>
                <h3>Наші лікарі</h3>
                <p>Досвідчені ветеринари допомагають собакам, котам, птахам та іншим домашнім тваринам.</p>
            </div>
            <div>
                <h3>Як нас знайти</h3>
                <p>Ми працюємо в Житомирі. Попередній запис допоможе обрати зручний час прийому.</p>
            </div>
        </div>
    </section>
</div>
