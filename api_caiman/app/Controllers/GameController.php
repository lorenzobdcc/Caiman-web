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
use App\DataAccessObject\DAOFileSave;
use App\Models\Console;
use App\Models\File;
use App\Models\FileSave;

class GameController
{

    private DAOGame $DAOGame;
    private DAOUser $DAOUser;
    private DAOFile $DAOFile;
    private DAOConsole $DAOConsole;
    private DAOFileSave $DAOFileSave;


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
        $this->DAOFileSave = new DAOFileSave($db);
    }

    /**
     * 
     * Method to return all games in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllGames()
    {

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

        $game = $this->DAOGame->findGameFromCategory($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * Method to return the list of the user favorites games
     *
     * @param integer $id
     * @return void
     */
    public function getFavoriteGameOfUser(int $id)
    {

        $game = $this->DAOGame->findFavoriteGameOfUser($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * Method to return the list of game the user as already played
     *
     * @param integer $id
     * @return void
     */
    public function getTimeGames(int $id)
    {
        $game = $this->DAOGame->findTimesGamesUser($id);
        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }

    /**
     * 
     * Method to return a list of game where the name match the given parameters
     * @param string name
     * @return list game
     */
    public function getGamesFromName(string $name)
    {

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

        $game = $this->DAOGame->find($id);

        if (is_null($game)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($game);
    }
    /**
     * 
     * Method to get the time a user as play a game
     */
    public function getTimePlayed(int $idGame, int $idUser)
    {
        $timer = $this->DAOGame->getTimeUser($idGame, $idUser);

        if (is_null($timer)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($timer);
    }
    /**
     * Method to update the time played by a user
     * this method will add one minute in the database
     * 
     * @param int idGame
     * @param int idUser
     * @return void
     * 
     */
    public function addOneMInuteToGameTime(int $idGame, int $idUser)
    {
        $this->DAOGame->addOneMInuteToGameTime($idGame, $idUser);

        return ResponseController::successfulRequest();
    }

    /**
     * Return the game file
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function getURL(int $idGame, string $apikey)
    {

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
     * Return the ziped save file of one emulator for one user
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function getURLSave(int $idEmulator, int $idUser, string $apikey)
    {

        $user = $this->DAOUser->find($apikey);
        $fullpath = "";
        if (is_null($user)) {
            return ResponseController::notFoundResponse();
        } else {
            $fileSave = $this->DAOFileSave->find($idEmulator, $idUser);

            if (is_null($fileSave)) {
                return ResponseController::notFoundResponse();
                exit;
            }
            $file = $this->DAOFile->find($fileSave->idFile);
            $fullpath = "../../../../caimanWeb/saves/" . $file->filename;


            if (file_exists($fullpath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/zip');
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

        return ResponseController::successfulRequest();
    }

    /**
     * 
     * Method to upload the saves file 
     * 
     * @return void
     */
    public function AddSave($idEmulator, $idUser, $apiKey, $file)
    {

        if (is_null($idEmulator) || is_null($idUser) || is_null($apiKey)) {
            return ResponseController::notFoundResponse();
            exit;
        }
        $user = $this->DAOUser->find($apiKey);

        if ($user == null) {
            return ResponseController::notFoundResponse();
            exit;
        }
        $isNewFile = false;
        $newfilename = $this->DAOFileSave->FindFileName($idEmulator, $idUser);

        if ($newfilename == null) {
            $newfilename = md5(microtime());
            $newfilename = $newfilename . ".zip";
            $isNewFile = true;
        }
        $target_dir = "../../../../caimanWeb/saves/";

        if (move_uploaded_file($file, $target_dir . $newfilename)) {
            if ($isNewFile) {
                $this->DAOFileSave->AddFileSave($idEmulator, $idUser, $newfilename);
            }
        } else {
            return ResponseController::uploadFailed();
            exit;
        }

        return ResponseController::successfulRequest();
    }

    /**
     * Get the filename of a game
     *
     * @param integer $idGame
     * @return file
     */
    public function getFileName(int $idGame)
    {

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

        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $this->DAOGame->removeGameFromFavorite($idGame, $idUser);
        return ResponseController::successfulRequest();
    }

    /**
     * Add game to favorite
     *
     * @param integer $idGame
     * @param integer $idUser
     * @return void
     */
    public function addGameToFavorite(int $idGame, int $idUser)
    {
        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $this->DAOGame->addGameToFavorite($idGame, $idUser);
        return ResponseController::successfulRequest();
    }

    /**
     * Method to check if game is already in favorite
     *
     * @param integer $idGame
     * @param string $apikey
     * @return void
     */
    public function checkIfGameFavorite(int $idGame, int $idUser)
    {

        if (is_null($idGame) || is_null($idUser)) {
            return ResponseController::notFoundResponse();
        }
        $value = $this->DAOGame->checkIfGameFavorite($idGame, $idUser);;
        return ResponseController::successfulRequest($value);
    }

    /**
     * Method to get the console of a game
     *
     * @param integer $idGame
     * @return void
     */
    public function getConsole(int $idGame)
    {

        $game = $this->DAOGame->find($idGame);
        $console = $this->DAOConsole->find($game->idConsole);

        if (is_null($console)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($console);
    }
}
