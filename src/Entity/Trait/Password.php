<?php
namespace LikeIt\Cms\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
trait Password {

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $test = password_get_info($password);
        if($test['algo'] === null){
            $password = $this->createPassword($password);
        }
        $this->password = $password;
    }

    public function createPassword($password='', $cost=13){
        return password_hash($password,PASSWORD_BCRYPT, ['cost' => $cost]);
    }
}
