<?php

namespace LikeIt\Cms\Entity;

use Exception;
use R3m\Io\App;
use Doctrine\ORM\Mapping as ORM;
use R3m\Io\Module\Database;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_logger")
 */
class Logger {
    const STATUS_BLOCKED = 'blocked';
    const STATUS_SUCCESS = 'success';
    const STATUS_INVALID_PASSWORD = 'invalid-password';
    const STATUS_INVALID_EMAIL = 'invalid-email';

    const LOGIN_PERIOD = '-15 Minutes';

    use Id;
    use IpAddress;
    use DateTime;
    use UserId;
    use Status;

    public static function count(App $object, User $user=null, $status=null){
        if(
            $user !== null &&
            get_class($user) == 'Host\Backend\Universeorange\Com\User\Entity\User'
        ){
            $options = [];
            $entityManager = Database::entityManager($object, $options);
            $user_id = $user->getId();
            $dateTime = date('Y-m-d H:i:s', strtotime(Logger::LOGIN_PERIOD));
            $query = 'SELECT l 
                FROM ' .
                __CLASS__ . ' l 
                WHERE l.user_id LIKE :user_id  AND 
                l.status = :status AND 
                l.dateTime >= :dateTime';

            $result = $entityManager->createQuery($query)
                ->setParameter('user_id', $user_id)
                ->setParameter('status', $status)
                ->setParameter('dateTime', $dateTime)
                ->getResult();
            return count($result);
        } else {
            $options = [];
            $entityManager = Database::entityManager($object, $options);
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $dateTime = date('Y-m-d H:i:s', strtotime(Logger::LOGIN_PERIOD));
            $query = 'SELECT l 
                FROM ' .
                __CLASS__ . ' l 
                WHERE l.user_id IS NULL AND
                l.ipAddress = :ipAddress AND 
                l.status = :status AND 
                l.dateTime >= :dateTime';

            $result = $entityManager->createQuery($query)
                ->setParameter('ipAddress', $ipAddress)
                ->setParameter('status', $status)
                ->setParameter('dateTime', $dateTime)
                ->getResult();
            return count($result);
        }

    }

}