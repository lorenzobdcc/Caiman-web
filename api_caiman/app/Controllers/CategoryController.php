<?php
/**
 * DogController.php
 *
 * Controller of the Dog model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */

namespace App\Controllers;

use App\DataAccessObject\DAOCategory;
use App\Controllers\ResponseController;

class CategoryController {

    private DAOCategory $DAOCategory;


    /**
     * 
     * Constructor of the DogController object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->DAOCategory = new DAOCategory($db); 
    }

    /**
     * 
     * Method to return all dogs in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllCategory()
    {

        $allCategory = $this->DAOCategory->getAllCategory();

        return ResponseController::successfulRequest($allCategory);  
    }



}