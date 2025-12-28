<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../');
$dotenv->load();

use App\Controllers\StockController;
use App\Core\Router;

$router = new Router();

// Definição de Rotas (Mapeamento Limpo)
$router->get('/', [StockController::class, 'index']);
$router->get('/deletar', [StockController::class, 'delete']);
$router->post('/salvar', [StockController::class, 'store']);

// Execução
$router->run();
