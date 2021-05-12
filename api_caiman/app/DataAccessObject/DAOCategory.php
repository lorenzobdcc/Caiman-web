<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Data access object of the category table.
 */
namespace App\DataAccessObject;

use App\Models\Category;


class DAOCategory {

    private \PDO $db;

    /**
     * 
     * Constructor of the DAOgame object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * 
     * Method to return all category from the database in an array of Category objects.
     * 
     * @return Category[] A game object array
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