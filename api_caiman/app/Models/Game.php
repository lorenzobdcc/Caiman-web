<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Game model
 */

namespace App\Models;

class Game
{

    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?string $imageName;
    public ?int $idConsole;
    public ?int $idFile;

    /**
     * contructor of a game
     *
     * @param integer $id
     * @param string $name
     * @param string $description
     * @param string $imageName
     * @param string $idConsole
     * @param string $idFile
     */
    public function __construct(
        int $id = null,
        string $name = null,
        string $description = null,
        string $imageName = null,
        int $idConsole = null,
        int $idFile = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageName = $imageName;
        $this->idConsole = $idConsole;
        $this->idFile = $idFile;
    }
}
