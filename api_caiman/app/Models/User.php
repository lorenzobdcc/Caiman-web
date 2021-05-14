<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Category model
 */

namespace App\Models;

class User
{

    public ?int $id;
    public ?string $username;
    public ?string $password;
    public ?string $salt;
    public ?string $apitoken;
    public ?string $email;
    public ?int $privateAccount;
    public ?string $idRole;

    /**
     * 
     * Constructor of the User model object.
     * 
     */
    public function __construct(
        int $id = null,
        string $username = null,
        string $password = null,
        string $salt = null,
        string $apitoken = null,
        string $email = null,
        string $privateAccount = null,
        int $idRole = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->apitocken = $apitoken;
        $this->email = $email;
        $this->privateAccount = $privateAccount;
        $this->idRole = $idRole;
    }
}
