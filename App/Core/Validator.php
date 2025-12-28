<?php
declare(strict_types=1);

namespace App\Core;

class Validator {
    public static function validateStockData(array $rawData): array {
    $errors = [];
    $data = [];

    // Limpeza básica do Ticker
    $data['ticker'] = filter_var($rawData['ticker'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Lista de campos simples
    $simpleFields = ['vpa', 'lpa', 'current_price'];
    foreach ($simpleFields as $field) {
        $val = str_replace(',', '.', $rawData[$field] ?? '0');
        $data[$field] = filter_var($val, FILTER_VALIDATE_FLOAT);
        if ($data[$field] === false) $errors[] = "Campo $field inválido.";
    }

    // Lógica dos Dividendos (Os 5 anos)
    $sum = 0;
    for ($i = 1; $i <= 5; $i++) {
        $divVal = str_replace(',', '.', $rawData["div$i"] ?? '0');
        $val = filter_var($divVal, FILTER_VALIDATE_FLOAT);
        if ($val === false) {
            $errors[] = "Dividendo do ano $i inválido.";
        } else {
            $sum += $val;
        }
    }
    
    // Calculamos a média e salvamos na chave 'dividend'
    $data['dividend'] = $sum / 5;

    return ['errors' => $errors, 'data' => $data];
}
}