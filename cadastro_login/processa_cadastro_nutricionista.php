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
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificação se o e-mail já está cadastrado
    $sqlCheck = "SELECT * FROM nutricionistas WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo "Erro: O e-mail já está cadastrado!";
    } else {
        // Inserção no banco de dados com a senha hashada
        $senhamd5 = md5($senha); // Usando hash seguro
        $sql = "INSERT INTO nutricionistas (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhamd5, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            //Redirecionar para a página de login, se necessário
            header('Location: login_nutricionista.html');
            exit;
        } else {
            echo "Erro ao cadastrar o nutricionista.";
        }
    }
}
?>
