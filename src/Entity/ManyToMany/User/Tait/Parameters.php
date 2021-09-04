<?php
namespace Entity\ManyToMany\User\Trait;
use Doctrine\ORM\Mapping as ORM;
use LikeIt\Cms\Entity\Parameter;

trait Parameters {

    /**
     *
     * @ORM\ManyToMany(targetEntity="Parameter", inversedBy="users", cascade={"persist"})
     */
    protected $parameters;

    public function getParameters(){
        return $this->parameters->toArray();
    }

    public function addParameter(Parameter $parameter){
        $this->parameters->add($parameter);
    }

    public function hasParameter($parameter){
        if($this->parameters->contains($parameter)){
            return true;
        }
        return false;
    }

    public function deleteParameter(Parameter $parameter){
        $index = $this->parameters->indexOf($parameter);
        $this->parameters->remove($index);
    }

    public function deleteParameters(){
        $parameters = $this->getParameters();
        foreach ($parameters as $parameter) {
            $this->deleteParameter($parameter);
        }
    }
}
