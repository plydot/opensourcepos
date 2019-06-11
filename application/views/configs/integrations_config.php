<?php echo form_open('config/save_integrations/', array('id' => 'integrations_config_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
	<div id="config_wrapper">
		<fieldset id="config_info">
			<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
			<ul id="integrations_error_message_box" class="error_message_box"></ul>


<!-- Mailchimp Integration -->
			<div id="integrations_header"><?php echo $this->lang->line('config_mailchimp_configuration')?></div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_mailchimp_api_key'), 'mailchimp_api_key', array('class' => 'control-label col-xs-2')); ?>
				<div class="col-xs-4">
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-cloud"></span></span>
						<?php echo form_input(array(
							'name' => 'mailchimp_api_key',
							'id' => 'mailchimp_api_key',
							'class' => 'form-control input-sm',
							'value' => $mailchimp['api_key'])); ?>
					</div>
				</div>
				<div class="col-xs-1">
					<label class="control-label">
						<a href="http://eepurl.com/b9a05b" target="_blank"><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="<?php echo $this->lang->line('config_mailchimp_tooltip'); ?>"></span></a>
					</label>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_mailchimp_lists'), 'mailchimp_list_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
						<?php echo form_dropdown('mailchimp_list_id',
							$mailchimp['lists'],
							$mailchimp['list_id'],
							array('id' => 'mailchimp_list_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

<!-- CLCdesq Integration -->				
			<div id="integrations_header"><?php echo $this->lang->line('config_clcdesq_configuration')?></div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_api_key'), 'clcdesq_api_key', array('class' => 'control-label col-xs-2')); ?>
				<div class="col-xs-4">
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-cloud"></span></span>
						<?php echo form_input(array(
							'name' => 'clcdesq_api_key',
							'id' => 'clcdesq_api_key',
							'class' => 'form-control input-sm',
							'value' => $clcdesq['api_key'])); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_api_url'), 'clcdesq_api_url', array('class' => 'control-label col-xs-2')); ?>
				<div class="col-xs-4">
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-cloud"></span></span>
						<?php echo form_input(array(
							'name' => 'clcdesq_api_url',
							'id' => 'clcdesq_api_url',
							'class' => 'form-control input-sm',
							'value' => $clcdesq['api_url'])); ?>
					</div>
				</div>
			</div>
			
			<div class="form-group form-group-sm"><?php echo form_label($this->lang->line('config_clcdesq_source'), 'clcdesq_clcdesqsource_id', array('class' => 'control-label col-xs-2','style' => 'text-decoration:underline;')); ?></div>			
			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_authorstext'), 'clcdesq_authorstext_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
						<?php echo form_dropdown('clcdesq_authorstext_id',
							$clcdesq['available_attributes'],
							$clcdesq['authorstext_attribute'],
							array('id' => 'clcdesq_authorstext_id', 'class' => 'form-control input-sm')); 
						?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_binding'), 'clcdesq_binding_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-book"></span></span>
						<?php echo form_dropdown('clcdesq_binding_id',
							$clcdesq['available_attributes'],
							$clcdesq['binding_attribute'],
							array('id' => 'clcdesq_binding_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_originaltitle'), 'clcdesq_originaltitle_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-text-size"></span></span>
						<?php echo form_dropdown('clcdesq_originaltitle_id',
							$clcdesq['available_attributes'],
							$clcdesq['originaltitle_attribute'],
							array('id' => 'clcdesq_originaltitle_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_publisher'), 'clcdesq_publisher_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-print"></span></span>
						<?php echo form_dropdown('clcdesq_publisher_id',
							$clcdesq['available_attributes'],
							$clcdesq['publisher_attribute'],
							array('id' => 'clcdesq_publisher_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_weight'), 'clcdesq_weight_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-scale"></span></span>
						<?php echo form_dropdown('clcdesq_weight_id',
							$clcdesq['available_attributes'],
							$clcdesq['weight_attribute'],
							array('id' => 'clcdesq_weight_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_width'), 'clcdesq_width_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-indent-right"></span></span>
						<?php echo form_dropdown('clcdesq_width_id',
							$clcdesq['available_attributes'],
							$clcdesq['width_attribute'],
							array('id' => 'clcdesq_width_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_depth'), 'clcdesq_depth_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-indent-right"></span></span>
						<?php echo form_dropdown('clcdesq_depth_id',
							$clcdesq['available_attributes'],
							$clcdesq['depth_attribute'],
							array('id' => 'clcdesq_depth_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<?php echo form_label($this->lang->line('config_clcdesq_height'), 'clcdesq_height_id', array('class' => 'control-label col-xs-2')); ?>
				<div class='col-xs-4'>
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-indent-right"></span></span>
						<?php echo form_dropdown('clcdesq_height_id',
							$clcdesq['available_attributes'],
							$clcdesq['height_attribute'],
							array('id' => 'clcdesq_height_id', 'class' => 'form-control input-sm')); ?>
					</div>
				</div>
			</div>

<!-- Submit Button -->				
			<?php 
				echo form_submit(array(
					'name' => 'submit_integrations',
					'id' => 'submit_integrations',
					'value' => $this->lang->line('common_submit'),
					'class' => 'btn btn-primary btn-sm pull-right')); 
			?>
				
		</fieldset>
	</div>
<?php echo form_close(); ?>

<script type="text/javascript">
//validation and submit handling
$(document).ready(function()
{
	$('#mailchimp_api_key').change(function() {
		$.post("<?php echo site_url($controller_name . '/ajax_check_mailchimp_api_key')?>", {
				'mailchimp_api_key': $('#mailchimp_api_key').val()
			},
			function(response) {
				$.notify(response.message, {type: response.success ? 'success' : 'danger'} );
				$('#mailchimp_list_id').empty();
				$.each(response.mailchimp_lists, function(val, text) {
					$('#mailchimp_list_id').append(new Option(text, val));
				});
				$('#mailchimp_list_id').prop('selectedIndex', 0);
			},
			'json'
		);
	});

	$('#integrations_config_form').validate($.extend(form_support.handler, {
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				success: function(response) {
					$.notify(response.message, { type: response.success ? 'success' : 'danger'} );
				},
				dataType: 'json'
			});
		},

		errorLabelContainer: '#integrations_error_message_box'
	}));
});
</script>