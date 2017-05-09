<?php 

/**
 * @author Abdellah Rabh
 * @email abderabh@mail.com
 * @create date 2017-05-09 10:59:45
 * @modify date 2017-05-09 10:59:45
 * @desc [description]
*/

namespace Mbdax\MicrosoftGraphBundle\DependencyInjection;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\token;


class MicrosoftGraphResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected $response;


   

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response, $resourceOwnerId)
    {
        $this->response = $response;
       
    }
    

    /**
     * Get user id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->response['id'] ?: null;
    }
    /**
     * Get user email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->response['mail'] ?: null;
    }
    /**
     * Get user firstname
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->response['givenName'] ?: null;
    }
    
    /**
     * Get user lastname
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->response['surname'] ?: null;
    }
    /**
     * Get user name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->response['name'] ?: null;
    }
    


    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}