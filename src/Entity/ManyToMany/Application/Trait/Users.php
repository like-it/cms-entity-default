<?php
namespace Entity\ManyToMany\Application;
use Doctrine\ORM\Mapping as ORM;
use Entity\Application;
use Entity\User;
trait Users {

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="applications")
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
