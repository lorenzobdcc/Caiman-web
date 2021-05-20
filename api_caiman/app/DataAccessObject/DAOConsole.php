<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Data access object of the category table.
 */

namespace App\DataAccessObject;

use App\Models\Console;


class DAOConsole
{

    private \PDO $db;

    /**
     * 
     * Constructor of the DAOConsole object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function find(int $id)
    {
        $statement = "
        SELECT *
        FROM consol
        WHERE id = :ID_console;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':ID_console', $id, \PDO::PARAM_INT);
            $statement->execute();

            $console = new console();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $console->id = $result["id"];
                $console->name = $result["name"];
                $console->folderName = $result["folderName"];
                $console->idEmulator = $result["idEmulator"];
            } else {
                $console = null;
            }
            return $console;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
