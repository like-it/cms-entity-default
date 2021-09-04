<?php
namespace Entity\OneToOne;
use Doctrine\ORM\Mapping as ORM;
use Entity\Profile as Entity;

trait Profile {

    /**
     * @ORM\OneToOne(targetEntity="Profile", mappedBy="user")
     */
    protected $profile;

    public function setProfile(Entity $profile){
        $this->profile = $profile;
    }

    public function getProfile(){
        return $this->profile;
    }
}
