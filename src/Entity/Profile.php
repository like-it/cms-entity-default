<?php

namespace LikeIt\Cms\Entity;

use Exception;
use R3m\Io\App;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="profile")
 */
class Profile {

    use Trait\Id;
    use Trait\Firstname;
    use Trait\Surname;
    use OneToOne\Trait\User;

    public function __construct(){
    }

    /*
	public static function create(App $object, $options=[]){
        $entityManager = Mysql::entityManager($object, $options);
        $role = new Role();
        $role->setName(strtoupper($object->request('name')));
        $entityManager->persist($role);
        $entityManager->flush();
    }

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