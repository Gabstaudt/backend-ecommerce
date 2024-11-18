<?php
class Carrinho {
    private $conn;
    private $table_name = "Carrinho";

    public $id_carrinho;
    public $usuario_id;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET usuario_id=:usuario_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":usuario_id", $this->usuario_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
