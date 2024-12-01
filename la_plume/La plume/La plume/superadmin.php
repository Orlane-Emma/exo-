<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super-Administration - Librairie en ligne</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background-color: #005477;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .tab {
            padding: 10px 20px;
            background-color: #bdbdbd;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .tab.active {
            background-color: #007bff;
            color: white;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        form {
            display: grid;
            gap: 20px;
            max-width: 800px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        select:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .books-list, .admin-list {
            display: grid;
            gap: 20px;
            margin-top: 20px;
        }

        .book-item, .admin-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            align-items: center;
        }
        

        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
        
        .search-input {
            width: 300px;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 25px;
            outline: none;
        }


        .book-image {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 4px;
        }

        .book-info, .admin-info {
            display: grid;
            gap: 8px;
        }

        .book-actions, .admin-actions {
            display: flex;
            gap: 10px;
        }

        .preview-image {
            max-width: 200px;
            max-height: 280px;
            margin-top: 10px;
        }

        .admin-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
 
         .admin-info {
            flex: 1; 
            margin-right: 20px; 
        }
         .admin-actions {
            display: flex;
            gap: 10px; 
        }

    </style>
</head>
<body>
    
    <div class="container">
        <header class="header">
            <h1>Super-Administration - Librairie en ligne</h1>
            <button onclick="window.location.href='index.html'">Déconnexion</button>
        </header>

        <div class="tabs" class="container">
            <button class="tab active" onclick="switchTab('add')">Ajouter un livre</button>
            <button class="tab" onclick="switchTab('manage')">Gérer les livres</button>
            <button class="tab" onclick="switchTab('addadmin')">Gestion des administrateurs</button>
        </div>

        <section id="add" class="section active">
            <h2>Ajouter un nouveau livre</h2>
            <form id="addBookForm" action="ajout.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" required>
                </div>

                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select id="category" name="category" required onchange="updateSubCategories()">
                        <option value="">Sélectionnez une catégorie</option>
                        <option value="thriller">Thriller</option>
                        <option value="romance">Romance</option>
                        <option value="romanpolicier">Roman policier</option>
                        <option value="comedie">Comédie</option>
                        <option value="sciencefiction">Science-fiction</option>
                        <option value="poesie">Poésie</option>
                        <option value="recit">Récit</option>
                        <option value="manga">Manga</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subcategory">Sous-catégorie</label>
                    <select id="subcategory" name="subcategory" required disabled>
                        <option value="">Sélectionnez d'abord une catégorie</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" required>
                </div>

                <div class="form-group">
                    <label for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" required>
                </div>

                <div class="form-group">
                    <label for="editeur">Éditeur</label>
                    <input type="text" id="editeur" name="editeur" required>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (€)</label>
                    <input type="number" id="prix" name="prix" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" required>
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" onchange="previewImage(event)" required>
                    <img id="imagePreview" class="preview-image"  alt="Aperçu de l'image">
                </div>

                <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" required></textarea>
                </div>

                <button type="submit">Ajouter le livre</button>
            </form>
        </section>

        <section id="manage" class="section">
            <h2>Gérer les livres existants</h2>
            <div class="search-container">
                <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un livre..." onkeyup="searchBooks()">
            </div>
            <div class="books-list">
            <?php
                include('db.php'); 

                if ($conn) {
                    if (isset($_POST['delete']) && isset($_POST['id_livre'])) {
                        $id_livre = intval($_POST['id_livre']); 
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
                    $requete = "SELECT id_livre, image, titre, prix, stock, categorie, sous_categorie, description, auteur FROM livres";
                    $resultat = mysqli_query($conn, $requete);

                    while ($ligne = mysqli_fetch_array($resultat)) {
                        echo "<div class='book-item' data-title='" . strtolower($ligne['titre']) . "' data-author='" . strtolower($ligne['auteur']) . "' data-category='" . strtolower($ligne['categorie']) . "'>";
                        if ($ligne['image']) {
                            $finfo = new finfo(FILEINFO_MIME_TYPE); 
                            $mimeType = $finfo->buffer($ligne['image']);
                            echo "<img src='data:$mimeType;base64,".base64_encode($ligne['image'])."' alt='Livre' class='book-image'>";
                        } else {
                            echo "erreur";
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
                        echo "<form method='POST' style='display:inline;'>"; 
                        echo "<input type='hidden' name='id_livre' value='".$ligne['id_livre']."'>";
                        echo "<button type='submit' name='edit' style='color: white; background-color: #007bff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Modifier</button>";
                        echo "</form>";
                        echo "<form method='POST' style='display:inline;'>"; 
                        echo "<input type='hidden' name='id_livre' value='".$ligne['id_livre']."'>";
                        echo "<button type='submit' name='delete' style='color: white; background-color: #dc3545; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Supprimer</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    mysqli_close($conn);
                }
            ?>
            </div>
        </section>
        
        <section id="addadmin" class="section">
            <h2>Gestion des administrateurs</h2>
            <form id="addAdminForm" action="ajoutadmin.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="adminprenom">Prénom</label>
                    <input type="text" id="adminprenom" name="adminprenom" required>
                </div>

                <div class="form-group">
                    <label for="adminnom">Nom</label>
                    <input type="text" id="adminnom" name="adminnom" required>
                </div>

                <div class="form-group">
                    <label for="adminemail">Email</label>
                    <input type="email" id="adminemail" name="adminemail" required>
                </div>

                <div class="form-group">
                    <label for="adminpassword">Mot de passe</label>
                    <input type="password" id="adminpassword" name="adminpassword" required>
                </div>

                <button type="submit">Ajouter l'administrateur</button>
            </form><br>

            <h2 class="mt-4">Liste des administrateurs</h2>
            <div class="admin-list" id="adminsList">
            <?php
                include('db.php'); 

                if ($conn) {
                    if (isset($_POST['delete']) && isset($_POST['id_administrateur'])) {
                        $id_administrateur = intval($_POST['id_administrateur']); 
                        $requete = "DELETE FROM administrateurs WHERE id_administrateur = $id_administrateur";
                
                        try {
                            $resultat = mysqli_query($conn, $requete);
                            if (!$resultat) {
                                echo "<h3 style='color: red;'>Erreur lors de la suppression.</h3>";
                            }
                        } catch (Exception $e) {
                            echo "<h3 style='color: red;'>Erreur : ".$e."</h3>";
                        }
                    }
                    $requete = "SELECT id_administrateur,prenom,nom,email FROM administrateurs WHERE role='admin'";
                    $resultat = mysqli_query($conn, $requete);

                    while ($ligne = mysqli_fetch_array($resultat)) {
                        echo "<div class='admin-item'>";
                        echo "<div class='admin-info'>";
                        echo "<h3>".$ligne['nom']." " .$ligne['prenom']."</h3>";
                        echo "<p>".$ligne['email']."</p>";
                        echo "</div>";
                        echo "<div class='admin-actions'>";
                        echo "<form method='POST' style='display:inline;'>"; 
                        echo "<input type='hidden' name='id_administrateur' value='".$ligne['id_administrateur']."'>";
                        echo "<button type='submit' name='edit' style='color: white; background-color: #007bff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Modifier</button>";
                        echo "</form>";
                        echo "<form method='POST' style='display:inline;'>"; 
                        echo "<input type='hidden' name='id_administrateur' value='".$ligne['id_administrateur']."'>";
                        echo "<button type='submit' name='delete' style='color: white; background-color: #dc3545; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Supprimer</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                    mysqli_close($conn);
                }
            ?>                
            </div>
        </section>
    </div>

    <script>
        // Existing code from previous implementation (subCategories, updateSubCategories, etc.)
        const subCategories = {
            thriller: [
                "Thriller psychologique",
                "Thriller policier",
                "Thriller juridique",
                "Thriller d'espionnage"
            ],
            romance: [
                "Romance contemporaine",
                "Romance fantastique/paranormale",
                "Romance romantique",
                "Comédie dramatique"
            ],
            romanpolicier: [
                "Roman noir",
                "Roman à énigme",
                "Polar",
                "True crime (documentaire)"
            ],
            comedie: [
                "Comédie littéraire",
                "Comédie romantique",
                "Comédie noire",
                "Comédie dramatique"
            ],
            sciencefiction: [
                "Science-fiction dystopique",
                "Space Opera",
                "Cyberpunk",
                "Science-fiction apocalyptique/post-apocalyptique"
            ],
            poesie: [
                "Poésie lyrique",
                "Poésie épique",
                "Poésie engagée",
                "Poésie satirique"
            ],
            recit: [
                "Autobiographie",
                "Biographie",
                "Mémoires",
                "Journal intime"
            ],
            manga: [
                "Shōnen",
                "Shōjo",
                "Seinen",
                "Isekai"
            ]
        };
        
    
        function updateSubCategories() {
            const categorySelect = document.getElementById('category');
            const subCategorySelect = document.getElementById('subcategory');
            const selectedCategory = categorySelect.value;

            subCategorySelect.innerHTML = '<option value="">Sélectionnez une sous-catégorie</option>';
            
            if (selectedCategory) {
                subCategorySelect.disabled = false;
                subCategories[selectedCategory].forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.toLowerCase().replace(/\s+/g, '-');
                    option.textContent = sub;
                    subCategorySelect.appendChild(option);
                });
            } else {
                subCategorySelect.disabled = true;
            }
        }

        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            
            document.querySelector(`button[onclick="switchTab('${tabId}')"]`).classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }

        function handleAddBook(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            console.log('Données du formulaire à envoyer:', Object.fromEntries(formData));
            alert('Fonctionnalité à implémenter avec votre backend');
        }

        function searchBooks() {
            var query = document.getElementById("searchInput").value.toLowerCase();
            var books = document.querySelectorAll('.book-item'); 
                
                books.forEach(function(book) {
                var title = book.getAttribute('data-title');
                var author = book.getAttribute('data-author');
                var category = book.getAttribute('data-category');

                
                if (title.includes(query) || author.includes(query) || category.includes(query)) {
                    book.style.visibility = "visible";
                    booksList.prepend(book); 
                } else {
                    book.style.visibility = "hidden"; 
                }
            });
        }
        

                
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('category').addEventListener('change', updateSubCategories);
        });
    </script>
</body>
</html>