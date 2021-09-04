<?php
namespace Entity\OneToOne;
use Doctrine\ORM\Mapping as ORM;
//use Entity\Profile as Entity;

trait User {

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    public function getUser(){
        return $this->user;
    }

    public function setUser($user){
        $this->user = $user;
    }

}
