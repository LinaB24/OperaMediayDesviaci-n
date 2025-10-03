<?php
class Stats {

    // Parsear lista de valores (separados por coma, espacio o salto de línea)
    public static function parseInput(string $input): array {
        $tokens = preg_split('/[\s,;]+/', trim($input));
        $values = [];
        $ignored = 0;

        foreach ($tokens as $tok) {
            if ($tok === '') continue;
            if (is_numeric($tok)) {
                $values[] = (float)$tok;
            } else {
                $ignored++;
            }
        }
        return [$values, $ignored];
    }

    // Calcular media y desviación estándar (poblacional o muestral)
    public static function analyze(array $values, bool $poblacional = true): array {
        $n = count($values);
        if ($n === 0) {
            return ['n'=>0,'mean'=>null,'sigma'=>null,'min'=>null,'max'=>null,'range'=>null];
        }

        $sum = array_sum($values);
        $mean = $sum / $n;

        // Varianza
        $sq = 0.0;
        foreach ($values as $x) {
            $sq += pow($x - $mean, 2);
        }
        $var = $poblacional ? $sq / $n : ($n > 1 ? $sq / ($n - 1) : NAN);
        $sigma = sqrt($var);

        return [
            'n' => $n,
            'mean' => $mean,
            'sigma' => $sigma,
            'min' => min($values),
            'max' => max($values),
            'range' => max($values) - min($values)
        ];
    }

    // Formato con 6 decimales
    public static function fmt($v): string {
        if ($v === null || is_nan($v)) return '—';
        return number_format($v, 6, '.', '');
    }
}
