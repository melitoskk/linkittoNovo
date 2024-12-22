<?php
include '../db_config.php';

$servername = $env_ip;
$username = $env_user;
$password = $env_password;
$dbname = $env_db;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function gerarIdAleatorio($conn) {
    do {
        $id = rand(1000, 9999);
        $sql = "SELECT id FROM produtos WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);

    return $id;
}

echo gerarIdAleatorio($conn);

$conn->close();
?>
