<?php
session_start();
include 'db.php'; // Connexion à la base de données

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérification de l'utilisateur dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $utilisateur = $result->fetch_assoc();

    // Si l'utilisateur existe et que le mot de passe est correct
    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        $_SESSION['utilisateur_id'] = $utilisateur['id'];
        $_SESSION['role'] = $utilisateur['role'];

        // Redirection vers la page d'accueil après la connexion
        header("Location: accueil.php");
        exit();
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
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        
        <!-- Affichage de l'erreur si elle existe -->
        <?php if (isset($erreur)) echo "<p class='error-message'>$erreur</p>"; ?>
        
        <!-- Formulaire de connexion -->
        <form method="post" action="connexion.php">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <button type="submit">Se connecter</button>
        </form>

        <!-- Lien vers la page d'inscription -->
        <p>Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
    </div>
</body>
</html>
