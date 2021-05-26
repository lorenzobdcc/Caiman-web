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
use App\DataAccessObject\DAOConsole;
use App\DataAccessObject\DAOFile;
use App\Models\Console;
use App\Models\File;

class GameController
{

    private DAOGame $DAOGame;
    private DAOUser $DAOUser;
    private DAOFile $DAOFile;
    private DAOConsole $DAOConsole;


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
        $this->DAOFile = new DAOFile($db);
        $this->DAOConsole = new DAOConsole($db);
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
     * Method to return a list of games
     *
     * @param integer $id
     * @return void
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

    /**
     * Method to return a list of games
     *
     * @param integer $id
     * @return void
     */
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
     * Method to return a game in JSON format.
     * 
     * @param int $id The game identifier
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
     * @param int $id The game identifier
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

    public function getTimePlayed(int $idGame,int $idUser)
    {
        $timer = $this->DAOGame->getTimeUser($idGame,$idUser);

        if (is_null($timer)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($timer);
    }

    public function addOneMInuteToGameTime(int $idGame,int $idUser)
    {
        $this->DAOGame->addOneMInuteToGameTime($idGame,$idUser);

        return ResponseController::successfulRequest();
    }

    /**
     * Get the url to a file in the serveur
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function getURL(int $idGame, string $apikey)
    {
        $headers = apache_request_headers();


        $user = $this->DAOUser->find($apikey);
        $fullpath = "";
        if (is_null($user)) {
            return ResponseController::notFoundResponse();
        } else {
            $game = $this->DAOGame->find($idGame);
            $file = $this->DAOFile->find($game->idFile);
            $console = $this->DAOConsole->find($game->idConsole);
            $fullpath = "../../../../caimanWeb/games/" . $console->folderName . "/" . $file->filename;


            if (file_exists($fullpath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($fullpath));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fullpath));
                $fp = fopen($fullpath, 'rb');
                fpassthru($fp);
                exit;
            }
        }

        return ResponseController::successfulRequest($fullpath);
    }

    /**
     * Get the url to a file in the serveur
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function getFileName(int $idGame)
    {
        $headers = apache_request_headers();

        $game = $this->DAOGame->find($idGame);
        $file = $this->DAOFile->find($game->idFile);

        if (is_null($file)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($file);
    }

    /**
     * Remove game from favorite
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function removeGameFromFavorite(int $idGame, int $idUser)
    {
        $headers = apache_request_headers();

        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $file = $this->DAOGame->removeGameFromFavorite($idGame, $idUser);
        return ResponseController::successfulRequest();
    }

    /**
     * Add game to favorite
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function addGameToFavorite(int $idGame, int $idUser)
    {
        $headers = apache_request_headers();

        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $this->DAOGame->addGameToFavorite($idGame, $idUser);
        return ResponseController::successfulRequest();
    }

        /**
     * Check if game is in favorite
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function checkIfGameFavorite(int $idGame, int $idUser)
    {
        $headers = apache_request_headers();

        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $value =$this->DAOGame->checkIfGameFavorite($idGame, $idUser);;
        return ResponseController::successfulRequest($value);
    }

    /**
     * Get the url to a file in the serveur
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function getConsole(int $idGame)
    {
        $headers = apache_request_headers();

        $game = $this->DAOGame->find($idGame);
        $console = $this->DAOConsole->find($game->idConsole);

        if (is_null($console)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($console);
    }
}
