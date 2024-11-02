<?php

namespace App\Models;

class Nutricionista {
    private $conn;
    private $table_name = 'nutricionistas';

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Cadastrar
    public function cadastrar($nome, $email, $senha) {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT));
        return $stmt->execute();
    }

    // READ - Listar Todos
    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // READ - Buscar por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // UPDATE - Atualizar
    public function atualizar($id, $nome, $email, $senha) {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // DELETE - Excluir
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $nutricionista = new Nutricionista($this->db);

            if ($nutricionista->login($email, $senha)) {
                header('Location: /home'); // Redireciona para a página inicial ou dashboard
                exit;
            } else {
                echo "Email ou senha incorretos!";
            }
        }
    }

    public function logout() {
        $nutricionista = new Nutricionista($this->db);
        $nutricionista->logout();
        header(header: 'Location: /login'); // Redireciona para a página de login
        exit;
    }
}