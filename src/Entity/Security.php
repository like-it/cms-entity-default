<?php

namespace LikeIt\Cms\Entity;

use R3m\Io\App;

class Security {

    public static function is_granted(App $object, $options=[]) : bool
    {
        if(!array_key_exists('user', $options)) {
            return false;
        }
        if(empty($options['user'])){
            return false;
        }
        if(!array_key_exists('uuid', $options['user'])) {
            return false;
        }
        if(!array_key_exists('role', $options)) {
            return false;
        }
        if(empty($options['role'])){
            return false;
        }
        if(is_string($options['role'])){
            $options['role'] = [ $options['role'] ];
        }
        $user = User::find($object, ['uuid' => $options['user']['uuid']]);
        if(!$user){
            return false;
        }
        if(!$user->getIsActive()){
            return false;
        }
        if($user->getIsDeleted()){
            return false;
        }
        $roles = $user->getRoles();
        foreach($options['role'] as $has_role){
            foreach($roles as $role){
                if($role->getName() === $has_role){
                    return true;
                }
            }
        }
        return false;
    }
}