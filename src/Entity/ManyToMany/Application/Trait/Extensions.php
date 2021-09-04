<?php
namespace LikeIt\Cms\Entity\ManyToMany\Application;
use Doctrine\ORM\Mapping as ORM;
use Entity\Application;
use Entity\Extension;
trait Extensions {

    /**
     * @ORM\ManyToMany(targetEntity="Extension", mappedBy="applications")
     */
    protected $extensions;

    public function getExtensions(){
        return $this->extensions->toArray();
    }

    public function addExtension(Extension $extension=null){
        if($extension !== null){
            $this->extensions->add($extension);
        }
    }

    public function hasExtension(Extension $extension){
        if($this->extensions->contains($extension)){
            return true;
        }
        return false;
    }

    public function deleteExtension(Extension $extension){
        $index = $this->extensions->indexOf($extension);
        $extension->deleteApplication($this);
        $this->extensions->remove($index);
    }

    public function deleteExtensions(){
        $extensions = $this->getExtensions();
        foreach ($extensions as $extension) {
            $this->deleteExtension($extension);
        }
    }
}
