<?php
/**
 * Dog.php
 *
 * Dog model.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */
namespace App\Models;

class Game {

    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?string $imageName;
    public ?string $idConsole;
    public ?string $idFile;

    /**
     * 
     * Constructor of the Dog model object.
     * 
     * @param int $id The dog identifier
     * @param string $name The name of the dog
     * @param string $breed The breed of the dog
     * @param string $sex The sex of the dog
     * @param string $picture_serial_id The picture serial id of the dog
     * @param string $chip_id The chip id of the dog
     * @param int $user_id The user id of the dog's owner
     */
    public function __construct(int $id = null, string $name = null, string $description = null,
     string $imageName = null, string $idConsole = null, string $idFile = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageName = $imageName;
        $this->idConsole = $idConsole;
        $this->idFile = $idFile;
    }
}