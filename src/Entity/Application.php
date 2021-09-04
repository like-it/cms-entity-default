<?php

namespace LikeIt\Cms\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use R3m\Io\App;
use R3m\Io\Module\Database;
use Doctrine\ORM\Mapping as ORM;
use LikeIt\Cms\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="application")
 */
class Application {
    const QUERY_FIND_ID = 'SELECT r
        FROM ' . __CLASS__ . ' r 
        WHERE r.id like :id';

    const QUERY_FIND_NAME = 'SELECT r
        FROM ' . __CLASS__ . ' r 
        WHERE r.name like :name';

    use Trait\Id;
    use Unique\Trait\Uuid;
    use Trait\Name;
    use Trait\Url;
    use Trait\IconUrl;
    use ManyToMany\Application\Trait\Users;
    use ManyToMany\Application\Trait\Extensions;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->extensions = new ArrayCollection();
    }

    public function toArray(){
        $array = [];
        $array['id'] = $this->getId();
        $array['uuid'] = $this->getUuid();
        $array['name'] = $this->getName();
        $array['url'] = $this->getUrl();
        $array['icon_url'] = $this->getIconUrl();
        $array['users'] = [];
        $users = $this->getUsers();
        foreach($users as $user){
            $array['users'][] = $user->getUuid();
        }
        $array['extensions'] = [];
        $extensions = $this->getExtensions();
        foreach($extensions as $extension){
            $array['extensions'][] = $extension->getName();
        }
        return $array;
    }

    /*
    public static function list(App $object, $options=[]){
        $entityManager = Mysql::entityManager($object, $options);
        $repository = $entityManager->getRepository('Model\Role');
        $list = $repository->findAll();

        foreach ($list as $nr => $role) {
            echo $role->id . ' ' . $role->name . "\n";
        }
    }

    public static function read(App $object, $options=[]){
	    $id = (int) App::parameter($object, 'read', 1);
        $entityManager = Mysql::entityManager($object, $options);
        $record = $entityManager->find('Model\Role', $id);
        echo 'Id: ' . $record->getId() . "\n";
        echo 'Name: ' . $record->getName() . "\n";
    }

    public static function update(App $object, $options=[]){
        $id = (int) App::parameter($object, 'update', 1);
        $entityManager = Mysql::entityManager($object, $options);
        $role = $entityManager->find('Model\Role', $id);
        if($role){
            $role->setName(strtoupper($object->request('name')));
            $entityManager->flush();
        }
    }

    public static function delete(App $object, $options=[]){
        $id = (int) App::parameter($object, 'delete', 1);
        $entityManager = Mysql::entityManager($object, $options);
        $role = $entityManager->find('Model\Role', $id);
        if($role){
            $entityManager->remove($role);
            $entityManager->flush();
        }
    }
    */
}