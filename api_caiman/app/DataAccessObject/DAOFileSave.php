<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Data access object of the category table.
 */

namespace App\DataAccessObject;

use App\Models\File;
use App\Models\FileSave;

class DAOFileSave
{

    private \PDO $db;

    /**
     * 
     * Constructor of the DAOfile object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Return a fileSave frome it's id
     *
     * @param integer $id
     * @return void
     */
    public function find(int $idEmulator, int $idUser)
    {
        $statement = "
        SELECT *
        FROM filesave
        WHERE idUser = :ID_user AND
        idEmulator = :ID_emulator ;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_user', $idUser, \PDO::PARAM_INT);
            $statement->bindParam(':ID_emulator', $idEmulator, \PDO::PARAM_INT);
            $statement->execute();

            $file = new FileSave();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $file->id = $result["id"];
                $file->idUser = $result["idUser"];
                $file->idEmulator = $result["idEmulator"];
                $file->idFile = $result["idFile"];
            } else {
                $file = null;
            }
            return $file;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Return the filename of a fileSave
     *
     * @param integer $id
     * @return void
     */
    public function findFileName(int $idEmulator, int $idUser)
    {

        $statement = "
    SELECT f.filename filesave FROM `filesave` as fs
                LEFT JOIN file as f
                ON fs.idFile = f.id
                WHERE idUser = :ID_user AND idEmulator = :ID_emulator;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_user', $idUser, \PDO::PARAM_INT);
            $statement->bindParam(':ID_emulator', $idEmulator, \PDO::PARAM_INT);
            $statement->execute();

            $file = new File();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $file->filename = $result['filesave'];
            }
            return $file->filename;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    /**
     * 
     * Method to upload add a fileSave
     * @return void
     */
    public function AddFileSave($idEmulator, $idUser, $newFileName)
    {
        $statementFile = "
        INSERT INTO file
        (filename, dateUpdate)
        VALUES
        (:FILENAME, NOW())";
        try {
            $statementFile = $this->db->prepare($statementFile);
            $statementFile->bindParam(':FILENAME', $newFileName, \PDO::PARAM_STR);
            $statementFile->execute();
            //when create file is done
            $statementFileSave = "
            INSERT INTO filesave
            (idUser, idEmulator,idFile)
            VALUES
            (:ID_user,:ID_emulator, :ID_file)";
            try {
                $statementFileSave = $this->db->prepare($statementFileSave);
                $statementFileSave->bindParam(':ID_user', $idUser, \PDO::PARAM_INT);
                $statementFileSave->bindParam(':ID_emulator', $idEmulator, \PDO::PARAM_INT);
                $lastInsertId = $this->db->lastInsertId();
                $statementFileSave->bindParam(':ID_file', $lastInsertId, \PDO::PARAM_INT);
                $statementFileSave->execute();
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
