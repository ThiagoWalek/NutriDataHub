<?php
require_once '../App/Controllers/NutricionistaController.php';

use App\Controllers\NutricionistaController;

// Exemplo de configuração de banco de dados para passar ao controlador
$db = new PDO('mysql:host=localhost;dbname=BioStatix', 'root', '');

$authController = new NutricionistaController($db);

if ($_GET['url'] === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login();
} elseif ($_GET['url'] === 'logout') {
    $authController->logout();
}
