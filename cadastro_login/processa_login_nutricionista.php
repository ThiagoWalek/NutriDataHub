<?php
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
