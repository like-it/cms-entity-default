<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait IconUrl {

    /**
     * @ORM\Column(type="string")
     */
    protected $icon_url;

    public function getIconUrl()
    {
        return $this->icon_url;
    }

    public function setIconUrl($url)
    {
        $this->icon_url = $url;
    }
}
