
<div class="wrap">

	<?php screen_icon('options-general'); ?> <h2><?php echo _e('Plugin Licensing'); ?></h2><br />

	<?php if ($spbas->errors): ?>
		<div id="message" class="error">
			<p><b><?php echo $spbas->errors; ?></b></p>
		</div>
	<?php endif; ?>

	<?php if ($license_updated&&!$spbas->errors): ?>
		<div id="message" class="updated">
			<p><b><?php echo _e('Your license was activated successfully!'); ?></b></p>
		</div>
	<?php endif; ?>    

	<form method="post">
	<?php wp_nonce_field('wp_obs_license', 'wp_obs_license'); ?>

		<p class="howto"><?php echo _e('Please enter the license key that was e-mailed to you.'); ?></p>

		<p>
			<b><?php echo _e('Enter Your License Key:'); ?></b> <input name="wp_obs_license_key" type="text" value="<?php echo $spbas->license_key; ?>" /> <input type="submit" class="button-primary" value="<?php echo _e('Activate'); ?>" />
		</p>
	</form>
</div>