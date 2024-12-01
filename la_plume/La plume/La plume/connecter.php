<?php 
session_start();
include 'db.php'; // Connexion à la base de données

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérification si l'utilisateur existe dans la table clients
    $sql_clients = "SELECT * FROM clients WHERE email = ?";
    $stmt_clients = $conn->prepare($sql_clients);
    $stmt_clients->bind_param("s", $email);
    $stmt_clients->execute();
    $result_clients = $stmt_clients->get_result();
    $client = $result_clients->fetch_assoc();

    // Vérification si l'utilisateur est un administrateur ou super-admin dans la table administrateurs
    $sql_admin = "SELECT * FROM administrateurs WHERE email = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    $administrateur = $result_admin->fetch_assoc();

    // Définir la variable utilisateur si un client ou un administrateur est trouvé
    $utilisateur = $client ?? $administrateur;

    // Si un utilisateur est trouvé et que le mot de passe est correct
    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mdp'])) {
        if (isset($utilisateur['id_client'])) {
            // Cas du client
            $_SESSION['client_id'] = $utilisateur['id_client'];
            $_SESSION['role'] = 'client';
            header("Location: index.html");
            exit();
        } elseif (isset($utilisateur['id_administrateur'])) {
            // Cas de l'administrateur
            $_SESSION['client_id'] = $utilisateur['id_administrateur'];
            $_SESSION['role'] = $utilisateur['role'];

            // Redirection en fonction du rôle
            if ($utilisateur['role'] == 'admin') {
                header("Location: admin.php");
                exit();
            } elseif ($utilisateur['role'] == 'super-admin') {
                header("Location: superadmin.php");
                exit();
            }
        }
    } else {
        // Si l'email ou le mot de passe est incorrect
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - La Plume</title>
    <link rel="stylesheet" href="css/style1.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>

        <!-- Affichage de l'erreur si elle existe -->
        <?php if (isset($erreur)) echo "<p class='error-message'>$erreur</p>"; ?>

        <!-- Formulaire de connexion -->
        <form method="post" action="connecter.php">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <button type="submit">Se connecter</button>
        </form>

        <!-- Lien vers la page d'inscription -->
        <p>Pas encore de compte ? <a href="creercompte.php">Créer un compte</a></p>
    </div>
</body>
</html>

