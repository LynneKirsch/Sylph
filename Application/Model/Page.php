<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/Page.php
 *
 * @Entity @Table(name="`pages`")
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


}