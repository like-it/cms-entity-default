<?php
namespace Entity;
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
