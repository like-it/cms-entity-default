<?php
namespace LikeIt\Cms\Entity\Unique;
use Doctrine\ORM\Mapping as ORM;
trait Dir {

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $dir;

    public function getDir()
    {
        return $this->dir;
    }

    public function setDir($dir)
    {
        $this->dir = $dir;
    }
}
