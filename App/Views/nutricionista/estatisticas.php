<!-- <?php
// Conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Senha do banco de dados
$dbname = "BioStatix"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o id foi fornecido
$id_buscado = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : ''; // Pega o ID digitado no formulário

// Inicializa variáveis vazias para evitar erros
$idade = $altura = $genero = $nome = $gordura = $peso = $massa_muscular = null;

// Verifica se o ID foi fornecido
if ($id_buscado) {
    // Consulta para buscar o cliente pelo ID
    $sql_clientes = "SELECT idade, genero, altura, nome FROM clientes WHERE id = $id_buscado LIMIT 1";
    $resultado_clientes = $conn->query($sql_clientes);

    if ($resultado_clientes->num_rows > 0) {
        // Pega o registro do cliente
        $row = $resultado_clientes->fetch_assoc();
        $idade = $row['idade'];
        $altura = $row['altura'];
        $genero = $row['genero'];
        $nome = $row['nome'];

        // Consulta para buscar as informações de gordura, peso e massa muscular
        $sql_estatisticas = "SELECT gordura, peso, massa FROM registros WHERE id_cliente = $id_buscado ORDER BY data DESC LIMIT 1";
        $resultado_estatisticas = $conn->query($sql_estatisticas);

        if ($resultado_estatisticas->num_rows > 0) {
            $estatisticas = $resultado_estatisticas->fetch_assoc();
            $gordura = $estatisticas['gordura'];
            $peso = $estatisticas['peso'];
            $massa_muscular = $estatisticas['massa'];
        } else {
            echo "Nenhuma estatística encontrada para o cliente.";
        }
    } else {
        echo "Nenhum cliente encontrado com o ID $id_buscado.";
    }
} else {
    echo "Por favor, insira um ID para a busca.";
}
//$imc = $peso/($altura*$altura) || 0.00;


$conn->close();
?> -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas do Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/app/public/css/style.css">
    <style>
        .stats-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
        }
        .stat-label {
            color: #6c757d;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="registro.html">Registrar</a></li>
            <li><a href="peso.html">Peso</a></li>
            <li><a href="gordura.html">Gordura</a></li>
            <li><a href="massa.html">Massa Muscular</a></li>
            <li><a href="dieta.html">Plano de Dieta</a></li>
            <li><a href="estatisticas.php">Estatísticas do cliente</a></li>
        </ul>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Busca de Cliente</h1>

        <!-- Formulário de busca por ID -->
        <form method="POST" action="estatisticas.php" class="mb-4">
            <div class="input-group mb-3">
                <input type="number" class="form-control" name="id_cliente" placeholder="Digite o ID do cliente" required>
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>


        <h1 class="text-center mb-4">Estatísticas do Paciente <?php  echo $nome; ?></h1>


        <?php if ($nome): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number"><?php echo $nome; ?></div>
                    <div class="stat-label">Nome</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number"><?php echo $genero; ?></div>
                    <div class="stat-label">Gênero</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number"><?php echo $idade; ?> anos</div>
                    <div class="stat-label">Idade</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card text-center">
                    <div class="stat-number"><?php echo $altura; ?> m</div>
                    <div class="stat-label">Altura</div>
                </div>
            </div>
        </div>
        <div class="row">
      <div class="col-md-6">
        <div class="stats-card text-center">
          <div class="stat-number"><?php echo $peso; ?> kg</div>
          <div class="stat-label">Peso Atual</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="stats-card text-center">
          <div class="stat-number"><?php echo $gordura; ?>%</div>
          <div class="stat-label">Gordura Corporal</div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="stats-card text-center">
          <div class="stat-number"><?php echo number_format($imc, 2); ?></div>
          <div class="stat-label">IMC</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="stats-card text-center">
          <div class="stat-number"><?php echo $massa_muscular; ?> kg</div>
          <div class="stat-label">Massa Muscular</div>
        </div>
      </div>
    </div>
        <?php else: ?>
        <p class="text-center">Nenhum cliente encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
