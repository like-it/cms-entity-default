<?php
namespace LikeIt\Cms\Entity\Encrypted;
use Exception;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Doctrine\ORM\Mapping as ORM;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use R3m\Io\App;
use R3m\Io\Module\Dir;
use R3m\Io\Module\File;
trait Body {

    /**
     * @ORM\Column(type="text")
     */
    protected $body;

    protected $is_body_decrypted = false;

    public function decrypt(App $object){
        $this->setObject($object);
        $this->getBody();
    }

    public function encrypt(App $object){
        $this->setObject($object);
    }

    public function getBody()
    {
        try {
            $object = $this->getObject();
            if(
                is_object($object) &&
                $this->is_body_decrypted === false
            ){
                $url = $object->config('project.dir.data') . 'Defuse/body.key';
                if(File::exist($url)){
                    $string = File::read($url);
                    $key = Key::loadFromAsciiSafeString($string);
                    $this->body = Crypto::decrypt($this->body, $key);
                    $this->is_body_decrypted = true;
                }
            }
        } catch (Exception | BadFormatException | EnvironmentIsBrokenException | WrongKeyOrModifiedCiphertextException $exception) {
            $this->is_body_decrypted = true;
        }
        return $this->body;
    }

    public function setBody($body)
    {
        $object = $this->getObject();
        if(is_object($object)){
            try {
                $url = $object->config('project.dir.data') . 'Defuse/body.key';
                if(File::exist($url)){
                    $string = File::read($url);
                    $key = Key::loadFromAsciiSafeString($string);
                } else {
                    $key = Key::createNewRandomKey();
                    $string = $key->saveToAsciiSafeString();
                    $dir = Dir::name($url);
                    Dir::create($dir, Dir::CHMOD);
                    File::write($url, $string);
                }
                $body = Crypto::encrypt($body, $key);
                $this->is_body_decrypted = false;
            } catch (Exception | BadFormatException | EnvironmentIsBrokenException $exception){
                $this->is_body_decrypted = true;
            }
        }
        $this->body = $body;
    }
}
