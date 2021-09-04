<?php

namespace LikeIt\Cms\Entity;

use Exception;
use R3m\Io\App;
use R3m\Io\Module\Database;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="extension")
 */
class Extension {
	use Trait\Id;
    use Trait\Name;
    use ManyToMany\Extension\Trait\Applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function toArray(){
        $array = [];
        $array['id'] = $this->getId();
        $array['name'] = $this->getName();
        $array['applications'] = $this->getApplications();
        return $array;
    }
}