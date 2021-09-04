<?php
namespace LikeIt\Cms\Entity\ManyToMany\Parameter\Trait;
use Doctrine\ORM\Mapping as ORM;
//use Host\Backend\Universeorange\Com\User\Entity\Parameter;
use LikeIt\Cms\Entity\User;

trait Users {

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="parameters")
     */
    protected $users;

    public function getUsers(){
        return $this->users->toArray();
    }

    public function addUser(User $user=null){
        if($user !== null){
            $this->users->add($user);
        }
    }

    public function hasUser(User $user){
        if($this->users->contains($user)){
            return true;
        }
        return false;
    }

    public function deleteUser(User $user){
        $index = $this->users->indexOf($user);
        $this->users->remove($index);
    }

    public function deleteUsers(){
        $users = $this->getUsers();
        foreach ($users as $user) {
            $this->deleteUser($user);
        }
    }
}
