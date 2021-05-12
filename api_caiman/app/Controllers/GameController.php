<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Controller of game model
 */
namespace App\Controllers;

use App\DataAccessObject\DAOGame;
use App\DataAccessObject\DAOUser;
use App\Controllers\ResponseController;

class GameController {

    private DAOGame $DAOGame;
    private DAOUser $DAOUser;


    /**
     * 
     * Constructor of the GameController object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->DAOGame = new DAOGame($db);
        $this->DAOUser = new DAOUser($db);       
    }

    /**
     * 
     * Method to return all games in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllGames()
    {
        $headers = apache_request_headers();
        

        
        $allGames = $this->DAOGame->findAll();

        return ResponseController::successfulRequest($allGames);  
    }

    /**
     * 
     * Method to return a list of games in a catagory
     * 
     * @param int $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getGameFromCategory(int $id)
    {
        $headers = apache_request_headers();

        $game = $this->DAOGame->findGameFromCategory($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

        /**
     * 
     * Method to return all the favorite game of a user
     * 
     * @param int $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getFavoriteGameOfUser(int $id)
    {
        $headers = apache_request_headers();



        $game = $this->DAOGame->findFavoriteGameOfUser($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    public function getTimeGames(int $id)
    {
        $headers = apache_request_headers();



        $game = $this->DAOGame->findTimesGamesUser($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * 
     * Method to return a dog in JSON format.
     * 
     * @param int $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getGamesFromName(string $name)
    {
        $headers = apache_request_headers();



        $game = $this->DAOGame->findGamesFromName($name);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * 
     * Method to return a game in JSON format.
     * 
     * @param int $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getGame(int $id)
    {
        $headers = apache_request_headers();

        $game = $this->DAOGame->find($id);

        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

}