<?php
class CV {
    private $conn;
    private $table_name = "cv";

    public $id;
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $formation;
    public $experience;
    public $loisirs;
    public $langues;
    public $softSkills;
    public $cvImage;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getFormation() {
        return $this->formation;
    }

    public function setFormation($formation) {
        $this->formation = $formation;
    }

    public function getExperience() {
        return $this->experience;
    }

    public function setExperience($experience) {
        $this->experience = $experience;
    }

    public function getLoisirs() {
        return $this->loisirs;
    }

    public function setLoisirs($loisirs) {
        $this->loisirs = $loisirs;
    }

    public function getLangues() {
        return $this->langues;
    }

    public function setLangues($langues) {
        $this->langues = $langues;
    }

    public function getSoftSkills() {
        return $this->softSkills;
    }

    public function setSoftSkills($softSkills) {
        $this->softSkills = $softSkills;
    }

    public function getCvImage() {
        return $this->cvImage;
    }

    public function setCvImage($cvImage) {
        $this->cvImage = $cvImage;
    }


    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    name=:name,
                    surname=:surname,
                    email=:email,
                    phone=:phone,
                    formation=:formation,
                    experience=:experience,
                    loisirs=:loisirs,
                    langues=:langues,
                    softSkills=:softSkills,
                    cvImage=:cvImage";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->formation = htmlspecialchars(strip_tags($this->formation));
        $this->experience = htmlspecialchars(strip_tags($this->experience));
        $this->loisirs = htmlspecialchars(strip_tags($this->loisirs));
        $this->langues = htmlspecialchars(strip_tags($this->langues));
        $this->softSkills = htmlspecialchars(strip_tags($this->softSkills));
        $this->cvImage = htmlspecialchars(strip_tags($this->cvImage));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":surname", $this->surname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":formation", $this->formation);
        $stmt->bindParam(":experience", $this->experience);
        $stmt->bindParam(":loisirs", $this->loisirs);
        $stmt->bindParam(":langues", $this->langues);
        $stmt->bindParam(":softSkills", $this->softSkills);
        $stmt->bindParam(":cvImage", $this->cvImage);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        // Requête pour sélectionner le dernier CV créé
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT 1";

        // Préparer la requête
        $stmt = $this->conn->prepare($query);

        // Exécuter la requête
        $stmt->execute();

        // Vérifier s'il y a un CV trouvé
        if ($stmt->rowCount() > 0) {
            // Récupérer la ligne de résultat sous forme de tableau associatif
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assigner les valeurs aux propriétés de l'objet CV
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->formation = $row['formation'];
            $this->experience = $row['experience'];
            $this->loisirs = $row['loisirs'];
            $this->langues = $row['langues'];
            $this->softSkills = $row['softSkills'];
            $this->cvImage = $row['cvImage'];

            return true;
        }

        return false;
    }
}
?>
