<?php
$visits = $visits ?? [];
$message = $message ?? '';
$errors = $errors ?? [];
?>

<h1>Виїзд ветеринара додому</h1>
<p>Викличте ветеринара на дім у зручний для вас час. Виїзди на всій території міста.</p>

<?php if ($message !== ''): ?>
    <div class="alert alert--success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if (isset($errors['general'])): ?>
    <div class="alert alert--error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<h2>Замовити виїзд ветеринара</h2>
<form method="POST" action="index.php?route=service/home_visit" class="form">
    <div class="form__row">
        <div class="form__group <?= isset($errors['owner_name']) ? 'form__group--error' : '' ?>">
            <label for="hv_name" class="form__label">Ім'я власника <span class="required">*</span></label>
            <input type="text" id="hv_name" name="owner_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['owner_name'] ?? '') ?>"
                   placeholder="Ваше повне ім'я">
            <?php if (isset($errors['owner_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['owner_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['phone']) ? 'form__group--error' : '' ?>">
            <label for="hv_phone" class="form__label">Телефон <span class="required">*</span></label>
            <input type="tel" id="hv_phone" name="phone" class="form__input"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                   placeholder="+380 123 456 789">
            <?php if (isset($errors['phone'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['phone']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__group <?= isset($errors['address']) ? 'form__group--error' : '' ?>">
        <label for="hv_address" class="form__label">Адреса вашого дому <span class="required">*</span></label>
        <input type="text" id="hv_address" name="address" class="form__input"
               value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
               placeholder="м. Київ, вул. Лесі Українки, 10, кв. 5">
        <?php if (isset($errors['address'])): ?>
            <span class="form__error"><?= htmlspecialchars($errors['address']) ?></span>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['animal_name']) ? 'form__group--error' : '' ?>">
            <label for="hv_animal" class="form__label">Кличка тварини <span class="required">*</span></label>
            <input type="text" id="hv_animal" name="animal_name" class="form__input"
                   value="<?= htmlspecialchars($_POST['animal_name'] ?? '') ?>"
                   placeholder="Шарік">
            <?php if (isset($errors['animal_name'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['animal_name']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group">
            <label for="hv_problem" class="form__label">Причина візиту / Назва послуги</label>
            <input type="text" id="hv_problem" name="problem" class="form__input"
                   value="<?= htmlspecialchars($_POST['problem'] ?? '') ?>"
                   placeholder="Щеплення, огляд, консультація...">
        </div>
    </div>

    <div class="form__row">
        <div class="form__group <?= isset($errors['visit_date']) ? 'form__group--error' : '' ?>">
            <label for="hv_date" class="form__label">Бажана дата візиту <span class="required">*</span></label>
            <input type="date" id="hv_date" name="visit_date" class="form__input"
                   value="<?= htmlspecialchars($_POST['visit_date'] ?? '') ?>"
                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
            <?php if (isset($errors['visit_date'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['visit_date']) ?></span>
            <?php endif; ?>
        </div>

        <div class="form__group <?= isset($errors['visit_time']) ? 'form__group--error' : '' ?>">
            <label for="hv_time" class="form__label">Бажаний час (9:00-18:00) <span class="required">*</span></label>
            <input type="time" id="hv_time" name="visit_time" class="form__input"
                   value="<?= htmlspecialchars($_POST['visit_time'] ?? '') ?>"
                   min="09:00" max="18:00">
            <?php if (isset($errors['visit_time'])): ?>
                <span class="form__error"><?= htmlspecialchars($errors['visit_time']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__actions">
        <button type="submit" class="btn">Замовити виїзд</button>
    </div>
</form>

<?php if (!empty($visits)): ?>
    <h2>Записані виїзди (<?= count($visits) ?>)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Дата й час</th>
                <th>Власник</th>
                <th>Адреса</th>
                <th>Тварина</th>
                <th>Послуга</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visits as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v['visit_date'] . ' ' . $v['visit_time']) ?></td>
                    <td><?= htmlspecialchars($v['owner_name']) ?></td>
                    <td><?= htmlspecialchars(mb_substr($v['address'], 0, 40)) ?>...</td>
                    <td><?= htmlspecialchars($v['animal_name']) ?></td>
                    <td><?= htmlspecialchars($v['problem'] ?? '—') ?></td>
                    <td>
                        <span class="badge badge--<?= $v['status'] === 'confirmed' ? 'success' : 'info' ?>">
                            <?= htmlspecialchars(ucfirst($v['status']) === 'Pending' ? 'На розгляді' : 'Підтверджено') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
