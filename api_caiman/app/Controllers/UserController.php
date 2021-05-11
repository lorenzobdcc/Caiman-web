<?php
/**
 * UserController.php
 *
 * Controller of the User model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */

namespace App\Controllers;

use App\DataAccessObject\DAOUser;
use App\DataAccessObject\DAODog;
use App\DataAccessObject\DAODocument;
use App\DataAccessObject\DAOAppoitment;
use app\Models\User;
use App\Controllers\ResponseController;
use App\System\Constants;

class UserController {

    private DAOUser $DAOUser;
    private DAODog $DAODog;
    private DAODocument $DAODocument;
    private DAOAppoitment $DAOAppoitment;

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
     * Method to create a user.
     * 
     * @param User $user The user model object
     * @return string The status and the body in JSON format of the response
     */
    public function createUser(User $user)
    {     
        $user->api_token = HelperController::generateApiToken();
        $user->code_role = Constants::USER_CODE_ROLE;
        
        if (!$this->validateUser($user)) {
            return ResponseController::unprocessableEntityResponse();
        } 

        if (!HelperController::validateEmailFormat($user->email)) {
            return ResponseController::invalidEmailFormat();
        }

        if ($user->password_hash != null) {
            $user->password_hash = password_hash($user->password_hash,PASSWORD_DEFAULT);
        }
        else{
            $random_password = HelperController::generateRandomString();
            $user->password_hash = password_hash($random_password,PASSWORD_DEFAULT);
        }

        $this->DAOUser->insert($user);

        if (isset($random_password)) {
            HelperController::sendMail($random_password,$user->email);
        }

        return ResponseController::successfulCreatedRessource();
    }

    

    /**
     * 
     * Method to get the api token of a user by logging in.
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

    /**
     * 
     * Method to return all information of the currently logged in user in JSON format.
     * 
     * @return string The status and the body in JSON format of the response
     */
    public function getMyInformations()
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization'])) {
            return ResponseController::notFoundAuthorizationHeader();
        }
        
        $userAuth = $this->DAOUser->findByApiToken($headers['Authorization']);

        if (is_null($userAuth)) {
            return ResponseController::notFoundResponse();
        }
        $dogs = $this->DAODog->findByUserId($userAuth->id);
        $documents = $this->DAODocument->findByUserId($userAuth->id);
        $appoitments = $this->DAOAppoitment->findByUserId($userAuth->id);
        $userAuth->dogs = $dogs;
        $userAuth->documents = $documents;
        $userAuth->appoitments = $appoitments;
        
        
        return ResponseController::successfulRequest($userAuth);
    }

     /**
     * 
     * Method to check if the user required fields have been defined for the creation.
     * 
     * @param User $user The user model object
     * @return bool
     */
    private function validateUser(User $user)
    {
        if ($user->email == null) {
            return false;
        }

        if ($user->firstname == null) {
            return false;
        }

        if ($user->lastname == null) {
            return false;
        }

        if ($user->phonenumber == null) {
            return false;
        }

        if ($user->address == null) {
            return false;
        }

        return true;
    }
}