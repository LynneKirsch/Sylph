<?php
namespace Application\Model;

use Application\Core\BaseModel;
use Application\Core\EntityInterface;
use Application\Core\MustacheInterface;

/**
 * Application/Model/Page.php
 *
 * @Entity
 * @Table(name="`pages`")
 */
class Page extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $page_id;
    /** @Column(type="string") * */
    private $slug;
    /** @Column(type="string") * */
    private $title;
    /** @Column(type="text") * */
    private $content;
    /** @Column(type="text") * */
    private $delta;
    /** @Column(type="integer") * */
    private $type;
    /** @Column(type="text") */
    private $date;
    /** @Column(type="text", nullable=true) */
    private $slideshow_id;

    /**
     * @return mixed
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param mixed $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * @param mixed $page_id
     */
    public function setPageId($page_id)
    {
        $this->page_id = $page_id;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

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

    public function getFormattedDate()
    {
        // dates are YYYYMMDDHHIISS | YmdHis
        $year = substr($this->date, 0, 4);
        $month = substr($this->date, 4, 2);
        $day = substr($this->date, 6, 2);
        $hours = substr($this->date, 8, 2);
        $minutes = substr($this->date, 10, 2);
        $time = date("g:i A", strtotime($hours . ":" . $minutes));

        return [
            "month" => $month,
            "day" => $day,
            "year" => $year,
            "time" => $time
        ];
    }

    public function setupNew($type)
    {
        $this->setContent("");
        $this->setSlug("");
        $this->setTitle("");
        $this->setDate(date("YmdHis"));
        $this->setDelta("");
        $this->setType($type);
        return $this;
    }

    public function isHomePage()
    {
        if($this->getPageId() == EntityInterface::getConfig("homepage")) {
            return true;
        } else {
            return false;
        }
    }

    public function parsePageContent()
    {
        $content = html_entity_decode($this->getContent(), ENT_QUOTES);
        preg_match_all('/%(.*?)\%/s', $content, $matches);

        foreach($matches[1] as $match) {
            $match_array = explode(".", $match);

            switch($match_array[0]) {
                CASE "config":
                    $config = EntityInterface::getConfig($match_array[1]);
                    if($config) {
                        $content = str_replace("%".$match_array[0].".".$match_array[1]."%", $config->getConfigVal(), $content);
                    }
                    break;
                CASE "slideshow":
                    if($this->getSlideshowId()) {
                        $slideshow = EntityInterface::getSlide($this->getSlideshowId());
                        $html = MustacheInterface::render("partials/slideshow", ["slides" => $slideshow->getSlideArray()]);
                        $content = str_replace("%slideshow%", $html, $content);
                    }
                    break;
            }
        }

        return $content;
    }

    public function getSlideShow()
    {
        if($this->getSlideshowId()) {
            $em = EntityInterface::create();
            $slideshow = $em->getRepository(MODEL_NS."Slideshow")->findOneBy(["slideshow_id" => $this->getSlideshowId()]);

            if($slideshow) {
                return $slideshow;
            }
        }

        return null;
    }

    public function renderSlideShow()
    {

    }



}