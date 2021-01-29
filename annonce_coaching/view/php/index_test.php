<?php
// $serv=$_SERVER;
// echo'<pre>';
// var_dump($serv);
// echo'</pre>';

//lien à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=coaching_annonce", 'root', '');
} catch (PDOException $e) {
    die('Erreur: ' . $e->getMessage());
}



//condition du post et files
if (!empty($_POST) && !empty($_FILES)) {


    // constante : Taille max en octets du fichie
    define('MAX_SIZE', 500000);


    // *********************************** FILE IMAGE ***********************************************************


    //recu le nom du fichier
    $file_name = $_FILES['photo']['name'];
    //recup le type du fichier
    $file_extension = strrchr($file_name, ".");


    //image temporaire
    $file_tmp_name = $_FILES['photo']['tmp_name'];

    //chemin du dossier
    $file_dest = 'img/' . $file_name;


    //tableau des extension autorisé lors de l'upload
    $extension_autorisee = array('.jpeg', '.jpg', '.png', '.gif', '.webp');

    // **************************************************************************************************** 
    // $id_annonce=strip_tags(trim($_POST['id_annonce']));
    $titre = strip_tags(trim($_POST['titre']));
    $description = strip_tags(trim($_POST['description']));
    $prestations = strip_tags(trim($_POST['prestations']));
    $tarifs = strip_tags(trim($_POST['tarifs']));
    $email = strip_tags(trim($_POST['email']));




    // $mdp=sha1(trim($_POST['mdp']));

    // /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/

    if (preg_match("/^[a-zA-Z-']*$/", $titre)) {
        if (preg_match("/^[a-zA-Z-']*$/", $description)) {
            if (preg_match("/^[0-9.-]*$/", $prestations)) {
                // if (preg_match("/^[a-zA-Z-']*$/", $poste)) {
                    if (preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $email)) {


                        // *********************** import img *********************

                        // est-ce que fait parti du tableau ci dessus
                        if (in_array($file_extension, $extension_autorisee)) {
                            // pour un autre if pour la taille ou dimension
                            if ((filesize($_FILES['photo']['tmp_name']) <= MAX_SIZE)) {

                                //pour déplacer du temp vers la destination
                                if (move_uploaded_file($file_tmp_name, $file_dest)) {

                                    echo 'Fichier envoyé avec succés';
                                } else {
                                    echo "Une erreur est survenue lors de l'envoi du fichier";
                                }
                            } else {
                                echo 'Erreur dans le poids !';
                            }
                        } else {
                            echo 'seuls les images avec les extensions jpeg, jpg, png, gif, webp sont autorisées';
                        }
                        // ******************************* FIN IMPORT IMG **********************************************


                        //après verification du nom prenom mail on execute la requete
                        $request = $pdo->prepare("INSERT INTO annonces (titre,description,prestations,tarifs,email,photo) VALUES (?,?,?,?,?,?)");
                        $request->execute([$titre, $description,$prestations, $tarifs, $email, $file_dest]);
                        //On renvoie l'utilisateur vers la page de remerciement
                        header("Location:../html/validation.html");

                        echo ' et User enregistré';
                    } else {
                        echo "l'email n'est pas valide";
                    }
                // } else {
                //     echo "le poste n'est pas valide";
                // }
            } else {
                echo "le tarif n'a pas été renseigné";
            }
        } else {
            echo "La prestation n'a pas été renseigné";
        }
    } else {
        echo 'Le titre ne doit contenir que des lettres majuscule ou minuscule';
    }
}


?>

<!-- <form action="index.php" method="POST" enctype="multipart/form-data"><br>
    <label>Prénom</label><br>
    <input type="text" name="nom"><br>
    <label>Nom</label><br>
    <input type="text" name="prenom"><br>
    <label>E-mail</label><br>
    <input type="text" name="email"><br>
    <label>Mot de passe</label><br>
    <input type="password" name="mdp"><br> -->
<!-- pour l'image -->
<!-- <input name="photo" type="file" /> -->
<!-- <input type="file" name="avatar"> <br>-->
<!-- <input type="submit" value="enregistrer" name="subm">
</form> -->