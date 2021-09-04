<?php
namespace LikeIt\Cms\Entity;
use Doctrine\ORM\Mapping as ORM;
trait IsActive {

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive)
    {
        if($isActive === 'true'){
            $isActive = 1;
        }
        elseif($isActive === 'false'){
            $isActive = 0;
        }
        $this->isActive = $isActive;
    }
}
