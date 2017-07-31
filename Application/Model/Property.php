<?php
namespace Application\Model;

use Application\Core\BaseModel;

/**
 * Application/Model/User.php
 *
 * @Entity @Table(name="`users`")
 */
class Property extends BaseModel
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    private $property_id;
    /** @Column(type="string") * */
    private $address1;
    /** @Column(type="string") * */
    private $address2;
    /** @Column(type="integer") * */
    private $bedrooms;
    /** @Column(type="integer") * */
    private $bathrooms;
    /** @Column(type="integer") * */
    private $rent;
    /** @Column(type="integer") * */
    private $available;
    /** @Column(type="integer") * */
    private $active;
}