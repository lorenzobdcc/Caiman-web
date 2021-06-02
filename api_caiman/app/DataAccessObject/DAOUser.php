<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Data access object of the User table.
 */

namespace App\DataAccessObject;

use App\Models\User;

class DAOUser
{

    private \PDO $db;

    /**
     * 
     * Constructor of the DAOUser object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * 
     * Method to return all users with the selected role from the database in an array of user objects.
     * 
     * @return User[] A User object array
     */
    public function findAll()
    {
        $statement = "
        SELECT *
        FROM user";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $userArray = array();

            foreach ($results as $result) {
                $user = new User();
                $user->id = $result["id"];
                $user->username = $result["username"];
                array_push($userArray, $user);
            }
            return $userArray;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


    /**
     * 
     * Method to return a user from the database in a user model object from it's apiToken
     * 
     * @param string $apitocken
     * @return User A User model object containing all the result rows of the query 
     */
    public function find(string $apitocken)
    {
        $statement = "
        SELECT *
        FROM user
        WHERE apitocken = :API_TOCKEN;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':API_TOCKEN', $apitocken);
            $statement->execute();
            $user = new User();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $user = new User();
                $user->id = $result["id"];
                $user->username = $result["username"];
                $user->password = $result["password"];
                $user->salt = $result["salt"];
                $user->apitocken = $result["apitocken"];
                $user->email = $result["email"];
                $user->idRole = $result["idRole"];
                $user->caimanToken = $result["caimanToken"];
            } else {
                $user = null;
            }

            return $user;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 
     * Method to return a user from the database in a user model object from a caimanToken
     * 
     * @param string $caimanToken
     * @return User A User model object containing all the result rows of the query 
     */
    public function findByCaimanToken(string $caimanToken)
    {
        $caimanTokenNew = md5(microtime());
        $statement_caimanToken = "
        UPDATE user
        SET caimanToken = :CAIMAN_TOKEN_NEW
        WHERE caimanToken = :CAIMAN_TOKEN
        LIMIT 1";

        try {
            $statement_caimanToken = $this->db->prepare($statement_caimanToken);

            $statement_caimanToken->bindParam(':CAIMAN_TOKEN_NEW', $caimanTokenNew);
            $statement_caimanToken->bindParam(':CAIMAN_TOKEN', $caimanToken);
            $statement_caimanToken->execute();
        } catch (\PDOException $e) {
            //exit($e->getMessage());
        }

        $statement = "
        SELECT *
        FROM user
        WHERE caimanToken = :CAIMAN_TOCKEN;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':CAIMAN_TOCKEN', $caimanTokenNew);
            $statement->execute();
            $user = new User();
            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $user = new User();
                $user->id = $result["id"];
                $user->username = $result["username"];
                $user->password = $result["password"];
                $user->salt = $result["salt"];
                $user->apitocken = $result["apitocken"];
                $user->email = $result["email"];
                $user->idRole = $result["idRole"];
                $user->caimanToken = $result["caimanToken"];
            } else {
                $user = null;
            }

            return $user;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 
     * Method to return update the caimanToken of a user
     * 
     * @param string $apitocken
     * @return void 
     */
    public function updateCaimanToken(string $apitocken)
    {
        $statement = "
        UPDATE user
        SET caimanToken = :CAIMAN_TOKEN
        WHERE apitocken = :API_TOCKEN;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':API_TOCKEN', $apitocken);
            $caimanTocken = md5(microtime());
            $statement->bindParam(':CAIMAN_TOKEN', $caimanTocken);
            $statement->execute();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 
     * Method to return get a user from a username
     * 
     * @param string $username
     * @return User 
     */
    public function findUserByUsername(string $username)
    {

        $statement = "
        SELECT *
        FROM user
        WHERE username = :username
        LIMIT 1";

        try {
            $statement = $this->db->prepare($statement);
            $statement->bindParam(':username', $username, \PDO::PARAM_STR);
            $statement->execute();

            $user = new User();

            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(\PDO::FETCH_ASSOC);
                $user = new User();
                $user->id = $result["id"];
                $user->username = $result["username"];
                $user->password = $result["password"];
                $user->salt = $result["salt"];
                $user->apitocken = $result["apitocken"];
                $user->email = $result["email"];
                $user->idRole = $result["idRole"];
                $user->caimanToken = $result["caimanToken"];
            } else {
                $user = null;
            }

            return $user;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
