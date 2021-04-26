<?php
class Categories {

    private $dbh = null;

    private $psGetAllCategories = null;
    
    private $psGameCategorie = null;




   
    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                )); 
                //get all categories
                $sqlGetAllCategories = "SELECT * FROM categorie";
                $this->psGetAllCategories = $this->dbh->prepare($sqlGetAllCategories);
                $this->psGetAllCategories->setFetchMode(PDO::FETCH_ASSOC);

                //add categorie
                $sqlAddCategorie = "INSERT INTO categorie (name) VALUES (:categorie_name)";
                $this->psAddCategorie = $this->dbh->prepare($sqlAddCategorie);
                $this->psAddCategorie->setFetchMode(PDO::FETCH_ASSOC);

                //get categories of a game
                $sqlGameCategorie = "SELECT c.name, c.id FROM `gamehascategorie` as ghc
                LEFT JOIN categorie as c
                ON ghc.idCategorie = c.id
                LEFT JOIN game as g
                ON ghc.idGame = g.id
                WHERE idGame = :search_id";
                $this->psGameCategorie = $this->dbh->prepare($sqlGameCategorie);
                $this->psGameCategorie->setFetchMode(PDO::FETCH_ASSOC);


            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    
    public function getListAllCategories()
    {
        
        try{
            $this->psGetAllCategories->execute();
            $result = $this->psGetAllCategories->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getCategoriesOfGame(int $idGame)
    {
        try{
            $this->psGameCategorie->execute(array(':search_id' => $idGame));
            $result = $this->psGameCategorie->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function addCategorie(string $categorieName)
    {
        try{
            $this->psAddCategorie->execute(array(':categorie_name' => $categorieName));
            $result = $this->psAddCategorie->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    

}