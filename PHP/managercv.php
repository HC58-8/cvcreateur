<?php
// Include la connexion à la base de données
include_once '../PHP/connexion.php';
include_once '../PHP/user.php';

// Include la classe CV
include_once '../PHP/cv.php';

// Vérifie si les données du formulaire de connexion ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitConnexion'])) {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Créer une nouvelle connexion à la base de données
    $database = new Connexion();
    $conn = $database->getConnection();

    // Créer un nouvel objet User pour gérer la connexion
    $user = new User($conn);

    // Vérifier les informations de connexion
    if ($user->connexion($email, $mot_de_passe)) {
        echo "Connexion réussie.";
        header("Location: ../HTML/cv.html");
        exit();
        
        // Rediriger ou afficher une page de succès de connexion
    } else {
        echo "Identifiants incorrects.";
        // Rediriger ou afficher un message d'erreur
    }
}

// Vérifie si les données du formulaire d'inscription ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitInscription'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Créer une nouvelle connexion à la base de données
    $database = new Connexion();
    $conn = $database->getConnection();

    // Créer un nouvel objet User pour gérer l'inscription

    $user = new User($conn);

    // Set les propriétés de l'utilisateur avec les données du formulaire
    $user->setNom($nom);
    $user->setEmail($email);
    $user->setMotDePasse($mot_de_passe);

    // Vérifier si l'utilisateur existe déjà
    if ($user->userExists()) {
        echo "Cet utilisateur existe déjà.";
        // Rediriger ou afficher un message d'erreur
    } else {
        // Créer l'utilisateur s'il n'existe pas déjà
        if ($user->create()) {
            header("Location: ../HTML/userconnection.html");
            exit();
            // Rediriger ou afficher une page de succès d'inscription
        } else {
            echo "Erreur lors de l'inscription.";
            // Rediriger ou afficher un message d'erreur
        }
    }
}

// Traitement de la création du CV
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitCV'])) {
    // Création d'un nouvel objet connexion pour obtenir la connexion PDO
    $database = new Connexion();
    $conn = $database->getConnection();

    // Création d'un nouvel objet CV en utilisant la connexion à la base de données
    $cv = new CV($conn);

    // Set les propriétés du CV avec les données du formulaire
    $cv->setName($_POST['name']);
    $cv->setSurname($_POST['surname']);
    $cv->setEmail($_POST['email']);
    $cv->setPhone($_POST['phone']);
    $cv->setFormation($_POST['formation']);
    $cv->setExperience($_POST['experience']);
    $cv->setLoisirs($_POST['loisirs']);
     
    // Traitement des langues
    if(isset($_POST['langues']) && is_array($_POST['langues'])) {
        $langues = implode(", ", $_POST['langues']);
        $cv->setLangues($langues);
    }

    $cv->setSoftSkills($_POST['softSkills']);

    // Gestion de l'upload de l'image du CV
    if(isset($_FILES['cvImage']) && $_FILES['cvImage']['error'] === UPLOAD_ERR_OK) {
        $cvImage = $_FILES['cvImage']['name'];
        move_uploaded_file($_FILES['cvImage']['tmp_name'], 'uploads/' . $cvImage);
        $cv->setCvImage($cvImage);
    }

    // Insertion du CV dans la base de données
    if($cv->create()) {
        header("Location: ../PHP/res.php");
        exit();
    } else {
        echo "Erreur lors de la création du CV.";
    }
}
?>
