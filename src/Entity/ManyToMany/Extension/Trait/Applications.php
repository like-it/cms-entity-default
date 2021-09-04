<?php
namespace Entity\ManyToMany\Extension;
use Doctrine\ORM\Mapping as ORM;

use Entity\Application;
use Entity\Extension;
trait Applications
{

    /**
     * @ORM\ManyToMany(targetEntity="Application", inversedBy="extensions")
     */
    protected $applications;

    public function getApplications(){
        return $this->applications->toArray();
    }

    public function addApplication(Application $application=null){
        if($application !== null){
            $this->applications->add($application);
        }
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
            $this->deleteApplication($application);
        }
    }
}