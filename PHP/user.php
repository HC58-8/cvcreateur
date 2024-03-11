<?php
class User {
    // Connexion à la base de données et nom de la table
    private $conn;
    private $table_name = "utilisateurs";

    // Propriétés de l'utilisateur
    public $id;
    public $nom;
    public $email;
    public $mot_de_passe;

    // Constructeur avec $db pour la connexion à la base de données
    public function __construct($db){
        $this->conn = $db;
    }

    // Créer un nouvel utilisateur
    function create() {
        // Requête d'insertion
        $query = "INSERT INTO " . $this->table_name . " (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
    
        // Préparation de la requête
        $stmt = $this->conn->prepare($query);
    
        // Nettoyer les données
        $this->nom=htmlspecialchars(strip_tags($this->nom));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->mot_de_passe=htmlspecialchars(strip_tags($this->mot_de_passe));
    
        // Bind des valeurs
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mot_de_passe", $this->mot_de_passe);
    
        // Exécution de la requête
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // Vérifie si l'email de l'utilisateur existe déjà dans la base de données
    function emailExists() {
        // Requête pour vérifier l'existence de l'email
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind des valeurs
        $stmt->bindParam(":email", $this->email);

        // Exécution de la requête
        $stmt->execute();

        // Compter le nombre de lignes
        $num = $stmt->rowCount();

        // Si l'email existe déjà, renvoie true
        if ($num > 0) {
            return true;
        }

        return false;
    }

    // Vérifie si l'utilisateur existe déjà dans la base de données
    function userExists() {
        // Requête pour vérifier l'existence de l'utilisateur
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind des valeurs
        $stmt->bindParam(":email", $this->email);

        // Exécution de la requête
        $stmt->execute();

        // Compter le nombre de lignes
        $num = $stmt->rowCount();

        // Si l'utilisateur existe déjà, renvoie true
        if ($num > 0) {
            return true;
        }

        return false;
    }

    // Valider la connexion de l'utilisateur
    function connexion($email, $mot_de_passe) {
        // Requête de vérification des identifiants
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email AND mot_de_passe = :mot_de_passe";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $email = htmlspecialchars(strip_tags($email));
        $mot_de_passe = htmlspecialchars(strip_tags($mot_de_passe));

        // Bind des valeurs
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mot_de_passe", $mot_de_passe);

        // Exécution de la requête
        $stmt->execute();

        // Compter le nombre de lignes
        $num = $stmt->rowCount();

        // Si les identifiants sont valides, renvoie true
        if ($num > 0) {
            return true;
        }

        return false;
    }

    // Setter pour le nom
    function setNom($nom) {
        $this->nom = $nom;
    }

    // Setter pour l'email
    function setEmail($email) {
        $this->email = $email;
    }

    // Setter pour le mot de passe
    function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }
}
?>
