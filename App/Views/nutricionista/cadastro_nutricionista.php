<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Nutricionista</title>
    <link rel="stylesheet" href="/app/public/css/style.css">

</head>
<body>
    <h1>Cadastro de Nutricionista</h1>
    <form action="processa_cadastro_nutricionista.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Cadastrar Nutricionista</button>
    </form>
</body>
</html>


<!-- <?php
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
?> -->
