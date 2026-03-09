<?php

require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="demo-card">
    <h2>Калькулятор функцій</h2>
    <p class="demo-subtitle">Обчислення: sin, cos, tg, x^y, x!</p>

    <form method="post" action="task11_result.php" class="demo-form">
        <div class="form-row">
            <div>
                <label for="x">Значення X (основа/курт)</label>
                <input type="number" id="x" name="x" step="any" value="<?= htmlspecialchars($_GET['x'] ?? '6') ?>" placeholder="Введіть X" required>
            </div>
            <div>
                <label for="y">Значення Y (степінь)</label>
                <input type="number" id="y" name="y" step="any" value="<?= htmlspecialchars($_GET['y'] ?? '2') ?>" placeholder="Введіть Y" required>
            </div>
        </div>
        <button type="submit" class="btn-submit">Обчислити</button>
    </form>

    <div class="demo-section">
        <h3>Очікувані результати (для X=6, Y=2)</h3>
        <table class="demo-table">
            <thead>
                <tr>
                    <th>Функція</th>
                    <th>Вираз</th>
                    <th>Результат</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>sin</code></td>
                    <td>sin(6)</td>
                    <td><span class="demo-tag">-0.2794</span></td>
                </tr>
                <tr>
                    <td><code>cos</code></td>
                    <td>cos(6)</td>
                    <td><span class="demo-tag">0.9602</span></td>
                </tr>
                <tr>
                    <td><code>tg</code></td>
                    <td>tan(6)</td>
                    <td><span class="demo-tag">-0.291</span></td>
                </tr>
                <tr>
                    <td><code>my_tg</code></td>
                    <td>sin(6)/cos(6)</td>
                    <td><span class="demo-tag">-0.291</span></td>
                </tr>
                <tr>
                    <td><code>Степінь</code></td>
                    <td>6^2</td>
                    <td><span class="demo-tag demo-tag-success">36</span></td>
                </tr>
                <tr>
                    <td><code>Факторіал</code></td>
                    <td>6!</td>
                    <td><span class="demo-tag demo-tag-primary">720</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="demo-code">
    </div>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 11');