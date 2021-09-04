<?php
namespace LikeIt\Cms\Entity\OneToOne\Trait;
use Doctrine\ORM\Mapping as ORM;
use LikeIt\Cms\Entity\Profile as Entity;

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
