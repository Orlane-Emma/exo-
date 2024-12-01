<?php
session_start();
include 'db.php'; // Connexion à la base de données

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Hachage du mot de passe avant de l'insérer dans la base de données
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Vérification si l'email existe déjà dans la base de données
    $sql = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si l'email existe déjà
    if ($result->num_rows > 0) {
        $erreur = "Cet email est déjà utilisé. Veuillez choisir un autre.";
    } else {
        // Insertion des nouvelles informations dans la base de données
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nom, $prenom, $email, $mot_de_passe_hash);

        // Exécution de l'insertion
        if ($stmt->execute()) {
            // Redirection vers la page de connexion après une inscription réussie
            header("Location: connexion.php");
            exit();
        } else {
            // Si une erreur survient lors de l'insertion
            $erreur = "Erreur lors de la création du compte. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - La Plume</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>
        
        <!-- Affichage de l'erreur si elle existe -->
        <?php if (isset($erreur)) echo "<p class='error-message'>$erreur</p>"; ?>
        
        <!-- Formulaire d'inscription -->
        <form method="post" action="inscription.php">
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>
            
            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" id="prenom" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            
            <button type="submit">S'inscrire</button>
        </form>
        
        <p>Déjà inscrit ? <a href="connexion.php">Se connecter</a></p> <!-- Lien vers la page de connexion -->
    </div>
</body>
</html>
