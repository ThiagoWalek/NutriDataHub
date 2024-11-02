<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Nutricionista</title>
    <link rel="stylesheet" href="/app/public/css/style.css"> <!-- Certifique-se de que o caminho para o CSS está correto -->
</head>
<body>
    <div class="login-container">
        <h1>Login Nutricionista</h1>
        <form action="processa_login_nutricionista.php" method="POST"> <!-- Altere "processa_login.php" para o nome do arquivo de processamento -->
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group">
                 <label for="password">Senha</label><!--estava tentando pegar  o valor do campo password, porém tinha de ter alterado para senha, um dos erros mais dificeis até agora foi tão sdimples de resolver -->
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

<!-- <?php
// Configurações de conexão com o banco de dados
$host = 'localhost'; // Nome do host
$dbname = 'BioStatix'; // Nome do banco de dados
$username = 'root'; // Nome de usuário do banco de dados
$password = ''; // Senha do banco de dados

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
    $senha = $_POST['senha']; // Senha digitada no formulário

    // Consulta apenas pelo e-mail
    $sql = "SELECT * FROM nutricionistas WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $nutricionista = $stmt->fetch(PDO::FETCH_ASSOC);

    // Depuração: Exibindo valores para comparar
    if ($nutricionista) {
        echo "<pre>";
        echo "Senha fornecida: '" . $senha . "'<br>";
        echo "Senha no banco de dados: '" . $nutricionista['senha'] . "'<br>";
        echo "</pre>";
    }

    // Verifica se o usuário foi encontrado e compara a senha digitada
    if ($nutricionista) {
        // Comparação da senha armazenada com a senha digitada
        if ($nutricionista['senha'] === md5($senha)) {
            // Login bem-sucedido, criando um cookie para armazenar o login (opcional)
            setcookie("login", $email, time() + (86400 * 30), "/"); // Cookie válido por 30 dias
            header("Location: ../index.html"); // Redirecionar para o caminho desejado
            exit;
        } else {
            // Senha incorreta - mostrar mensagem de erro
            echo "<script language='javascript' type='text/javascript'>
                    alert('Senha no banco de dados: " . $nutricionista['senha'] . "\\nSenha fornecida: " . $senha . "');
                    window.location.href='cadastro_nutricionista.html';
                  </script>";
            exit;
        }
    } else {
        // E-mail não encontrado no banco de dados
        echo "<script language='javascript' type='text/javascript'>
                alert('E-mail não encontrado');
                window.location.href='cadastro_nutricionista.html';
              </script>";
        exit;
    }
}
?>
 -->
