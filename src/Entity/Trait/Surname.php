<?php
namespace Entity;
use Doctrine\ORM\Mapping as ORM;
trait Surname {

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
}
