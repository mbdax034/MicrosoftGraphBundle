<?php 

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
     * Undocumented variable
     *
     * @var token
     */
     protected $token;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array(), AccessToken $token)
    {
        $this->response = $response;
        $this->token = $token;
    }
    /**
     * Image url
     *
     * @var string
     */
    protected $imageurl;
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
        return $this->response['emails']['preferred'] ?: null;
    }
    /**
     * Get user firstname
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->response['first_name'] ?: null;
    }
    /**
     * Get user imageurl
     *
     * @return string|null
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }
    /**
     * Set user imageurl
     *
     * @return string|null
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;
        return $this;
    }
    /**
     * Get user lastname
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->response['last_name'] ?: null;
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
     * Get user urls
     *
     * @return string|null
     */
    public function getUrls()
    {
        return isset($this->response['link']) ? $this->response['link'].'/cid-'.$this->getId() : null;
    }



    public function  getToken(){

        return $this->token;
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