<?php
require_once "Stats.php";

$result = null;
$ignored = 0;
$inputText = "";
$isPopulation = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputText = $_POST["numbers"] ?? "";
    $isPopulation = isset($_POST["population"]);
    [$values, $ignored] = Stats::parseInput($inputText);
    $result = Stats::analyze($values, $isPopulation);
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>SCMDE - Media y Desv. Estándar</title>
<style>
body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; }
textarea { width: 100%; height: 150px; font-family: monospace; }
table { border-collapse: collapse; margin-top: 20px; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
th { background: #f0f0f0; }
.result { margin-top: 20px; }
</style>
</head>
<body>
<h1>Software de Cálculo de Media y Desviación Estándar</h1>

<form method="post">
    <label>Ingresa los números (separados por comas, espacios o saltos de línea):</label><br>
    <textarea name="numbers"><?= htmlspecialchars($inputText) ?></textarea><br><br>
    <label><input type="checkbox" name="population" <?= $isPopulation ? "checked" : "" ?>> Usar desviación estándar poblacional (σ con n).<br>
    (Si se desmarca, se usa desviación muestral con n-1)</label><br><br>
    <button type="submit">Calcular</button>
</form>

<?php if ($result): ?>
<div class="result">
    <h2>Resultados</h2>
    <table>
        <tr><th>Datos válidos (n)</th><td><?= $result['n'] ?></td></tr>
        <tr><th>Ignorados (no numéricos)</th><td><?= $ignored ?></td></tr>
        <tr><th>Media (μ)</th><td><?= Stats::fmt($result['mean']) ?></td></tr>
        <tr><th>Desv. Estándar (σ)</th><td><?= Stats::fmt($result['sigma']) ?></td></tr>
        <tr><th>Mínimo</th><td><?= Stats::fmt($result['min']) ?></td></tr>
        <tr><th>Máximo</th><td><?= Stats::fmt($result['max']) ?></td></tr>
        <tr><th>Rango</th><td><?= Stats::fmt($result['range']) ?></td></tr>
    </table>
</div>
<?php endif; ?>

</body>
</html>
