<?php
/**
 * DAOgame$game.php
 *
 * Data access object of the game$game table.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */
namespace App\DataAccessObject;

use App\Models\Category;


class DAOCategory {

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
     * @return Category[] A game$game object array
     */
    public function getAllCategory()
    {
        $statement = "
        SELECT *
        FROM categorie;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $categoryArray = array();
            
            foreach ($results as $result) {
                $category = new Category();
                $category->id = $result["id"];
                $category->name = $result["name"];
                array_push($categoryArray,$category);
            }

            return $categoryArray;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


}