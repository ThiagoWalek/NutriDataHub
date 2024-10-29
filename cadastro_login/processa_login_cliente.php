<?php
session_start(); // Inicia a sessão para armazenar dados do usuário

// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'BioStatix';
$username = 'root';
$password = '';

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Verificação se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para verificar se o e-mail existe e obter a senha
    $sql = "SELECT * FROM clientes WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificação se a consulta retornou um resultado
    if ($cliente) {
        // Verifica se a senha está correta
        if (password_verify($senha, $cliente['senha'])) {
            // Login bem-sucedido
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nome'] = $cliente['nome'];
            echo "Login bem-sucedido! Bem-vindo, " . $cliente['nome'] . ".";
            // Redirecionar para a página inicial do cliente (ex: dashboard_cliente.php)
            header('Location: ../users/index.html');
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "E-mail não encontrado!";
    }
}
?>
