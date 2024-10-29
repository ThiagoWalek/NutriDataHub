<?php


date_default_timezone_set('America/Sao_Paulo');

// Conectar ao banco de dados
$servername = "localhost"; // Alterar conforme necessário
$username = "root";        // Usuário do banco de dados
$password = "";            // Senha do banco de dados
$dbname = "BioStatix";    // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação e sanitização dos dados
    $data = isset($_POST['data']) ? mysqli_real_escape_string($conn, $_POST['data']) : null;
    $peso = isset($_POST['peso']) ? floatval($_POST['peso']) : null;
    $gordura = !empty($_POST['gordura']) ? floatval($_POST['gordura']) : null;
    $massa = !empty($_POST['massa']) ? floatval($_POST['massa']) : null;
    $id_cliente = !empty($_POST['id_cliente']) ? intval($_POST['id_cliente']) : null;

    // Valida se a data está no formato correto
    $dataValida = DateTime::createFromFormat('Y-m-d', $data);
    
    if ($dataValida) {
        // Captura a hora atual do sistema no formato H:i
        $hora = date('H:i');

        // Prepara a consulta SQL para inserir os dados na tabela
        $sql = "INSERT INTO registros (data, horario, peso, gordura, massa, id_cliente) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepara e executa a instrução SQL com parâmetros
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssdddi", $data, $hora, $peso, $gordura, $massa, $id_cliente);

            // Executa a consulta e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                echo "Registro inserido com sucesso!";
            } else {
                echo "Erro ao inserir o registro: " . $stmt->error;
            }

            // Fecha a instrução
            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "Data inválida!";
    }
}

// Fecha a conexão com o banco
$conn->close();
?>
