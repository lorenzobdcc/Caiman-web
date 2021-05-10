<?php
/**
 * DAOgame$game.php
 *
 * Data access object of the game$game table.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
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
                $game->imageName = $result["imangeName"];
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
                $game->imageName = $result["imangeName"];
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



    /**
     * 
     * Method to update a game$game in the database.
     * 
     * @param game$game $game The game$game model object
     * @return int The number of rows affected by the update
     */
    public function update(game $game)
    {
        $statement = "
        UPDATE game$game
        SET name = :NAME, 
        description = :DESCRIPTION,

        WHERE id = :ID_game;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':NAME', $game->name, \PDO::PARAM_STR);
            $statement->bindParam(':DESCRIPTION', $game->description, \PDO::PARAM_STR);    
            $statement->bindParam(':ID_game', $game->id, \PDO::PARAM_STR);
            $statement->execute();
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * 
     * Method to delete a game$game in the database.
     * 
     * @param game$game $game The game$game model object
     * @return int The number of rows affected by the delete
     */
    public function delete(game $game)
    {
        $statement = "
        DELETE FROM game
        WHERE id = :ID_game;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_game', $game->id, \PDO::PARAM_INT);  
            $statement->execute();
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}