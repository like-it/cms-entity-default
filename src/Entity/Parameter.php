<?php

namespace LikeIt\Cms\Entity;

use Exception;
use R3m\Io\App;
use R3m\Io\Module\Database;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="parameter")
 */
class Parameter {
	use Id;
    use Name;
    use Encrypted\Body;
    use ManyToMany\Parameter\Users;

    protected $object;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function toArray(){
        $array = [];
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $this->decrypt($this->getObject());
        $array['body'] = $this->getBody();
        $array['users'] = [];
        $users = $this->getUsers();
        foreach($users as $user){
            $array['users'][] = $user->getId();
        }
        return $array;
    }

    public function setObject(App $object){
        $this->object = $object;
    }

    public function getObject(){
        return $this->object;
    }

}