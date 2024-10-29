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

// Verifica se um id_cliente foi passado pela URL
$id_cliente = isset($_GET['id_cliente']) ? (int)$_GET['id_cliente'] : 0;

// Ajusta a consulta SQL para filtrar por id_cliente, se fornecido
if ($id_cliente > 0) {
    $sql = "SELECT id, data, horario AS hora, peso, gordura, massa, id_cliente 
            FROM registros 
            WHERE id_cliente = $id_cliente 
            ORDER BY data DESC, horario DESC";
} else {
    $sql = "SELECT id, data, horario AS hora, peso, gordura, massa, id_cliente 
            FROM registros 
            ORDER BY data DESC, horario DESC";
}

$result = $conn->query($sql);

$registros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
}

// Retorna os registros como JSON
header('Content-Type: application/json');
echo json_encode($registros);

// Fecha a conexão
$conn->close();
?>
