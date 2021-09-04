<?php
namespace LikeIt\Cms\Entity\ManyToMany\Trait;
use Doctrine\ORM\Mapping as ORM;
use LikeIt\Cms\Entity\Application;

trait Applications {

    /**
     *
     * @ORM\ManyToMany(targetEntity="Application", inversedBy="users", cascade={"persist"})
     */
    protected $applications;

    public function getApplications(){
        return $this->applications->toArray();
    }

    public function addApplication(Application $application){
        $this->applications->add($application);
    }

    public function hasApplication(Application $application){
        if($this->applications->contains($application)){
            return true;
        }
        return false;
    }

    public function deleteApplication(Application $application){
        $index = $this->applications->indexOf($application);
        $this->applications->remove($index);
    }

    public function deleteApplications(){
        $applications = $this->getApplications();
        foreach ($applications as $application) {
            $this->deleteApplication($applications);
        }
    }
}
