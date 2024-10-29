<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Seu usuário do banco de dados
$password = ""; // Sua senha do banco de dados
$dbname = "BioStatix"; // Nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Consulta SQL para verificar se o e-mail existe no banco de dados
    $sql = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica a senha (comparando com o hash armazenado)
        if (password_verify($senha, $user['senha'])) {
            // Login bem-sucedido, salva o ID do usuário na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nome_usuario'] = $user['nome'];

            // Redireciona para a página inicial ou dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Senha incorreta
            echo "<p style='color:red;'>Senha incorreta.</p>";
        }
    } else {
        // E-mail não encontrado
        echo "<p style='color:red;'>Usuário não encontrado.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
