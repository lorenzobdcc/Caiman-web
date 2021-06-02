<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Controller of category model
 */

namespace App\Controllers;

use App\DataAccessObject\DAOCategory;
use App\Controllers\ResponseController;

class CategoryController
{

    private DAOCategory $DAOCategory;


    /**
     * 
     * Constructor of the CategoryController object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->DAOCategory = new DAOCategory($db);
    }

    /**
     * 
     * Method to return all category in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllCategory()
    {

        $allCategory = $this->DAOCategory->getAllCategory();

        return ResponseController::successfulRequest($allCategory);
    }
}
