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
use App\System\Constants;

class UserController {

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
    public function getAllCustomerUsers()
    {
        $headers = apache_request_headers();


        
        $allCustomerUsers = $this->DAOUser->findAll();

        return ResponseController::successfulRequest($allCustomerUsers);  
    }



    /**
     * 
     * Method to return a user in JSON format.
     * 
     * @param int $id The user identifier
     * @return string The status and the body in JSON format of the response
     */
    public function getUser(int $id)
    {
        $headers = apache_request_headers();



        $user = $this->DAOUser->find($id);

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
     * @return string The status and the body in JSON format of the response
     */
    public function connection(string $username ,string $password)
    {
        if (is_null($username) || is_null($password)) {
            return ResponseController::unprocessableEntityResponse();
        }

        $userAuth = $this->DAOUser->findUserByUsername($username);

        if (is_null($userAuth)) {
            return ResponseController::invalidLogin();
        }

        if (md5($userAuth->salt.$password) != $userAuth->password  ) {
            return ResponseController::invalidLogin();
        }


        return ResponseController::successfulRequest($userAuth);
    }


}