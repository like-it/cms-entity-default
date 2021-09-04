<?php
namespace LikeIt\Cms\Entity;
use Doctrine\ORM\Mapping as ORM;
trait Status {
    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
