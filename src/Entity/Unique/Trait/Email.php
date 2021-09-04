<?php
namespace LikeIt\Cms\Entity\Unique\Trait;
use Doctrine\ORM\Mapping as ORM;
trait Email {

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
