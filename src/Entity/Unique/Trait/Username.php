<?php
namespace LikeIt\Cms\Entity\Unique;
use Doctrine\ORM\Mapping as ORM;
trait Username {

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $username;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
}
