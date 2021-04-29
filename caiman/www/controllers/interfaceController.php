<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief interface used to implement function to display the html and the handle the requested content
 */
interface iController
{
    public function formHandler();
    public function printHTML();
}
