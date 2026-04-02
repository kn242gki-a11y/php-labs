<?php
$getParams = $getParams ?? [];
$postParams = $postParams ?? [];
$method = $method ?? 'GET';
?>

<h1>🔍 Моніторинг запитів (Debug Mode)</h1>
<p class="text-muted">Ця сторінка дозволяє перевірити, як сервер обробляє вхідні дані пацієнтів та налаштувань.</p>

<div class="reqview-grid">
    <div class="reqview-section">
        <h2>📝 Тестова форма пацієнта</h2>
        <p>Надішліть POST-запит, щоб побачити, як дані потрапляють у масив <code>$_POST</code>:</p>
        
        <form method="POST" action="index.php?route=reqview/showrequest&source=debug_tool" class="form">
            <div class="form__group">
                <label for="pet_name" class="form__label">Кличка тварини</label>
                <input type="text" id="pet_name" name="pet_name" class="form__input" placeholder="Наприклад: Арчі">
            </div>
            
            <div class="form__group">
                <label for="service_type" class="form__label">Послуга</label>
                <select id="service_type" name="service" class="form__input">
                    <option value="vaccination">Вакцинація</option>
                    <option value="consultation">Консультація</option>
                    <option value="surgery">Хірургія</option>
                </select>
            </div>
            
            <div class="form__group">
                <label for="priority" class="form__label">Терміновість (1-5)</label>
                <input type="number" id="priority" name="priority_level" class="form__input" value="1" min="1" max="5">
            </div>
            
            <button type="submit" class="btn">Надіслати POST запит</button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
        
        <h3>Тестування GET-параметрів</h3>
        <p>Спробуйте вручну додати параметри в адресний рядок:</p>
        <code class="code-block">index.php?route=reqview/showrequest&doctor=Ivanov&cabinet=105</code>
    </div>

    <div class="reqview-section">
        <h2>Отримані дані</h2>
        <p><strong>Метод запиту:</strong> <span class="btn btn--small" style="background: #065f46; cursor: default;"><?= htmlspecialchars($method) ?></span></p>

        <h3>Масив GET (URL)</h3>
        <?php if (empty($getParams)): ?>
            <p class="text-muted italic">GET-параметри не передані.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr><th>Ключ</th><th>Значення</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($getParams as $key => $value): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($key) ?></code></td>
                            <td><?= htmlspecialchars(is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h3 style="margin-top: 30px;">Масив POST (Body)</h3>
        <?php if (empty($postParams)): ?>
            <p class="text-muted italic">POST-дані відсутні. Скористайтеся формою зліва.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr><th>Ключ</th><th>Значення</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($postParams as $key => $value): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($key) ?></code></td>
                            <td><?= htmlspecialchars(is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>