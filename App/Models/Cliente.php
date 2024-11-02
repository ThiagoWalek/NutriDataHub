<?php
class Cliente {
    private $conn;
    private $table_name = 'clientes';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar($nome, $peso, $idade, $genero, $altura, $email, $senha) {
        $query = "INSERT INTO " . $this->table_name . " (nome, peso, idade, genero, altura, email, senha) VALUES (:nome, :peso, :idade, :genero, :altura, :email, :senha)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':peso', $peso);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':altura', $altura);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        return $stmt->execute();
    }

    public function login($email, $senha) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email AND senha = :senha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
