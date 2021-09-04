<?php
namespace LikeIt\Cms\Entity\ManyToMany\Trait;
use Doctrine\ORM\Mapping as ORM;
use LikeIt\Cms\Entity\Role;

trait Roles {

    /**
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade={"persist"})
     */
    protected $roles;

    public function getRoles(){
        return $this->roles->toArray();
    }

    public function addRole(Role $role){
        $this->roles->add($role);
    }

    public function hasRole(Role $role){
        if($this->roles->contains($role)){
            return true;
        }
        return false;
    }

    public function deleteRole(Role $role){
        $index = $this->roles->indexOf($role);
        $this->roles->remove($index);
    }

    public function deleteRoles(){
        $roles = $this->getRoles();
        foreach ($roles as $role) {
            $this->deleteRole($role);
        }
    }
}
