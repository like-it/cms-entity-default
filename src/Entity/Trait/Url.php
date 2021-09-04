<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait Url {

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}
