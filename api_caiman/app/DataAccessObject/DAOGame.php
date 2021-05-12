<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Data access object of the game table.
 */
namespace App\DataAccessObject;

use App\Models\Game;


class DAOGame {

    private \PDO $db;

    /**
     * 
     * Constructor of the DAOgame$game object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * 
     * Method to return all game$games from the database in an array of game$game objects.
     * 
     * @return Game[] A game$game object array
     */
    public function findAll()
    {
        $statement = "
        SELECT *
        FROM game;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $gameArray = array();
            
            foreach ($results as $result) {
                $game = new game();
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
                array_push($gameArray,$game);
            }

            return $gameArray;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
     * 
     * Method to return a game$game from the database in a game model object.
     * 
     * @param int $id The game$game identifier 
     * @return game A game model object containing all the result rows of the query 
     */
    public function find(int $id)
    {
        $statement = "
        SELECT *
        FROM game
        WHERE id = :ID_game;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_game', $id, \PDO::PARAM_INT);
            $statement->execute();
            
            $game = new game();

            if ($statement->rowCount()==1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
            }
            else{
                $game = null;
            }

            return $game;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function findGameFromCategory(int $id)
    {
        $statement = "
        SELECT g.name, g.id, g.imageName, g.description, g.idConsole, g.idFile FROM `gamehascategorie` as ghc
                LEFT JOIN game as g
                ON ghc.idGame = g.id
                LEFT JOIN categorie as c
                ON ghc.idCategorie = c.id
                WHERE idCategorie = :search_id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':search_id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $gameArray = array();
            foreach ($results as $result) {
                $game = new game();
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
                array_push($gameArray,$game);
            }

            return $gameArray;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function findTimesGamesUser(int $id)
    {
        $statement = "
        SELECT g.name, g.id, g.imageName, g.description, g.idConsole, g.idFile, timeInMinute FROM `timeingame` as tig
                LEFT JOIN game as g
                ON tig.idGame = g.id
                WHERE idUser = :search_id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':search_id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $gameArray = array();
            foreach ($results as $result) {
                $game = new game();
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
                $game->time = $result["timeInMinute"];
                array_push($gameArray,$game);
            }

            return $gameArray;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function findFavoriteGameOfUser(int $id)
    {
        $statement = "
        SELECT g.name, g.id, g.imageName, g.description, g.idConsole, g.idFile FROM `favoritegame` as fg
        LEFT JOIN game as g
        ON fg.idGame = g.id
        LEFT JOIN user as u
        ON fg.iduser = u.id
        WHERE iduser = :search_id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':search_id', $id, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $gameArray = array();
            foreach ($results as $result) {
                $game = new game();
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
                array_push($gameArray,$game);
            }

            return $gameArray;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function findGamesFromName(string $name)
    {
        $statement = "
        SELECT * FROM game WHERE name LIKE '%".$name."%'
        ;";

        try {
            $statement = $this->db->prepare($statement);
            $truename = '%'.$name.'%';
            $statement->bindParam(':search_game',$truename, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $gameArray = array();
            foreach ($results as $result) {
                $game = new game();
                $game->id = $result["id"];
                $game->name = $result["name"];
                $game->description = $result["description"];
                $game->imageName = $result["imageName"];
                $game->idConsole = $result["idConsole"];
                $game->idFile = $result["idFile"];
                array_push($gameArray,$game);
            }
            return $gameArray;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }


}