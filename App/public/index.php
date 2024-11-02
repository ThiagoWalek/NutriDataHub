<?php
require_once __DIR__ . '/app/Config/database.php';
require_once __DIR__ . '/app/Models/Nutricionista.php';
require_once __DIR__ . '/app/Controllers/NutricionistaController.php';

use App\Controllers\NutricionistaController;
use App\Config\Database;

// Criando uma instância da conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

$url = $_GET['url'] ?? '';

// Passando a conexão ao instanciar o controller
if ($url === 'login') {
    $controller = new NutricionistaController($db);
    $controller->login();
} else {
    require __DIR__ . '/app/Views/nutricionista/login_nutricionista.php';
}

