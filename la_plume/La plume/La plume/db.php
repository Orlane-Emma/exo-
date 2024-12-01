<?php
$servername = "localhost";  // Changez ceci en fonction de votre configuration
$username = "root";         // Nom d'utilisateur de votre base de données
$password = "";             // Mot de passe pour la base de données
$dbname = "la_plume";       // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>

