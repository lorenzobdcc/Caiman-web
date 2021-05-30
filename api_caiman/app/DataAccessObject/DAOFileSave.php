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
 * Return a file frome it's id
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
}
