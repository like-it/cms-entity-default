<?php
namespace LikeIt\Cms\Entity\Unique\Trait;
use Doctrine\ORM\Mapping as ORM;
trait Name {

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
