<?php
// include("int.php");
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'kaoline_porcelaine';


try {
    //     //On établit la connexion
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", 'root', '');

    // On définit le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Connexion réussie';
}

/*On capture les exceptions si une exception est lancée et on affiche
                     *les informations relatives à celle-ci*/ catch (PDOException $e) {
    echo ("Erreur : " . $e->getMessage());
}
// print_r($_POST);

$Nom = $_POST["Nom"];
$Prenom = $_POST["Prenom"];
$Email = $_POST["Email"];
$Telephone = $_POST["Telephone"];
$Message = $_POST["Message"];


echo 'Nom : ' . $_POST["Nom"] . '<br>';
echo 'Prenom : ' . $_POST["Prenom"] . '<br>';
echo 'Email : ' . $_POST["Email"] . '<br>';
echo 'Telephone : ' . $_POST["Telephone"] . '<br>';
echo 'Message : ' . $_POST["Message"] . '<br>';


// $Nom = valid_donnees($_POST["Nom"]);
// $Prenom = valid_donnees($_POST["Prenom"]);
// $Email = valid_donnees($_POST["Email"]);
// $Telephone = valid_donnees($_POST["Telephone"]);
// $Message = valid_donnees($_POST["Message"]);

// function valid_donnees($donnees)
// {
//     $donnees = trim($donnees);
//     $donnees = stripslashes($donnees);
//     $donnees = htmlspecialchars($donnees);
//     return $donnees;
// }

// /*Si les champs prenom et mail ne sont pas vides et si les donnees ont
//        *bien la forme attendue...*/
// // if (
// !empty($Prenom)
//     && strlen($Prenom) <= 20
//     && preg_match("/^[A-Za-z '-]+$/", $Prenom)
//     && !empty($Email)
//     && filter_var($Email, FILTER_VALIDATE_EMAIL);

try {

    //On se connecte à la BDD
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //On insère les données reçues

    $sth = $dbco->prepare("INSERT INTO Contact02 (Nom,  Prenom, Email, Telephone, Message)
                  VALUES(:Nom, :Prenom, :Email, :Telephone, :Message)");
    $sth->bindParam(':Nom', $Nom);
    $sth->bindParam(':Prenom', $Prenom);
    $sth->bindParam(':Email', $Email);
    $sth->bindParam(':Telephone', $Telephone);
    $sth->bindParam(':Message', $Message);

    //   echo ""

    $sth->execute();
    //On renvoie l'utilisateur vers la page de remerciement
    //header("Location: Contact.html.twig");
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
