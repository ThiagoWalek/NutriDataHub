<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diretório de destino
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["planoDieta"]["name"]);

    // Verifica se o arquivo é realmente um .doc ou .docx
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($fileType != "doc" && $fileType != "docx") {
        die("Erro: Apenas arquivos do tipo Word (.doc, .docx) são permitidos.");
    }

    // Move o arquivo para o diretório de destino
    if (move_uploaded_file($_FILES["planoDieta"]["tmp_name"], $target_file)) {
        $googleFormsLink = $_POST['googleFormsLink'];
        echo "O arquivo " . htmlspecialchars(basename($_FILES["planoDieta"]["name"])) . " foi enviado com sucesso.<br>";
        echo "Link do formulário de acompanhamento: <a href='" . htmlspecialchars($googleFormsLink) . "' target='_blank'>Acompanhe aqui</a>";
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}
?>
