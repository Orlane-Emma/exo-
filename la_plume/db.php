<?php
$host = 'localhost';
$user = 'root';      
$password = '';      
$dbname = 'la_plume';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
?>
