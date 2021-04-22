<?php
class Games {

    private $dbh = null;

    private $psGetAllGames = null;

    private $psRequestGames;

    private $psGameDetail;

    private $psGameCategory;

    private $psGameInCategory;


   
    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                )); 
                //get all games
                $sqlGetAllGames = "SELECT * FROM game";
                $this->psGetAllGames = $this->dbh->prepare($sqlGetAllGames);
                $this->psGetAllGames->setFetchMode(PDO::FETCH_ASSOC);

                //get request games
                $sqlRequestGames = "SELECT * FROM game WHERE name LIKE :search_game";
                $this->psRequestGames = $this->dbh->prepare($sqlRequestGames);
                $this->psRequestGames->setFetchMode(PDO::FETCH_ASSOC);

                //get detail game
                $sqlGameDetail = "SELECT * FROM game WHERE id = :search_id";
                $this->psGameDetail = $this->dbh->prepare($sqlGameDetail);
                $this->psGameDetail->setFetchMode(PDO::FETCH_ASSOC);

                //get category of a game
                $sqlGameCategory = "SELECT c.name FROM `gamehascategory` as ghc
                LEFT JOIN category as c
                ON ghc.idCategory = c.id
                LEFT JOIN game as g
                ON ghc.idGame = g.id
                WHERE idGame = :search_id";
                $this->psGameCategory = $this->dbh->prepare($sqlGameCategory);
                $this->psGameCategory->setFetchMode(PDO::FETCH_ASSOC);

                //get list of game in a category
                $sqlGameInCategory = "SELECT * FROM game WHERE id = :search_id";
                $this->psGameInCategory = $this->dbh->prepare($sqlGameInCategory);
                $this->psGameInCategory->setFetchMode(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    public function getAllGames()
    {
        
        try{
            $this->psGetAllGames->execute();
            $result = $this->psGetAllGames->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }
    public function getRequestGames(string $gameName)
    {

        try{
            $this->psRequestGames->execute(array(':search_game' => '%'.$gameName.'%'));
            $result = $this->psRequestGames->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getGameDetail(int $idGame)
    {

        try{
            $this->psGameDetail->execute(array(':search_id' => $idGame));
            $result = $this->psGameDetail->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getCategoryOfGame(int $idGame)
    {
        try{
            $this->psGameCategory->execute(array(':search_id' => $idGame));
            $result = $this->psGameCategory->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getGamesInCategory(int $idCategory)
    {

    }

}