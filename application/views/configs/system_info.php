<style type="text/css">
	 a:hover {
	  cursor:pointer;
}
</style>
<script type="text/javascript" src="js/clipboard.min.js"></script>
<div id="config_wrapper" class="col-sm-12">
	<?php echo $this->lang->line('config_server_notice'); ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-2" align="left"><br>
			<p style="min-height:15.9em;"><strong>General Info </p> 
			<p style="min-height:9.9em;">User Setup</p> 
			<p>Permissions</p></strong>
		</div> 
		<div class="col-sm-8" id="issuetemplate" align="left"><br>
			<?php echo $this->lang->line('config_ospos_info') . ':'; ?>
			<?php echo $this->config->item('application_version'); ?> - <?php echo substr($this->config->item('commit_sha1'), 0, 6); ?><br><br>
			Language Code: <?php echo current_language_code(); ?><br><br>
			Extensions & Modules:<br> <?php 
					echo "&#187; GD: ", extension_loaded('gd') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br>';
					echo "&#187; BC Math: ", extension_loaded('bcmath') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br>';
					echo "&#187; INTL: ", extension_loaded('intl') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br>';
					echo "&#187; OpenSSL: ", extension_loaded('openssl') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br>';
					echo "&#187; MBString: ", extension_loaded('mbstring') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br>';
					echo "&#187; Curl: ", extension_loaded('curl') ? 'Enabled &#x2713' : 'MISSING &#x2717', '<br> <br>';		
				?>
			User Configuration:<br>
			.Browser: <?php
					function get_browser_name($user_agent)
					{
						if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
						elseif (strpos($user_agent, 'Edge')) return 'Edge';
						elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
						elseif (strpos($user_agent, 'Safari')) return 'Safari';
						elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
						elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
						return 'Other';
					}
					 echo get_browser_name($_SERVER['HTTP_USER_AGENT']); 
				?><br>
			.Server Software: <?php echo $_SERVER['SERVER_SOFTWARE']; ?><br>
			.PHP Version: <?php echo PHP_VERSION; ?><br>
			.DB Version: <?php echo mysqli_get_server_info($this->db->conn_id); ?><br>
			.Server Port: <?php echo $_SERVER['SERVER_PORT']; ?><br>
			.OS: <?php echo php_uname();?><br><br>
			File Permissions:<br>
				&#187; [application/logs:]
					<?php $logs = '../application/logs/'; 
						$uploads = '../public/uploads/'; 
						$images = '../public/uploads/item_pics/'; 
						$import = '../import_items.csv';
						$importcustomers = '../import_customers.csv';
						
						if (is_writable($logs)) {
							echo ' -  ' . substr(sprintf("%o",fileperms($logs)),-4) . ' |  ' . '<font color="green">  Writable &#x2713 </font>';
						} else {
							echo ' -  ' . substr(sprintf("%o",fileperms($logs)),-4) . ' |  ' . '<font color="red">	Not Writable &#x2717 </font>';						
						}
						clearstatcache();
					?><br>
					&#187; [public/uploads:]
					<?php
						if (is_writable($uploads)) {
							echo ' -  ' . substr(sprintf("%o",fileperms($uploads)),-4) . ' |  ' . '<font color="green">	 Writable &#x2713 </font>';
						} else {
							echo ' -  ' . substr(sprintf("%o",fileperms($uploads)),-4) . ' |  ' . '<font color="red"> Not Writable &#x2717 </font>';
						}
						clearstatcache();
					?><br>
					&#187; [public/uploads/item_pics:]	
					<?php 
						if (is_writable($images)) {
							echo ' -  ' . substr(sprintf("%o",fileperms($images)),-4) . ' |	 ' . '<font color="green"> Writable &#x2713 </font>';
						} else {
							echo ' -  ' . substr(sprintf("%o",fileperms($images)),-4) . ' |	 ' . '<font color="red"> Not Writable &#x2717 </font>';
						} 
						clearstatcache();
					?><br>
					&#187; [import_customers.csv:]
					<?php 
						if (is_writable($importcustomers)) {
							echo ' -  ' . substr(sprintf("%o",fileperms($importcustomers)),-4) . ' |  ' . '<font color="green">	 Writable &#x2713 </font>';
						} else {
							echo ' -  ' . substr(sprintf("%o",fileperms($importcustomers)),-4) . ' |  ' . '<font color="red"> Not Writable &#x2717 </font>';
						}
						clearstatcache(); ?><br><br>
		</div>
	</div>
	</div>
</div>
<div align="center">
		<a class="copy" data-clipboard-action="copy" data-clipboard-target="#issuetemplate">Copy Info</a> | <a href="https://github.com/opensourcepos/opensourcepos/issues/new" target="_blank"> Report An issue </a>		
		<script>
			var clipboard = new ClipboardJS('.copy');

			clipboard.on('success', function(e) {
				console.log(e);
			});

			clipboard.on('error', function(e) {
				console.log(e);
			});
		</script>
</div>
