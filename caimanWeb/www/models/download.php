<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle the download of Caiman
 */
class Download
{

    /**
     * used to download caiman
     *
     * @return void
     */
    public function downloadCaiman()
    {

        $zipFile = "../release/Caiman.zip";

        $file_name = basename($zipFile);

        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Length: " . filesize($zipFile));

        readfile($zipFile);
        exit;
    }
}
