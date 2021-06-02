<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief File model
 */

namespace App\Models;

class File
{
    public ?int $id;
    public ?string $filename;
    public ?string $date;


    /**
     * Contstructor of the file model
     *
     * @param integer $id
     * @param string $name
     * @param string $filename
     * @param string $date
     */
    public function __construct(int $id = null, string $name = null, string $filename = null, string $date = null)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->date = $date;
    }
}
