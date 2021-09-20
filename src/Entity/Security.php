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
        dd($user);
        if(!$user){
            return false;
        }
        if(!$user->getIsActive()){
            return false;
        }
        if($user->getIsDeleted()){
            return false;
        }
        if($user){
            foreach($options['role'] as $role){
                $role = Role::find($object, ['name' => $role]);
                if($role){
                    if($user->hasRole($role)){
                        continue;
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
    }
}