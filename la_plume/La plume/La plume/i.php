<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de livres</title>
    <style>
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
        
        .search-input {
            width: 300px;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 25px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #007BFF;
        }


    </style>
</head>
<body>

    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un livre..." onkeyup="searchBooks()">
    </div>

    <div class="books-list" id="booksList">
        <?php
        include('db.php'); // Connexion à la base de données

        if ($conn) {
            $requete = "SELECT id_livre, image, titre, prix, stock, categorie, sous_categorie, description, auteur FROM livres";
            $resultat = mysqli_query($conn, $requete);

            while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                echo "<div class='book-item' 
                data-title='" . strtolower($ligne['titre']) . "' 
                data-author='" . strtolower($ligne['auteur']) . "'
                data-category='" . strtolower($ligne['categorie']) . "'>";
                
                // Vérifier si l'image existe et la convertir en base64
                if ($ligne['image']) {
                    // Convertir l'image BLOB en base64
                    $finfo = new finfo(FILEINFO_MIME_TYPE); 
                    $mimeType = $finfo->buffer($ligne['image']); // Obtenir le type MIME de l'image
                    // Ajouter le préfixe pour que ce soit reconnu comme une image
                    echo "<img src='data:$mimeType;base64,".base64_encode($ligne['image'])."' alt='Livre' class='book-image'>";
                } else {
                    echo "<img src='default-image.jpg' alt='Livre' class='book-image'>"; // Image par défaut si l'image n'existe pas
                }
                
                echo "<div class='book-info'>";
                echo "<h3>" . $ligne['titre'] . "</h3>";
                echo "<p>" . $ligne['categorie'] . " > " . $ligne['sous_categorie'] . "</p>";
                echo "<p>Auteur : " . $ligne['auteur'] . "</p>";
                echo "<p>Prix : " . $ligne['prix'] . " €</p>";
                echo "<p>Stock : " . $ligne['stock'] . "</p>";
                echo "<p>Description : " . $ligne['description'] . "</p>";
                echo "</div>";
                echo "<div class='book-actions'>";
                echo "<button onclick='editBook(".$ligne['id_livre'].")' style='background-color: #007bff;'>Modifier</button>";
                echo "<a href='?delete=" . $ligne['id_livre'] . "' style='color: white; background-color: #dc3545; padding: 5px 10px; text-decoration: none; border-radius: 5px;'>Supprimer</a>";
                echo "</div>";
                echo "</div>";
            }
            // Gestion de la suppression
            if (isset($_GET['delete'])) {
                $id_livre = intval($_GET['delete']); // Sécuriser l'ID récupéré
                $requete = "DELETE FROM livres WHERE id_livre = $id_livre";

                try {
                    $resultat = mysqli_query($conn, $requete);
                    if (!$resultat) {
                        echo "<h3 style='color: red;'>Erreur lors de la suppression.</h3>";
                    }
                } catch (Exception $e) {
                    echo "<h3 style='color: red;'>Erreur : " .$e. "</h3>";
                }
            }

            mysqli_close($conn);
        }
        ?>
    </div>

    <script>
        function searchBooks() {
            // Récupérer la valeur de la recherche
            var query = document.getElementById("searchInput").value.toLowerCase();
            
            // Récupérer tous les livres de la page
            var books = document.querySelectorAll('.book-item');
            
            books.forEach(function(book) {
                var title = book.getAttribute('data-title');
                var author = book.getAttribute('data-author');
                var category = book.getAttribute('data-category');

                // Vérifier si le titre, auteur ou catégorie contient la recherche
                if (title.includes(query) || author.includes(query) || category.includes(query)) {
                    book.style.display = "block"; // Afficher le livre
                } else {
                    book.style.display = "none"; // Cacher le livre
                }
            });
        }
    </script>

</body>
</html>
