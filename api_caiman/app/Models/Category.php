<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Category model
 */

namespace App\Models;

class Category
{

    public ?int $id;
    public ?string $name;


    /**
     * 
     * Constructor of the category model object.
     * 
     * @param int $id The category identifier
     * @param string $name The name of the category

     */
    public function __construct(int $id = null, string $name = null)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
