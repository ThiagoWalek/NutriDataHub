<?php
ob_start(); // Inicia o buffer de saída

// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BioStatix";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Erro na conexão: ' . $conn->connect_error]));
}

// Verifica se um ID foi passado para exclusão
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Debug: Exibir o ID recebido
    error_log("ID recebido: " . $id);

    // Prepara a consulta SQL
    $stmt = $conn->prepare("DELETE FROM registros WHERE id = ?");
    
    if ($stmt === false) {
        die(json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $conn->error]));
    }

    $stmt->bind_param("i", $id);

    // Executa a consulta
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            // Debug: Nenhum registro encontrado
            error_log("Nenhum registro encontrado para ID: " . $id);
            echo json_encode(['success' => false, 'message' => 'Nenhum registro encontrado para deletar']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao executar a consulta: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
}

// Fecha a conexão
$conn->close();
ob_end_flush(); // Envia o buffer de saída e limpa
?>
