<?php
namespace Entity\ManyToMany;
use Doctrine\ORM\Mapping as ORM;
//use Host\Backend\Universeorange\Com\User\Entity\Role;

trait Users {

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    protected $users;

    public function getUsers(){
        return $this->users->toArray();
    }
}
