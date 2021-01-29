<?php
session_start();
require_once('connexiondb.php');
$utilisateur_id= (int) $_SESSION['id'];

echo $utilisateur_id;
if(empty($utilisateur_id)){
    header('location: membres.php');
    exit;
}

$id = strip_tags($_GET['id']);
$req="SELECT * FROM utilisateur WHERE id = :id";

$query = $BDD->prepare($req);
$query->bindValue(':id',$id, PDO::PARAM_INT);
$query->execute();
$utilisateur= $query->fetch();
$annonces='';
$req= 'UPDATE utilisateur SET annonces=:annonces WHERE id=:id;';
$query=$BDD->prepare($req);
$query->bindValue(':annonces',$annonces, PDO::PARAM_STR);
$query->bindValue(':id',$id, PDO::PARAM_INT);
$query->execute();
header('location: membres.php');