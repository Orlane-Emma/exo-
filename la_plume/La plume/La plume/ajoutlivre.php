<?php
        include('db.php');  

        
        if ($conn) {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Variables des informations envoyées via le formulaire
                $titre = $_POST["titre"];
                $category = $_POST["category"];
                $subcategory = $_POST["subcategory"];
                $isbn = $_POST["isbn"];
                $auteur = $_POST["auteur"];
                $editeur = $_POST["editeur"];
                $prix = $_POST["prix"];
                $stock = $_POST["stock"];
                $description = $_POST["description"];
                
                // Vérifier si un fichier image est téléchargé
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image = file_get_contents($_FILES['image']['tmp_name']); // Lire le fichier image
                    $images = mysqli_real_escape_string($conn, $image);    
                }
                $descriptions = mysqli_real_escape_string($conn, $description);
                $titres = mysqli_real_escape_string($conn, $titre);

                // Requête SQL
                $requete = "INSERT INTO livres (titre, categorie, sous_categorie, image, isbn, auteur, editeur, prix, stock, description) 
                            VALUES ('$titres', '$category', '$subcategory', '$images', '$isbn', '$auteur', '$editeur', '$prix', '$stock', '$descriptions')";
                $resultat = mysqli_query($conn, $requete);
                if ($resultat) {
                    header("Location: admin.php"); // Rediriger vers la même page
                    exit();
                } else {
                    echo "<h1 style='color:red;'>Erreur lors de l'insertion</h1><br>";
                }
                
            }

            
            mysqli_close($conn);
        }

?>
