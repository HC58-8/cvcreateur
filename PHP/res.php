<?php
include_once '../PHP/connexion.php';
include_once '../PHP/cv.php';

// Création d'une nouvelle connexion à la base de données
$database = new Connexion();
$conn = $database->getConnection();

// Création d'un nouvel objet CV en utilisant la connexion à la base de données
$cv = new CV($conn);

// Lire les détails du CV en fonction de l'ID de l'utilisateur
$cv->read();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du CV</title>
    <link rel="stylesheet" href="../CSS/cv.css"> <!-- Assurez-vous d'avoir le fichier cv.css -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="cv">
                    <h1>CV</h1>
                    <div class="cv-section">
                        <h2>Coordonnées</h2>
                        <p><strong>Nom:</strong> <?php echo $cv->getName(); ?></p>
                        <p><strong>Prénom:</strong> <?php echo $cv->getSurname(); ?></p>
                        <p><strong>Email:</strong> <?php echo $cv->getEmail(); ?></p>
                        <p><strong>Téléphone:</strong> <?php echo $cv->getPhone(); ?></p>
                    </div>
                    <div class="cv-section">
                        <h2>Formation</h2>
                        <p><?php echo $cv->getFormation(); ?></p>
                    </div>
                    <div class="cv-section">
                        <h2>Expérience</h2>
                        <p><?php echo $cv->getExperience(); ?></p>
                    </div>
                    <div class="cv-section">
                        <h2>Loisirs</h2>
                        <p><?php echo $cv->getLoisirs(); ?></p>
                    </div>
                    <div class="cv-section">
                        <h2>Langues</h2>
                        <?php
                        $langues = explode(", ", $cv->getLangues());
                        if(count($langues) > 0) {
                            echo "<ul>";
                            foreach($langues as $langue) {
                                echo "<li>$langue</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>Aucune langue sélectionnée</p>";
                        }
                        ?>
                    </div>
                    <div class="cv-section">
                        <h2>Soft Skills</h2>
                        <p><?php echo $cv->getSoftSkills(); ?></p>
                    </div>
                    <div class="cv-section">
                        <h2>Image du CV</h2>
                        <?php
                        if($cv->getCvImage()) {
                            echo '<img src="uploads/' . $cv->getCvImage() . '" alt="Image du CV">';
                        } else {
                            echo "Aucune image n'a été téléchargée.";
                        }
                        ?>
                    </div>
                    <div class="cv-section">
                        <!-- Bouton de téléchargement -->
                        <a href="../PHP/download.php" target="_blank">
                            <button>Télécharger le CV au format PDF</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
