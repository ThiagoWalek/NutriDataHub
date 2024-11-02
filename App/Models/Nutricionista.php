<?php

namespace App\Models;

class Nutricionista {
    private $conn;
    private $table_name = 'nutricionistas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar($nome, $email, $senha) {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT)); // hash da senha para segurança
        return $stmt->execute();
    }

    public function login($email, $senha) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $nutricionista = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verifica se o nutricionista existe e se a senha está correta
        if ($nutricionista && password_verify($senha, $nutricionista['senha'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start(); // Inicia a sessão apenas se não estiver iniciada
            }
            $_SESSION['nutricionista_id'] = $nutricionista['id'];
            $_SESSION['nutricionista_nome'] = $nutricionista['nome'];
            $_SESSION['nutricionista_email'] = $nutricionista['email'];
            return true;
        }
        return false;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
