<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Timer model
 */

namespace App\Models;

class timer
{
    public ?int $minutes;


    /**
     * Contstructor of the timer model
     *
     * @param integer $minutes
     */
    public function __construct(int $minutes = null)
    {
        $this->minutes = $minutes;
    }
}
