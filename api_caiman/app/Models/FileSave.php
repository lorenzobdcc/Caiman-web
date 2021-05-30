<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief File model
 */

namespace App\Models;

class FileSave
{
    public ?int $id;
    public ?int $idUser;
    public ?int $idEmulator;
    public ?int $idFile;


/**
 * Contstructor of the file model
 *
 * @param integer $id
 * @param string $name
 * @param string $filename
 * @param string $date
 */
    public function __construct(int $id = null, int $idUser = null, int $idEmulator = null, int $idFile = null)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idEmulator = $idEmulator;
        $this->idFile = $idFile;
    }
}
