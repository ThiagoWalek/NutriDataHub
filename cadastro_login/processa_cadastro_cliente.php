<?php
session_start(); // Iniciar sessão para mensagens de feedback (opcional)

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
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $idade = $_POST['idade'];
    $altura = $_POST['altura'];

    // Verificação se o e-mail já está cadastrado
    $sqlCheck = "SELECT * FROM clientes WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo "Erro: O e-mail já está cadastrado!";
    } else {
        // Inserção no banco de dados com a senha hashada
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Usando hash seguro
        $sql = "INSERT INTO clientes (nome, genero, email, senha, idade, altura) 
                VALUES (:nome, :genero, :email, :senha, :idade, :altura)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->bindParam(':altura', $altura, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            // Redirecionar para a página de login ou página inicial, se necessário
            header('Location: login_cliente.html');
            exit;
        } else {
            echo "Erro ao cadastrar o cliente.";
        }
    }
}
?>
