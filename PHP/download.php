<?php
require('../fpdf/fpdf.php');
include_once '../PHP/connexion.php';
include_once '../PHP/cv.php';

// Création d'une nouvelle connexion à la base de données
$database = new Connexion();
$conn = $database->getConnection();

// Création d'un nouvel objet CV en utilisant la connexion à la base de données
$cv = new CV($conn);

// Lire les détails du CV en fonction de l'ID de l'utilisateur
$cv->read();

// Création d'une nouvelle instance de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Ajout du titre
$pdf->Cell(0,10,'CV de ' . $cv->getName() . ' ' . $cv->getSurname(),0,1,'C');

// Ajout des sections du CV
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Coordonnées',0,1);
$pdf->Cell(0,10,'Nom: ' . $cv->getName(),0,1);
$pdf->Cell(0,10,'Prénom: ' . $cv->getSurname(),0,1);
$pdf->Cell(0,10,'Email: ' . $cv->getEmail(),0,1);
$pdf->Cell(0,10,'Téléphone: ' . $cv->getPhone(),0,1);

$pdf->Cell(0,10,'Formation',0,1);
$pdf->MultiCell(0,10,$cv->getFormation(),0,1);

$pdf->Cell(0,10,'Expérience',0,1);
$pdf->MultiCell(0,10,$cv->getExperience(),0,1);

$pdf->Cell(0,10,'Loisirs',0,1);
$pdf->MultiCell(0,10,$cv->getLoisirs(),0,1);

$pdf->Cell(0,10,'Langues',0,1);
$langues = explode(", ", $cv->getLangues());
if(count($langues) > 0) {
    foreach($langues as $langue) {
        $pdf->Cell(0,10,$langue,0,1);
    }
} else {
    $pdf->Cell(0,10,'Aucune langue sélectionnée',0,1);
}

$pdf->Cell(0,10,'Soft Skills',0,1);
$pdf->MultiCell(0,10,$cv->getSoftSkills(),0,1);

// Nom du fichier PDF à télécharger
$filename = 'cv_' . $cv->getName() . '_' . $cv->getSurname() . '.pdf';

// Envoi du PDF au navigateur pour téléchargement
$pdf->Output('D', $filename);
?>
