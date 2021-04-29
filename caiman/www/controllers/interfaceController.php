<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Auteur  : Lorenzo Bauduccio
 * Classe  : tech 2
 * Version : 1.0
 * Date    : 28.04.2021
 * description : Interaface servant a forcer les controller a ajouter la fonction permetant de gerer les formulaire et d'afficher le contenue de la page demandé
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
interface iController
{
    public function formHandler();
    public function printHTML();
}