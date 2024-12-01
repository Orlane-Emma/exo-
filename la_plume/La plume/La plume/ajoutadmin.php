<?php
            include('db.php');    

            
            if ($conn) {
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    // Variables des informations envoyées via le formulaire
                    $adminprenom = $_POST["adminprenom"];
                    $adminnom = $_POST["adminnom"];
                    $adminemail = $_POST["adminemail"];
                    $adminpassword = password_hash($_POST["adminpassword"], PASSWORD_ARGON2I);

                    $sql = "SELECT * FROM administrateurs WHERE email = '$adminemail'";
                    $result= mysqli_query($conn, $sql);  // Préparation de la requête

                    if (mysqli_num_rows($result) > 0) {
                        echo"<h1 style='color:red;'>Cet email est déjà utilisé. Veuillez choisir un autre.</h1><br><br><br>";
                    } else {
                        // Requête SQL
                        $requete = "INSERT INTO administrateurs (nom, prenom, email, mdp, role) 
                                    VALUES ('$adminprenom', '$adminnom', '$adminemail', '$adminpassword', 'admin')";
                        $resultat = mysqli_query($conn, $requete);
                        if ($resultat) {
                            header("Location: superadmin.php"); // Rediriger vers la même page
                            exit();
                        } else {
                            echo "<h1 style='color:red;'>Erreur lors de l'insertion</h1><br><br><br>";
                        }
                    }
                    
                }
                
                mysqli_close($conn);
            }

?>
<button onclick="window.location.href='superadmin.php'">RETOUR</button>
