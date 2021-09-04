<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait KeyId {

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $keyId;

    public function getKeyId()
    {
        return $this->keyId;
    }

    public function setKeyId($keyId)
    {
        $this->keyId = $keyId;
    }
}
