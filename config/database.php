<?php
class Database {
    private $host = "sql10.freesqldatabase.com"; // Host do banco
    private $db_name = "sql10745247"; // Nome do banco
    private $username = "sql10745247"; // Usuário do banco
    private $password = "ixt9KzvwaW"; // Senha do banco
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

