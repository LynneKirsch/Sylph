<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/User.php
 *
 * @Entity @Table(name="`users`")
 */
class User extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $user_id;
    /** @Column(type="string") * */
    private $username;
    /** @Column(type="string") * */
    private $password;


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }



}