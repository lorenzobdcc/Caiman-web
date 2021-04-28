<?php
class Games {

    private $dbh = null;

    private $psGetAllGames = null;

    private $psRequestGames;

    private $psGameDetail;

    private $psFavoriteGameOfUser;

    private $psGameInCategorie;

    private $psAddGameToFavori;

    private $psRemoveGameFromFavori;

    private $psCheckIfFavoris;

    private $psGetTimeInGame;

    private $psGetGameWithTime;


   
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

                //get Time in game user
                $sqlTimeInGame = "SELECT * FROM timeingame WHERE idGame = :search_idGame AND idUser = :search_idUser ";
                $this->psGetTimeInGame = $this->dbh->prepare($sqlTimeInGame);
                $this->psGetTimeInGame->setFetchMode(PDO::FETCH_ASSOC);

                //get game with time user
                $sqlGetGameWithTime = "SELECT * FROM timeingame WHERE idUser = :search_idUser ORDER BY timeInMinute DESC";
                $this->psGetGameWithTime = $this->dbh->prepare($sqlGetGameWithTime);
                $this->psGetGameWithTime->setFetchMode(PDO::FETCH_ASSOC);

                //get detail game
                $sqlGameDetail = "SELECT * FROM game WHERE id = :search_id";
                $this->psGameDetail = $this->dbh->prepare($sqlGameDetail);
                $this->psGameDetail->setFetchMode(PDO::FETCH_ASSOC);

                //add game to favoris
                $sqlAddGameToFavoris = "INSERT INTO favoritegame  (idGame, idUser)
                VALUES (:search_idGame, :search_idUser)";
                $this->psAddGameToFavori = $this->dbh->prepare($sqlAddGameToFavoris);
                $this->psAddGameToFavori->setFetchMode(PDO::FETCH_ASSOC);

                //remove game to favoris
                $sqlRemoveGameFormFavoris = "DELETE FROM favoritegame 
                WHERE idUser = :search_idUser AND idGame = :search_idGame";
                $this->psRemoveGameFromFavori = $this->dbh->prepare($sqlRemoveGameFormFavoris);
                $this->psRemoveGameFromFavori->setFetchMode(PDO::FETCH_ASSOC);

                //check if already in favoris
                $sqlCheckIfAlreadyFavoris = "SELECT * FROM favoritegame 
                WHERE iduser = :search_idUser AND idGame = :search_idGame";
                $this->psCheckIfFavoris = $this->dbh->prepare($sqlCheckIfAlreadyFavoris);
                $this->psCheckIfFavoris->setFetchMode(PDO::FETCH_ASSOC);

                //get favorite game of user
                $sqlFavoriteGameOfUser = "SELECT g.name, g.id, g.imageName FROM `favoritegame` as fg
                LEFT JOIN game as g
                ON fg.idGame = g.id
                LEFT JOIN user as u
                ON fg.iduser = u.id
                WHERE iduser = :search_id";
                $this->psFavoriteGameOfUser = $this->dbh->prepare($sqlFavoriteGameOfUser);
                $this->psFavoriteGameOfUser->setFetchMode(PDO::FETCH_ASSOC);

                

                //get list of games in a categorie
                $sqlGameInCategorie = "SELECT g.name, g.id, g.imageName FROM `gamehascategorie` as ghc
                LEFT JOIN game as g
                ON ghc.idGame = g.id
                LEFT JOIN categorie as c
                ON ghc.idCategorie = c.id
                WHERE idCategorie = :search_id";
                $this->psGameInCategorie = $this->dbh->prepare($sqlGameInCategorie);
                $this->psGameInCategorie->setFetchMode(PDO::FETCH_ASSOC);

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

    public function getTimeInGameUser(int $idUser,int $idGame)
    {
        try{
            $this->psGetTimeInGame->execute(array(':search_idGame' => $idGame, ':search_idUser' => $idUser));
            $result = $this->psGetTimeInGame->fetchAll();
        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getListOfGameWithTimeUser(int $idUser)
    {
        try{
            $this->psGetGameWithTime->execute(array(':search_idUser' => $idUser));
            $result = $this->psGetGameWithTime->fetchAll();


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


    public function getGamesInCategorie(int $idCategorie)
    {
        try{
            $this->psGameInCategorie->execute(array(':search_id' => $idCategorie));
            $result = $this->psGameInCategorie->fetchAll();
        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function getFavoriteGamesOfUser(int $idUser)
    {
        try{
            $this->psFavoriteGameOfUser->execute(array(':search_id' => $idUser));
            $result = $this->psFavoriteGameOfUser->fetchAll();


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function addGameToFavoris(int $idUser, int $idGame)
    {
        
        try{
            $this->psAddGameToFavori->execute(array(':search_idUser' => $idUser,':search_idGame' => $idGame));
            $result = $this->psAddGameToFavori->fetchAll();

        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    public function removeGameFromFavoris(int $idUser, int $idGame)
    {
        
        try{
            $this->psRemoveGameFromFavori->execute(array(':search_idUser' => $idUser,':search_idGame' => $idGame));


        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
    }

    public function checkIfGameIsAlreadyInFavoris(int $idUser, int $idGame)
    {
        $boolResult = true;
        
        try{
            $this->psCheckIfFavoris->execute(array(':search_idUser' => $idUser,':search_idGame' => $idGame));
            $result = $this->psCheckIfFavoris->fetchAll();
            if ($result != null) {
                $boolResult = false;
            }

        }catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $boolResult;
    }

}