<?php
declare(strict_types=1);

namespace App\DTO;

readonly class StockDTO {
    public function __construct(
        public string $ticker,
        public float $vpa,
        public float $lpa,
        public float $dividend,
        public float $currentPrice
    ) {}
}