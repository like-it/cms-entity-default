<?php
namespace LikeIt\Cms\Entity\Unique;
use Doctrine\ORM\Mapping as ORM;
trait UserId {

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    protected $user_id;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
