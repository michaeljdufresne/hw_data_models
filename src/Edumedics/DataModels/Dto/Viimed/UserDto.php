<?php


namespace Edumedics\DataModels\Dto\Viimed;

use Edumedics\DataModels\Dto\Dto;


/**
 * Class UserDto
 * @package Edumedics\DataModels\Dto\Viimed
 */
class UserDto extends Dto
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $personId;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $userName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $dob;

    /**
     * @var array
     */
    protected $fillable = [
        "id", "personId", "firstName", "lastName", "userName", "email", "dob"
    ];

    /**
     * @param null $dataArray
     * @return mixed|void
     */
    public function populate($dataArray = null) {}

}