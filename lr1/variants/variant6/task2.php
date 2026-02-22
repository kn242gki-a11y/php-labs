<?php

require_once __DIR__ . '/layout.php';

ob_start();
?>
<div class="poem">
    <?php
    echo "<p class='poem-indent-1'>Річка <b>тече</b> крізь зелений луг,</p>";
    echo "<p class='poem-indent-1'> Верби схилилися <i>задумливо</i> над водою,</p>";
    echo "<p class='poem-indent-1'>Жабки співають свій пісенний круг,</p>";
    echo "<p class='poem-indent-1'>А місяць сяє срібною зорею.</p>";
    ?>
</div>
<?php
$content = ob_get_clean();

renderVariantLayout($content, 'Завдання 1', 'task2-body');
