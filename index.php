<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

echo json_encode(["mensagem" => "Bem-vindo ao backend!"]);
?>
