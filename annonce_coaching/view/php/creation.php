<?php
require_once('database.php');

// if (is_uploaded_file($_FILES['photo']['tmp_name'])) {
//     echo "File ". $_FILES['photo']['name'] ." uploaded successfully.\n";
//     echo "Displaying contents\n";
//     // readfile($_FILES['photo']['tmp_name']);
//  } else {
//     echo "Possible file upload attack: ";
//     echo "filename '". $_FILES['photo']['tmp_name'] . "'.";
//  }
$uploaddir = "photo/../";
$filename = $uploaddir . basename($_FILES['photo']['name']);
move_uploaded_file($_FILES['photo']['tmp_name'], $filename);
echo "<br>".$uploaddir." <br>".$filename;

$titre = $_POST['titre'];
$descriptif = $_POST['description'];
$prestations = $_POST['prestations'];
$tarifs = $_POST['tarifs'];
$email = $_POST['email'];
$photo = $filename;

// $pdo = getPdo();
createAnnonce($titre, $descriptif, $prestations, $tarifs, $photo, $email);
header("Location:../html/validation.html");
// $lastUser = readLastUser();
// print_r($lastUser);