<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Controller of the User model
 */

namespace App\Controllers;

use App\DataAccessObject\DAOUser;
use app\Models\User;
use App\Controllers\ResponseController;

class UserController
{

    private DAOUser $DAOUser;

    /**
     * 
     * Constructor of the UserController object.
     * 
     * @param PDO $db The database connection
     */
    public function __construct(\PDO $db)
    {
        $this->DAOUser = new DAOUser($db);
    }

    /**
     * 
     * Method to return all users in JSON format.
     * 
     * @return string The status and the body in json format of the response
     */
    public function getAllUsers()
    {


        $allCustomerUsers = $this->DAOUser->findAll();

        return ResponseController::successfulRequest($allCustomerUsers);
    }



    /**
     * 
     * Method to return the informations of one user
     * 
     * @param int $id The user identifier
     * @return User
     */
    public function getUser(string $apitocken)
    {

        $user = $this->DAOUser->find($apitocken);

        if (is_null($user)) {
            return ResponseController::notFoundResponse();
        }

        return ResponseController::successfulRequest($user);
    }



    /**
     * 
     * Method to log check the login of a user
     * 
     * @param User $user The user model object
     * @return User 
     */
    public function connection(string $username, string $password)
    {
        if (is_null($username) || is_null($password)) {
            return ResponseController::unprocessableEntityResponse();
        }

        $userAuth = $this->DAOUser->findUserByUsername($username);

        if (is_null($userAuth)) {
            return ResponseController::invalidLogin();
        }

        if (md5($userAuth->salt . $password) != $userAuth->password) {
            return ResponseController::invalidLogin();
        }
        return ResponseController::successfulRequest($userAuth);
    }

    /**
     * 
     * Method to log check the login of a user by is caimanToken
     * 
     * @param string caimanToken
     * @return User The status and the body in JSON format of the response
     */
    public function findByCaimanToken(string $caimanToken)
    {

        $userAuth = $this->DAOUser->findByCaimanToken($caimanToken);

        return ResponseController::successfulRequest($userAuth);
    }

    /**
     * 
     * Method to update caimanToken
     * 
     * @param String
     * @return string The status and the body in JSON format of the response
     */
    public function updateCaimanToken($apitoken)
    {
        $this->DAOUser->updateCaimanToken($apitoken);

        return ResponseController::successfulRequest();
    }
}
