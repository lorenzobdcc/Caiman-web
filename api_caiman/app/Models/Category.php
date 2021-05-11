<?php
/**
 * Dog.php
 *
 * Dog model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */
namespace App\Models;

class Category {

    public ?int $id;
    public ?string $name;


    /**
     * 
     * Constructor of the Dog model object.
     * 
     * @param int $id The dog identifier
     * @param string $name The name of the dog

     */
    public function __construct(int $id = null, string $name = null)
    {
        $this->id = $id;
        $this->name = $name;

    }
}