<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Stock;
use App\Core\Session;
use App\Core\Validator;
use App\DTO\StockDTO;

class StockController
{
    public function index()
    {
        $stockModel = new Stock();
        $stocks = $stockModel->getAll();
        require_once "../views/dashboard.php";
    }

    public function store()
    {
        $validation = Validator::validateStockData($_POST);

        if (!empty($validation['errors'])) {
            Session::setFlash('error', implode(' | ', $validation['errors']));
            header("Location: ./");
            exit;
        }

        $data = $validation['data'];

        $stockDTO = new StockDTO(
            strtoupper($data['ticker']),
            (float)$data['vpa'],
            (float)$data['lpa'],
            (float)$data['dividend'],
            (float)$data['current_price']
        );

        $model = new Stock();
        $model->save($stockDTO);

        Session::setFlash('success', "Ativo {$data['ticker']} analisado com sucesso!");
        header("Location: ./");
        exit;
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            (new Stock())->delete($id);
            \App\Core\Session::setFlash('success', "Ativo removido.");
        }
        header("Location: ./");
        exit;
    }
}
