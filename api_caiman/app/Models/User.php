<?php
/**
 * User.php
 *
 * User model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */
namespace App\Models;

class User {

    public ?int $id;
    public ?string $username;
    public ?string $password;
    public ?string $salt;
    public ?string $apitocken;
    public ?string $email;
    public ?int $privateAccount;
    public ?string $idRole;

    /**
     * 
     * Constructor of the User model object.
     * 
     * @param int $id The user identifier
     * @param string $email The email of the user
     * @param string $firstname the first name of the user
     * @param string $lastname the last name of the user
     * @param string $phonenumber The phone number of the user
     * @param string $address The address of the user
     * @param string $api_token The api_token of the user
     * @param int $code_role The code_role of the user
     * @param string $password_hash The password_hash of the user
     */
    public function __construct(int $id = null, string $username = null, string $password = null,
     string $salt = null, string $apitocken = null, string $email = null, string $privateAccount = null, int $idRole = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->apitocken = $apitocken;
        $this->email = $email;
        $this->privateAccount = $privateAccount;
        $this->idRole = $idRole;
    }
}