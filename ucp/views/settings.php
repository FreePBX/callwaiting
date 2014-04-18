<div class="message alert" style="display:none;"></div>
<form role="form">
	<label>
		<?php echo _('Enable')?>
		<div class="onoffswitch">
			<input type="checkbox" name="cwenable" class="onoffswitch-checkbox" id="cwenable" <?php echo ($enabled) ? 'checked' : ''?>>
			<label class="onoffswitch-label" for="cwenable">
				<div class="onoffswitch-inner"></div>
				<div class="onoffswitch-switch"></div>
			</label>
		</div>
	</label>
</form>
