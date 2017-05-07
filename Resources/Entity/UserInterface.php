<?php

namespace Mbdax\MicrosoftGraphBundle\Entity;


/**
 * Base token interface for any OAuth version.
 */
interface UserInterface {


    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @return int
     */
    public function getEndOfLife();
    

    /**
     * @return array
     */
    public function getExtraParams();

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken);

    /**
     * @param int $endOfLife
     */
    public function setEndOfLife($endOfLife);

    
    /**
     * @param array $extraParams
     */
    public function setExtraParams(array $extraParams);

    /**
     * @return string
     */
    public function getRefreshToken();

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken);
    
    /**
     * @return bool
     */
	public function isExpired();
   
}