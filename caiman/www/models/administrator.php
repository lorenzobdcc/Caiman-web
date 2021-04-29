<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request for the administrator
 */
class Administrator
{

    private $dbh = null;

    private $psLogin = null;

    public $search_username = null;

    public $search_password = null;

    public $arrayInfo = null;

    public $psUploadGame = null;

    public $psUploadFile = null;

    public $psUpdateGame = null;

    /**
     * default contructor
     *
     */
    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ));
                // get list of console
                $sqlGetListConsole = "SELECT * FROM consol";
                $this->psGetListConsole = $this->dbh->prepare($sqlGetListConsole);
                $this->psGetListConsole->setFetchMode(PDO::FETCH_ASSOC);

                // upload game
                $sqlUploadGame = "INSERT INTO game  (name, description, imageName, idConsole, idFile)
                VALUES (:insert_name, :insert_description, :insert_imageName, :insert_idConsole, :insert_idFile)";
                $this->psUploadGame = $this->dbh->prepare($sqlUploadGame);
                $this->psUploadGame->setFetchMode(PDO::FETCH_ASSOC);

                // upload file
                $sqlUploadFile = "INSERT INTO file  (filename, dateUpdate)
                VALUES (:insert_filename, NOW() )";
                $this->psUploadFile = $this->dbh->prepare($sqlUploadFile);
                $this->psUploadFile->setFetchMode(PDO::FETCH_ASSOC);

                // update game
                $sqlUpdateGane = "UPDATE game  SET name = :update_name, description = :update_description, idConsole = :update_idConsole WHERE id = :update_id";
                $this->psUpdateGame = $this->dbh->prepare($sqlUpdateGane);
                $this->psUpdateGame->setFetchMode(PDO::FETCH_ASSOC);

                // get folder name of console
                $sqlGetNameConsoleFolder = "SELECT folderName FROM consol WHERE id = :console_id";
                $this->psGetNameConsoleFolder = $this->dbh->prepare($sqlGetNameConsoleFolder);
                $this->psGetNameConsoleFolder->setFetchMode(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    /**
     * add a game to the database
     *
     * @param string $name
     * @param string $description
     * @param string $imageName
     * @param integer $consoleId
     * @param [type] $gameFileName
     * @return void
     */
    public function addGame(string $name, string $description, string $imageName, int $consoleId, $gameFileName)
    {

        if ($this->uploadGame($gameFileName, $consoleId) && $this->uploadGameImage($imageName)) {
            try {
                $this->psUploadFile->execute(array(':insert_filename' => $gameFileName));
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
            $lastInsertId = $this->dbh->lastInsertId();
            try {
                $this->psUploadGame->execute(array(':insert_name' => $name, ':insert_description' => $description, ':insert_imageName' => $imageName, ':insert_idConsole' => $consoleId, ':insert_idFile' => $lastInsertId));
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    /**
     * upload a game 
     *
     * @param [type] $gameFileName
     * @param [type] $consoleId
     * @return void
     */
    public function uploadGame($gameFileName, $consoleId)
    {
        $uploadIsValid = false;
        $target_dir = "../games/" . $this->getConsoleFolderName($consoleId) . "/";

        $target_file =  basename($_FILES["fileGame"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //rename file
        $newfilename = $gameFileName . '.' . $fileType;


        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileGame"]["tmp_name"], $target_dir . $newfilename)) {
                $uploadIsValid = true;
            } else {
                //Sorry, there was an error uploading your file
            }
        }
        return $uploadIsValid;
    }
/**
 * update da of a game
 *
 * @param [type] $idGame
 * @param [type] $name
 * @param [type] $description
 * @param [type] $consoleId
 * @return void
 */
    public function updateGame($idGame, $name, $description, $consoleId)
    {
        try {
            $this->psUpdateGame->execute(array(':update_name' => $name, ':update_description' => $description, ':update_idConsole' => $consoleId, ':update_id' => $idGame));
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
    }
/**
 * upload an image
 *
 * @param [type] $imageFileName
 * @return void
 */
    public function uploadGameImage($imageFileName)
    {
        $uploadIsValid = false;
        $target_dir = "img/games/";

        $target_file =  basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        //rename file
        $newfilename = $imageFileName;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $newfilename)) {
                $uploadIsValid = true;
            } else {
                //Sorry, there was an error uploading your file
            }
        }
        return $uploadIsValid;
    }
/**
 * get the path name of an console
 *
 * @param [type] $id
 * @return void
 */
    public function getConsoleFolderName($id)
    {
        $returnArray = null;
        try {
            $this->psGetNameConsoleFolder->execute(array(':console_id' => $id));
            $returnArray = $this->psGetNameConsoleFolder->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $returnArray[0]['folderName'];
    }
/**
 * returns list of all consoles
 *
 * @return void
 */
    public function getListConsole()
    {
        $returnArray = null;
        try {
            $this->psGetListConsole->execute();
            $returnArray = $this->psGetListConsole->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $returnArray;
    }
}
