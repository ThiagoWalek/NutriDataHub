<?php

namespace App\Controllers;

use mysqli;

class RegistroController
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "BioStatix";

        // Conexão com o banco de dados
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($this->conn->connect_error) {
            die(json_encode(['success' => false, 'message' => 'Erro na conexão: ' . $this->conn->connect_error]));
        }
    }

    public function deletarRegistro($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM registros WHERE id = ?");
        
        if ($stmt === false) {
            die(json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $this->conn->error]));
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Nenhum registro encontrado para deletar']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar a consulta: ' . $stmt->error]);
        }
        require __DIR__ . '/../Views/nutricionista/visualizar_cliente.php';
        $stmt->close();
    }

    public function listarRegistros($id_cliente = null)
    {
        // Ajusta a consulta SQL para filtrar por id_cliente, se fornecido
        $sql = "SELECT id, data, horario AS hora, peso, gordura, massa, id_cliente 
                FROM registros ";

        if ($id_cliente) {
            $sql .= "WHERE id_cliente = ? ";
        }

        $sql .= "ORDER BY data DESC, horario DESC";

        $stmt = $this->conn->prepare($sql);

        if ($id_cliente) {
            $stmt->bind_param("i", $id_cliente);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $registros = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $registros[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($registros);

        $stmt->close();
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
