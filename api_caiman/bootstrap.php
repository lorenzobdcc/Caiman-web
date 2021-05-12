<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Bootable file of the API.
 */
require 'vendor/autoload.php';
use Dotenv\Dotenv;
use App\System\DatabaseConnector;



// Loads the environment variables from the .env file
$dotenv = new DotEnv(__DIR__);
$dotenv->load();


$dbConnection = (new DatabaseConnector())->getConnection();














