<?php

use phpDocumentor\Reflection\Types\Null_;

function getPdo() : PDO
{
 /** 
 * $options = tableau MODE exceptions et Attribus FETCH MODE par default a ASSOC
 */
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
try {
   $pdo = new PDO('mysql:host=localhost;dbname=coaching_annonce;charset=utf8','root','', $options);
     }
 catch (PDOException $e) {
         echo 'Connection failed: ' . $e->getMessage();
     }

    return $pdo;
}

function createAnnonce($titre, $descriptif, $prestations, $tarifs, $photo, $email)

{
    $pdo = getPdo();
    $query = $pdo->prepare('INSERT INTO annonces (titre, descriptif, prestations, tarifs, photo, date, email, pdf,statut) VALUES (:titre, :descriptif, :prestations, :tarifs, :photo :now(), :email, :pdf, :statut)');
    // $query = $pdo->prepare('INSERT INTO annonces (titre, descriptif, prestations, tarifs, email, photo) VALUES (?, ?, ?, ?, ?, ?)');
  
    
    $query->bindValue(':titre',$titre, PDO::PARAM_STR);
    $query->bindValue(':description',$descriptif, PDO::PARAM_STR);
    $query->bindValue(':prestations',$prestations, PDO::PARAM_STR);
    $query->bindValue(':tarifs',$tarifs, PDO::PARAM_INT);
    $query->bindValue(':photo',$photo, PDO::PARAM_STR);
    $query->bindValue(':email',$email, PDO::PARAM_STR);
    // $query->bindValue(':pdf',$pdf, PDO::PARAM_STR);
    if (!$query->execute());
//   if (!$query->execute([$titre, $descriptif, $prestations, $tarifs, $email, $photo]));
   // if (!$query->execute([$nom,$nationalite,$age,$poste,$email,$photo]));

  
  {return false;}
}

function readAnnonce() : array
{
    $pdo = getPdo();
    $query = $pdo->query('SELECT * FROM annonces');
    $users = $query->fetchAll();
    return $users;     
}

function readLastAnnonce() 
{
    $pdo = getPdo();
    $query = $pdo->query('SELECT * FROM annonces');
    $test = $query->fetchAll();
    $endannonce = end($test);
    var_dump($endannonce);
    echo "<br> début du dernnier enregistrement <br>";
  foreach ($endannonce as $value) {
         echo "<br>Enregistrement->".$value."<br>";
         if (file_exists($value)) {
              echo "<img src=".$value." width=150 height=200><br>"; 
           
         } else  {  echo "----------------";} 
  }
     echo "<br>Fin du dernier enregistrement <br><br><br><a href='index.php'>retour</a>";
}

// Mise a jour de test en fonction de l'ID
function updateAnnonce (string $titre, string $descriptif,string $prestations,int $tarifs,string $photo, string $email, int $id_annonce) :bool
{
    $pdo = getPdo();
    $query = 'UPDATE annonces SET titre =?, descriptif =?, prestations =?, tarifs =?, photo =?, date =?, email =?, pdf = null, statut = null WHERE id_annonce =?';
    $stmt = $pdo->prepare($query);
    $now = now();
    if (!$stmt->execute([$titre, $descriptif, $prestations, $tarifs, $photo, $now, $email, $id_annonce]));
    return false;
}

function deleteUser(int $id_annnonce)
{
    $pdo = getPdo();
    $query = 'DELETE FROM annonces WHERE id_annonce =?';
    $stmt= $pdo->prepare($query);
    if (!$stmt->execute([$id_annonce]));
    header('Location: index.php?message=<h1>test id_annonce: '. $id_annonce . ' bien supprimé</h1>');
    exit();    
}
