<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait Name {

    /**
     * @ORM\Column(type="string")
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
