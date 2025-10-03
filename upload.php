<?php
require_once "Stats.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["csv"])) {
    $file = $_FILES["csv"]["tmp_name"];
    $content = file_get_contents($file);
    [$values, $ignored] = Stats::parseInput($content);
    $result = Stats::analyze($values);
}
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>SCMDE - CSV</title></head>
<body>
<h1>Cargar CSV</h1>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="csv" accept=".csv,.txt">
    <button type="submit">Calcular</button>
</form>
<?php if (!empty($result)): ?>
<p>Media: <?= Stats::fmt($result['mean']) ?></p>
<p>σ: <?= Stats::fmt($result['sigma']) ?></p>
<?php endif; ?>
</body>
</html>
