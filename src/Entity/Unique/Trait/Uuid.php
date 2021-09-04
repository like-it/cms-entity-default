<?php
namespace Entity\Unique;
use R3m\Io\Module\Core;
use Doctrine\ORM\Mapping as ORM;

trait UuId {

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $uuid;

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    public function createUuid(){
        $this->setUuid(Core::uuid());
        return $this->getUuid();
    }
}
