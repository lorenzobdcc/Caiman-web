<?php
/**
 * DogController.php
 *
 * Controller of the Dog model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */

namespace App\Controllers;

use App\DataAccessObject\DAOGame;
use App\DataAccessObject\DAOUser;
use App\Controllers\ResponseController;
use App\Controllers\HelperController;
use App\Models\Game;
use App\System\Constants;

class GameController {

    private DAOGame $DAOGame;
    private DAOUser $DAOUser;


    /**
     * 
     * Constructor of the DogController object.
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
     * Method to return all dogs in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllGames()
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }

        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth) || $userAuth->code_role != Constants::ADMIN_CODE_ROLE) {
            return ResponseController::unauthorizedUser();
        }


        
        $allGames = $this->DAOGame->findAll();

        return ResponseController::successfulRequest($allGames);  
    }

    /**
     * 
     * Method to return a dog in JSON format.
     * 
     * @param int $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getGame(int $id)
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }

        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth) || $userAuth->code_role != Constants::ADMIN_CODE_ROLE) {
            return ResponseController::unauthorizedUser();
        }

        $game = $this->DAOGame->find($id);

        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * 
     * Method to create a dog.
     * 
     * @param Dog $dog The dog model object
     * @return string The status and the body in JSON format of the response
     */
    public function createDog(Game $game)
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }

        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth) || $userAuth->code_role != Constants::ADMIN_CODE_ROLE) {
            return ResponseController::unauthorizedUser();
        }

        if (!$this->validateGame($game)) {
            return ResponseController::unprocessableEntityResponse();
        }

        $user = $this->DAOUser->find($game->user_id);

        if (is_null($user)) {
            return ResponseController::notFoundResponse();
        }

        $this->DAOgame->insert($game);

        return ResponseController::successfulCreatedRessource();
    }

    /**
     * 
     * Method to update a dog.
     * 
     * @param Dog $dog The dog model object
     * @return string The status and the body in JSON format of the response
     */
    public function updateGame(Game $game)
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }

        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth) || $userAuth->code_role != Constants::ADMIN_CODE_ROLE) {
            return ResponseController::unauthorizedUser();
        }

        $actualGame = $this->DAOGame->find($game->id);

        if (is_null($actualGame)) {
            return ResponseController::notFoundResponse();
        }

        $actualGame->name = $game->name ?? $actualGame->name;
        $actualGame->breed = $game->description ?? $actualGame->description;

        $this->DAOGame->update($actualGame);

        return ResponseController::successfulRequest(null);
    }

    /**
     * 
     * Method to delete a dog.
     * 
     * @param int  $id The dog identifier
     * @return string The status and the body in JSON format of the response
     */
    public function deleteGame(int $id)
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }

        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth) || $userAuth->code_role != Constants::ADMIN_CODE_ROLE) {
            return ResponseController::unauthorizedUser();
        }

        $game = $this->DAOGame->find($id);

        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        if (!is_null($game->picture_serial_id)) {
            $filename = HelperController::getDefaultDirectory()."storage/app/dog_picture/".$game->picture_serial_id.".jpeg";
            if (file_exists($filename)) {
                unlink($filename);
            }
        }

        $this->DAODog->delete($game);

        return ResponseController::successfulRequest(null);
    }

}