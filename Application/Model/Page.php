<?php
namespace Application\Model;

use Application\Core\BaseModel;

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

    public function setupNew()
    {
        $this->setContent("");
        $this->setSlug("");
        $this->setTitle("");
        $this->setDate(date("YmdHis"));
        return $this;
    }



}