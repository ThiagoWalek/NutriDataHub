<?php
// Conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Senha do banco de dados
$dbname = "BioStatix"; // Nome do banco de dados

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para buscar os clientes pelo id_nutricionista presente na tabela 'registros'
$sql = "SELECT DISTINCT c.id, c.nome, c.email, c.telefone, r.id_nutricionista FROM clientes c JOIN registros r ON c.id = r.id_cliente ORDER BY c.nome ASC";

$result = $conn->query($sql);

$clientes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

// Retorna os clientes como JSON
header('Content-Type: application/json');
echo json_encode($clientes);

// Fecha a conexão
$conn->close();
?>
