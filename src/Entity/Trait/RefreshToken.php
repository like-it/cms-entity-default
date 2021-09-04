<?php
namespace LikeIt\Cms\Entity;
use Doctrine\ORM\Mapping as ORM;
trait RefreshToken {

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $refreshToken;

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setRefreshToken($refreshToken=null)
    {
        $this->refreshToken = $refreshToken;
    }
}
