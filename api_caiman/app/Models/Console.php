<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Console model
 */

namespace App\Models;

class Console
{

    public ?int $id;
    public ?string $name;
    public ?string $folderName;
    public ?int $idEmulator;


/**
 * Constructor of the category model object.
 *
 * @param integer $id
 * @param string $name
 * @param string $folderName
 * @param integer $idEmulator
 */
    public function __construct(int $id = null, string $name = null, string $folderName = null, int $idEmulator = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->folderName = $folderName;
        $this->idEmulator = $idEmulator;
    }
}
