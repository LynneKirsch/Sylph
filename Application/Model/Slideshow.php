<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/User.php
 *
 * @Entity @Table(name="`slideshow`")
 */
class Slideshow extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $slideshow_id;
    /** @Column(type="string", nullable=true) * */
    private $json;

    /**
     * @return mixed
     */
    public function getSlideshowId()
    {
        return $this->slideshow_id;
    }

    /**
     * @param mixed $slideshow_id
     */
    public function setSlideshowId($slideshow_id)
    {
        $this->slideshow_id = $slideshow_id;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json)
    {
        $this->json = $json;
    }

    public function getSlideArray()
    {
        return json_decode($this->json);
    }

}