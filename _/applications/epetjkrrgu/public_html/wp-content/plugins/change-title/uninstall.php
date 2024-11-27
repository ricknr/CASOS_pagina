<?php
	if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
		die();

	// Remove os dados do banco
	delete_option( 'change_title' );
?>