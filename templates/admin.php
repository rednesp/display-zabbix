<div class="wrap">
    <h1>Display Zabbix graphs</h1>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php 
			settings_fields( 'display_zabbix_group' );
			do_settings_sections( 'display_zabbix_plugin' );
			submit_button();
		?>
	</form>
</div>