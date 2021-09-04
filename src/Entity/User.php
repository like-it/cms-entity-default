<?php

namespace LikeIt\Cms\Entity;

use dateTime;
use R3m\Io\Module\Parse;
use stdClass;

use R3m\Io\App;
use R3m\Io\Module\Database;
use R3m\Io\Module\Core;

#use Host\Backend\Universeorange\Com\Jwt\Model\Jwt;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\LocalFileReference;
use Lcobucci\JWT\Signer\Key\InMemory;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Exception;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use R3m\Io\Exception\ObjectException;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {

    const ARRAY_TYPE_ALL = 'all';
    const ARRAY_TYPE_SESSION = 'session';
    const BLOCK_EMAIL_COUNT = 5;
    const BLOCK_PASSWORD_COUNT = 5;

    const ROLE_IS_ADMIN = 'ROLE_IS_ADMIN';

    const QUERY_FIND_ID = 'SELECT u
        FROM ' . __CLASS__ . ' u 
        WHERE u.id like :id 
        AND u.isActive = 1 
        AND u.isDeleted IS NULL';

    const QUERY_FIND_UUID = 'SELECT u
        FROM ' . __CLASS__ . ' u 
        WHERE u.uuid like :uuid 
        AND u.isActive = 1 
        AND u.isDeleted IS NULL';

    const QUERY_FIND_EMAIL = 'SELECT u
        FROM ' . __CLASS__ . ' u 
        WHERE u.email like :email 
        AND u.isActive = 1 
        AND u.isDeleted IS NULL';

    use Id;
    use Unique\Uuid;
    use Unique\Email;
    use Unique\Dir;
    use Password;
    use RefreshToken;
    use KeyId;
    use IsActive;
    use IsDeleted;

    use OneToOne\Profile;
    use ManyToMany\Parameters;
    use ManyToMany\Roles;
    use ManyToMany\Applications;

    public function __construct(){
        $this->parameters = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function toArray(App $object=null, Parse $parse=null): array
    {
        $array = [];
        $array['id'] = $this->getId();
        $array['uuid'] = $this->getUuid();
        $array['dir'] = $this->getDir();
        if($parse){
            $array['dir'] = $parse->compile($array['dir'], $object->data());
        }
        $array['email'] = $this->getEmail();
        $array['password'] = $this->getPassword();
        $array['refreshToken'] = $this->getRefreshToken();
        $array['keyId'] = $this->getKeyId();
        $array['isActive'] = $this->getIsActive();
        $array['isDeleted'] = $this->getIsDeleted();
        $profile = $this->getProfile();
        if($profile){
            $array['profile']['firstname'] = $profile->getFirstname();
            $array['profile']['surname'] = $profile->getSurname();
        }
        $array['role'] = [];
        $roles = $this->getRoles();
        foreach($roles as $role){
            $array['role'][] = $role->getName();
        }
        $array['parameter'] = [];
        $parameters = $this->getParameters();
        foreach($parameters as $parameter){
            $array['parameter'][] = $parameter->getId();
        }
        return $array;
    }

    public static function find(App $object, $options=[]){
        if(array_key_exists('uuid', $options)){
            $entityManager = Database::entityManager($object, $options);
            return $entityManager->createQuery(User::QUERY_FIND_UUID)
                ->setParameter('uuid', $options['uuid'])
                ->getOneOrNullResult();
        }
        elseif(array_key_exists('id', $options)){
            $entityManager = Database::entityManager($object, $options);
            return $entityManager->createQuery(User::QUERY_FIND_ID)
                ->setParameter('id', $options['id'])
                ->getOneOrNullResult();
        }
        elseif(array_key_exists('email', $options)){
            $entityManager = Database::entityManager($object, $options);
            return $entityManager->createQuery(User::QUERY_FIND_EMAIL)
                ->setParameter('email', $options['email'])
                ->getOneOrNullResult();
        }
    }

    public static function password_forgot(App $object, $options=[]){
        $email = $object->request('email');
        /**
         * if email exists and user isActive & !isDeleted then send a recovery email.
         */
    }

    public static function login(App $object, $options=[]){
        $password = $object->request('password');
        $user = User::find($object, ['email' => $object->request('email')]);
        if($user){
            $verify = password_verify($password, $user->getPassword());
            if(empty($verify)){
                User::logger($object, $user, Logger::STATUS_INVALID_PASSWORD);
                return $verify;
            }
            User::logger($object, $user, Logger::STATUS_SUCCESS);
            return $user;
        } else {
            User::logger($object, null,Logger::STATUS_INVALID_EMAIL);
            return false;
        }
    }

    /*
    public static function logout(App $object, $options=[]){
        $object->session('delete', 'user');
        return true;
    }
    */

    public static function logger(App $object, User $user=null, $status=null){
        $options = [];
        $entityManager = Database::entityManager($object, $options);
        $logger = new Logger();
        if(array_key_exists('REMOTE_ADDR', $_SERVER)){
            $logger->setIpAddress($_SERVER['REMOTE_ADDR']);
        } else {
            $logger->setIpAddress('0.0.0.0');
        }
        $logger->setDateTime(new dateTime());
        if(
            $user !== null &&
            get_class($user) == __CLASS__
        ){
            $logger->setUserid($user->getId());
        }
        $logger->setStatus($status);
        try {
            $entityManager->persist($logger);
            $entityManager->flush();
        } catch (ORMException | OptimisticLockException $exception) {
            return $exception->getMessage();
        }
    }

    public static function is_blocked(App $object, $options=[]){
        $user = User::find($object, [ 'email' => $object->request('email')]);
        if($user){
            $count = Logger::count($object, $user, Logger::STATUS_INVALID_PASSWORD);
            if($count >= User::BLOCK_PASSWORD_COUNT){
                User::logger($object, $user, Logger::STATUS_BLOCKED);
                return true;
            }
        } else {
            $count = Logger::count($object, null, Logger::STATUS_INVALID_EMAIL);
            if($count >= User::BLOCK_EMAIL_COUNT){
                User::logger($object, $user, Logger::STATUS_BLOCKED);
                return true;
            }
        }
        return false;

    }

    /*
    public static function addRefreshToken(App $object, $user=[]){
        return $user;   
        $options = [];
        $configuration = Jwt::configuration($object, ["refresh" => true]);
        $refresh = Jwt::refresh_get($object, $configuration, $options);
        $user['refresh']['token'] = $refresh->toString();

        $refreshToken = sha1($refresh->toString());
        $cost = 13;
        try {
            $refreshToken = password_hash($refreshToken, PASSWORD_BCRYPT, [
                'cost' => $cost
            ]);
        } catch (Exception | ErrorException $exception){
            return $exception;
        }
        $find = User::find($object, [ 'uuid' => $user['uuid'] ]);
        if($find){
            $find->setRefreshToken($refreshToken);
            $config = [];
            $entityManager = Database::entityManager($object, $config);
            try {
                $entityManager->merge($find);
                $entityManager->flush();
            } catch (ORMException | OptimisticLockException $exception) {
                return $exception;
            }
        }
        return $user;
    }
    */

    public static function expose(App $object, $options=[]){
        if(!array_key_exists('user', $options)){
            return;
        }
        if(!array_key_exists('response', $options)){
            return;
        }
        $user = $options['user'];
        $class = get_class($user);
        if($class !== __CLASS__){
            return;
        }
        $array = [];
        $array['user'] = $user->toArray($object, new Parse($object));
        unset($array['parameter']);
        $configuration = Jwt::configuration($object);
        $token = Jwt::get($object, $configuration, $options);
        unset($array['user']['password']);
        unset($array['user']['refreshToken']);
        $array['user']['token'] = $token->toString();
        $configuration = Jwt::configuration($object, ["refresh" => true]);
        $refresh = Jwt::refresh_get($object, $configuration, $options);
        $array['user']['refresh']['token'] = $refresh->toString();
        if(empty($array['user']['keyId'])){
            $array['user']['keyId'] = Jwt::createKeyId($object);
        }
        $refreshToken = sha1($refresh->toString());
        $cost = 13;
        try {
            $refreshToken = password_hash($refreshToken, PASSWORD_BCRYPT, [
                'cost' => $cost
            ]);
        } catch (Exception | ErrorException $exception){
            return $exception;
        }
        $user = User::find($object, [ 'uuid' => $user->getUuid() ]);
        if($user){
            $user->setRefreshToken($refreshToken);
            $user->setKeyId($array['user']['keyId']);
            $config = [];
            $entityManager = Database::entityManager($object, $config);
            try {
                $entityManager->merge($user);
                $entityManager->flush();
            } catch (ORMException | OptimisticLockException $exception) {
                return $exception;
            }
        }
        switch($options['response']){
            case 'array' :
                return $array;
            case 'object' :
                return Core::object($array['user'], Core::OBJECT_OBJECT);
            case 'json' :
                try {
                    return Core::object($array, Core::OBJECT_JSON);} catch (ObjectException $e) {
                    return $e;
                }
        }
    }
}