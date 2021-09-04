<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait DateTime {

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateTime;

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }
}
