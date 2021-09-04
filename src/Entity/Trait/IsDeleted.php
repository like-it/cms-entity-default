<?php
namespace LikeIt\Cms\Entity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait IsDeleted {

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $isDeleted;

    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(DateTime $isDeleted=null)
    {
        $this->isDeleted = $isDeleted;
    }
}
