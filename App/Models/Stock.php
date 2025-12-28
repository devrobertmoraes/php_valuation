<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\DTO\StockDTO;

class Stock
{
    public function calculateGraham(float $vpa, float $lpa): float
    {
        if ($vpa <= 0 || $lpa <= 0) {
            return 0;
        }

        return sqrt(22.5 * $vpa * $lpa);
    }

    public function calculateBazin(float $dividend): float
    {
        return $dividend / 0.06;
    }

    public function getDecision(float $currentPrice, float $graham, float $bazin): string
    {
        $margin = 0.15;
        $isBelowGraham = $currentPrice <= ($graham * (1 - $margin));
        $isBelowBazin = $currentPrice <= $bazin;

        if ($isBelowGraham && $isBelowBazin) return "COMPRA FORTE";
        if ($isBelowGraham) return "Atrativo (Graham)";
        if ($isBelowBazin) return "Atrativo (Bazin)";

        return "CARO";
    }

    public function save(StockDTO $data): bool
    {
        $db = Database::getConnection();

        $graham = $this->calculateGraham($data->vpa, $data->lpa);
        $bazin = $this->calculateBazin($data->dividend);

        $sql = "INSERT INTO stocks (ticker, vpa, lpa, dividend, current_price, graham_price, bazin_price)
                VALUES (:ticker, :vpa, :lpa, :dividend, :current_price, :graham, :bazin)";

        $stmt = $db->prepare($sql);

        return $stmt->execute([
            'ticker'   => $data->ticker,
            'vpa'      => $data->vpa,
            'lpa'      => $data->lpa,
            'dividend' => $data->dividend,
            'current_price'    => $data->currentPrice,
            'graham'   => $graham,
            'bazin'    => $bazin
        ]);
    }

    public function getAll(): array
    {
        $db = Database::getConnection();
        return $db->query("SELECT * FROM stocks ORDER BY id DESC")->fetchAll();
    }

    public function delete(int $id): bool
    {
        $db = Database::getConnection();
        return $db->prepare("DELETE FROM stocks WHERE id = ?")->execute([$id]);
    }
}
