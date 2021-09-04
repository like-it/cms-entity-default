<?php
namespace LikeIt\Cms\Entity;
use Doctrine\ORM\Mapping as ORM;
trait Firstname {

    /**
     * @ORM\Column(type="string")
     */
    protected $firstname;

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
}
