<?php
require_once __DIR__ . '/layout.php';

function findAndReplace(string $text, string $find, string $replace): string
{
    if ($find === '') {
        return $text;
    }
    return str_replace($find, $replace, $text);
}

$defaultText = "Древні замки Поділля зберігають таємниці минулих століть привертаючи увагу дослідників та любителів старовини";
$defaultFind = "т";
$defaultReplace = "д";

$text = $_POST['text'] ?? $defaultText;
$find = $_POST['find'] ?? $defaultFind;
$replace = $_POST['replace'] ?? $defaultReplace;
$result = '';
$submitted = isset($_POST['text']);

if ($submitted && $find !== '') {
    $result = findAndReplace($text, $find, $replace);
}

ob_start();
?>
<div class="demo-card">
    <h2>Завдання 1: Пошук та заміна</h2>
    <p class="demo-subtitle">Варіант: заміна символів "<?= htmlspecialchars($defaultFind) ?>" на "<?= htmlspecialchars($defaultReplace) ?>"</p>

    <form method="post" class="demo-form">
        <div>
            <label for="text">Текст для обробки</label>
            <textarea id="text" name="text" rows="4"><?= htmlspecialchars($text) ?></textarea>
        </div>
        <div class="form-row">
            <div>
                <label for="find">Знайти</label>
                <input type="text" id="find" name="find" value="<?= htmlspecialchars($find) ?>">
            </div>
            <div>
                <label for="replace">Замінити на</label>
                <input type="text" id="replace" name="replace" value="<?= htmlspecialchars($replace) ?>">
            </div>
        </div>
        <button type="submit" class="btn-submit">Виконати заміну</button>
    </form>

    <?php if ($submitted && $find !== ''): ?>
    <div class="demo-result">
        <h3>Отриманий результат</h3>
        <div class="demo-result-value"><?= htmlspecialchars($result) ?></div>
    </div>
    <div class="demo-code">
        <code>str_replace("<?= htmlspecialchars($find) ?>", "<?= htmlspecialchars($replace) ?>", text)</code>
    </div>
    <?php elseif ($submitted && $find === ''): ?>
    <div class="demo-result demo-result-error">
        <h3>Помилка</h3>
        <div class="demo-result-value">Поле для пошуку не може бути порожнім.</div>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
renderVariantLayout($content, 'Завдання 1');