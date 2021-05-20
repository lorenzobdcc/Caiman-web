<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request for the table categorie
 */
class Categories
{

    private $dbh = null;

    private $psGetAllCategories = null;

    private $psGameCategorie = null;

    private $psAddCategorieToGame = null;

    private $psCheckIfGameHasCategorie = null;

    private $psDelCategorieFromGame = null;




    /**
     * default constructor
     */
    public function __construct()
    {
        if ($this->dbh == null) {
            try {
                $this->dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USER, PASSWORD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_PERSISTENT => true
                ));
                //get all categories
                $sqlGetAllCategories = "SELECT * FROM categorie";
                $this->psGetAllCategories = $this->dbh->prepare($sqlGetAllCategories);
                $this->psGetAllCategories->setFetchMode(PDO::FETCH_ASSOC);

                //add categorie
                $sqlAddCategorie = "INSERT INTO categorie (name) VALUES (:categorie_name)";
                $this->psAddCategorie = $this->dbh->prepare($sqlAddCategorie);
                $this->psAddCategorie->setFetchMode(PDO::FETCH_ASSOC);

                //add categorie to game
                $sqlAddCategorieToGame = "INSERT INTO gamehascategorie (idGame,idCategorie) VALUES (:insert_idGame, :insert_idCategorie)";
                $this->psAddCategorieToGame = $this->dbh->prepare($sqlAddCategorieToGame);

                //check if game has a specific categorie
                $sqlCheckIfGameHasCategorie = "SELECT * FROM gamehascategorie WHERE idCategorie = :insert_idCategorie AND idGame = :insert_idGame";
                $this->psCheckIfGameHasCategorie = $this->dbh->prepare($sqlCheckIfGameHasCategorie);
                $this->psCheckIfGameHasCategorie->setFetchMode(PDO::FETCH_ASSOC);

                //del categorie from game
                $sqlDelCategorieFromGame = "DELETE FROM gamehascategorie  WHERE idCategorie = :del_idCategorie AND idGame = :del_idGame";
                $this->psDelCategorieFromGame = $this->dbh->prepare($sqlDelCategorieFromGame);

                //get categories of a game
                $sqlGameCategorie = "SELECT c.name, c.id FROM `gamehascategorie` as ghc
                LEFT JOIN categorie as c
                ON ghc.idCategorie = c.id
                LEFT JOIN game as g
                ON ghc.idGame = g.id
                WHERE idGame = :search_id";
                $this->psGameCategorie = $this->dbh->prepare($sqlGameCategorie);
                $this->psGameCategorie->setFetchMode(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }

    /**
     * returns list of all categories
     *
     * @return array with all list
     */
    public function getListAllCategories()
    {

        try {
            $this->psGetAllCategories->execute();
            $result = $this->psGetAllCategories->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    /**
     * get the categories of a game
     *
     * @param integer $idGame
     * @return list of categories
     */
    public function getCategoriesOfGame(int $idGame)
    {
        try {
            $this->psGameCategorie->execute(array(':search_id' => $idGame));
            $result = $this->psGameCategorie->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }

    /**
     * add a new categorie in the database
     *
     * @param string $categorieName
     * @return html
     */
    public function addCategorie(string $categorieName)
    {
        try {
            $this->psAddCategorie->execute(array(':categorie_name' => $categorieName));
            $result = $this->psAddCategorie->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        return $result;
    }
    
    /**
     * add a categorie to a game
     *
     * @param integer $idGame
     * @param integer $idCategorie
     * @return void
     */
    public function addCategorieToGame(int $idGame, int $idCategorie)
    {
        $result = null;
        try {
            $this->psCheckIfGameHasCategorie->execute(array(':insert_idCategorie' => $idCategorie, ':insert_idGame' => $idGame));
            $result = $this->psCheckIfGameHasCategorie->fetchAll();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
        if ($result == null) {
            try {
                $this->psAddCategorieToGame->execute(array(':insert_idCategorie' => $idCategorie, ':insert_idGame' => $idGame));
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br>";
                die();
            }
        }
    }
    /**
     * delete a cotegorie of a game
     *
     * @param integer $idGame
     * @param integer $idCategorie
     * @return void
     */
    public function delCategorieFromGame(int $idGame, int $idCategorie)
    {
        try {
            $this->psDelCategorieFromGame->execute(array(':del_idCategorie' => $idCategorie, ':del_idGame' => $idGame));
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br>";
            die();
        }
    }
}
