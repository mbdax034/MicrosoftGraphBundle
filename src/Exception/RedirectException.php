<?php




namespace Mbdax\MicrosoftGraphBundle\Exception;

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-10 01:24:04
 * @modify date 2017-05-10 01:24:04
 * @desc RedirectException 
*/
class RedirectException extends \Exception
{
    private $redirectResponse;

    public function __construct(
        RedirectResponse $redirectResponse,
        $message = '',
        $code = 0,
        \Exception $previousException = null
    ) {
        $this->redirectResponse = $redirectResponse;
        parent::__construct($message, $code, $previousException);
    }

    public function getRedirectResponse()
    {
        return $this->redirectResponse;
    }
}