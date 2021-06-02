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


class DAOFile
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
     * @return file
     */
    public function find(int $id)
    {
        $statement = "
        SELECT *
        FROM file
        WHERE id = :ID_file;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_file', $id, \PDO::PARAM_INT);
            $statement->execute();

            $file = new file();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $file->id = $result["id"];
                $file->filename = $result["filename"];
                $file->date = $result["dateUpdate"];
            } else {
                $file = null;
            }
            return $file;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
