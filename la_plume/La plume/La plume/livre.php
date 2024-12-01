<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livres</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        .search-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .search-input {
            width: 300px;
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #007bff;
            border-radius: 25px;
            outline: none;
        }

        .books-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }

        .book-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            text-align: center;
            padding: 15px;
        }

        .book-image {
            width: auto;
            height: 300px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .book-info h2, .book-info h3 {
            margin: 10px 0;
        }

        .book-info p, .book-info strong {
            margin: 5px 0;
            color: black;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bouton {
            width: 170px;
            display: block;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .bouton a {
            width: 100%;
            font-size: 18px;
            display: block;
            color: #ffffff;
            background-color: #df9911;
            padding: 7px 0px;
            border-radius: 40px;
            text-align: center;
            text-decoration: none;
        }

        .bouton a:hover {
            color: #ffffff;
            background-color: #141414;
        }
    </style>
</head>
<body>

<?php
include('header.html');
include('db.php');

$categorie = $_GET['categorie'];
$sous_categorie = $_GET['sous_categorie'];
?>

    <!-- Barre de recherche -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un livre..." onkeyup="searchBooks()">
    </div>

<?php
if ($conn) {
    $categories = mysqli_real_escape_string($conn, $categorie);
    $sous_categories = mysqli_real_escape_string($conn, $sous_categorie);

    $requete = "SELECT image, titre, prix, categorie, sous_categorie, description, auteur FROM livres WHERE categorie='$categories' AND sous_categorie='$sous_categories'";
    $resultat = mysqli_query($conn, $requete);

    echo "<div class='books-list'>";
    if (mysqli_num_rows($resultat) > 0) {
        while ($ligne = mysqli_fetch_array($resultat)) {
            echo "<div class='book-item' data-title='" . strtolower($ligne['titre']) . "' data-author='" . strtolower($ligne['auteur']) . "'>";
            
            if ($ligne['image']) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($ligne['image']);
                echo "<img src='data:$mimeType;base64," .base64_encode($ligne['image']). "' alt='Livre' class='book-image'>";
            } else {
                echo "erreur"; 
            }
            echo "<div class='book-info'>";
            echo "<h2><strong>" .($ligne['titre']). "</strong></h2>";
            echo "<strong>" .($ligne['auteur']). "</strong>";
            echo "<p>" .($ligne['description']). "</p>";
            echo "<h3>" .($ligne['prix']). " €</h3>";
            echo  "<div class='center'><div class='bouton'><a href='#'>En savoir plus</a></div></div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p style='color:black'>Aucun livre trouvé pour $sous_categories dans $categories.</p>";
    }
    echo "</div>";


    mysqli_close($conn);

}

include('footer.html');
?>

<script>
    function searchBooks() {
        var query = document.getElementById("searchInput").value.toLowerCase().trim();
        var books = document.querySelectorAll('.book-item');

        books.forEach(function(book) {
            var title = book.getAttribute('data-title') || "";
            var author = book.getAttribute('data-author') || "";

            if (title.includes(query) || author.includes(query)) {
                book.style.display = "block"; 
            } else {
                book.style.display = "none"; 
            }
        });
    }
</script>

</body>
</html>
