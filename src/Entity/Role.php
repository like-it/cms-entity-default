<?php

namespace LikeIt\Cms\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use R3m\Io\App;
use R3m\Io\Module\Database;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role {
	const DEFAULT_PAGE = 'Welcome';

    const QUERY_FIND_ID = 'SELECT r
        FROM ' . __CLASS__ . ' r 
        WHERE r.id like :id';

    const QUERY_FIND_NAME = 'SELECT r
        FROM ' . __CLASS__ . ' r 
        WHERE r.name like :name';

    use Id;
    use Unique\Name;

    use ManyToMany\Users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function toArray(){
        $array = [];
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['users'] = [];
        $users = $this->getUsers();
        foreach($users as $user){
            $array['users'][] = $user->getId();
        }
        return $array;
    }

	public static function create(App $object, $options=[]){
        $entityManager = Mysql::entityManager($object, $options);
        $role = new Role();
        $role->setName(strtoupper($object->request('name')));
        $entityManager->persist($role);
        $entityManager->flush();
    }

    public static function find(App $object, $options=[]){
        if(array_key_exists('id', $options)){
            $entityManager = Database::entityManager($object, $options);
            return $entityManager->createQuery(Role::QUERY_FIND_ID)
                ->setParameter('id', $options['id'])
                ->getOneOrNullResult();
        }
        elseif(array_key_exists('name', $options)){
            $entityManager = Database::entityManager($object, $options);
            return $entityManager->createQuery(Role::QUERY_FIND_NAME)
                ->setParameter('name', strtoupper($options['name']))
                ->getOneOrNullResult();
        }
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