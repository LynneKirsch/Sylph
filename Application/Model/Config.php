<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/Config.php
 *
 * @Entity @Table(name="`config`")
 */
class Config extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $config_id;
    /** @Column(type="string") * */
    private $config_code;
    /** @Column(type="string") * */
    private $config_val;

    /**
     * @return mixed
     */
    public function getConfigId()
    {
        return $this->config_id;
    }

    /**
     * @param mixed $config_id
     */
    public function setConfigId($config_id)
    {
        $this->config_id = $config_id;
    }

    /**
     * @return mixed
     */
    public function getConfigCode()
    {
        return $this->config_code;
    }

    /**
     * @param mixed $config_code
     */
    public function setConfigCode($config_code)
    {
        $this->config_code = $config_code;
    }

    /**
     * @return mixed
     */
    public function getConfigVal()
    {
        return $this->config_val;
    }

    /**
     * @param mixed $config_val
     */
    public function setConfigVal($config_val)
    {
        $this->config_val = $config_val;
    }


}