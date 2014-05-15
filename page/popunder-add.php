<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$popunderpopup_errors = array();
$popunderpopup_success = '';
$popunderpopup_error_found = FALSE;

// Preset the form fields
$form = array(
	'id' => '',
	'url' => '',
	'width' => '',
	'height' => '',
	'expiration' => '',
	'starttime' => '',
	'group' => '',
	'timeout' => ''
);

// Form submitted, check the data
if (isset($_POST['popunderpopup_form_submit']) && $_POST['popunderpopup_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('popunderpopup_form_add');
	
	$form['url'] = isset($_POST['url']) ? $_POST['url'] : '';
	if ($form['url'] == '')
	{
		$popunderpopup_errors[] = __('Enter popunder popup url. url must start with either http or https.', POPUNDER_TDOMAIN);
		$popunderpopup_error_found = TRUE;
	}

	$form['width'] = isset($_POST['width']) ? $_POST['width'] : '';
	$form['height'] = isset($_POST['height']) ? $_POST['height'] : '';
	$form['expiration'] = isset($_POST['expiration']) ? $_POST['expiration'] : '';
	$form['starttime'] = isset($_POST['starttime']) ? $_POST['starttime'] : '';
	$form['group'] = isset($_POST['group']) ? $_POST['group'] : '';
	$form['timeout'] = isset($_POST['timeout']) ? $_POST['timeout'] : '';

	//	No errors found, we can add this Group to the table
	if ($popunderpopup_error_found == FALSE)
	{
		$action = popunderpopup_cls_dbquery::popup_act($form, "ins");
		if($action == "sus")
		{
			$popunderpopup_success = __('New details was successfully added.', POPUNDER_TDOMAIN);
		}
		elseif($action == "err")
		{
			$popunderpopup_success = __('Oops unexpected error occurred.', POPUNDER_TDOMAIN);
			$popunderpopup_error_found = TRUE;
		}

		// Reset the form fields
		$form = array(
			'id' => '',
			'url' => '',
			'width' => '',
			'height' => '',
			'expiration' => '',
			'starttime' => '',
			'group' => '',
			'timeout' => ''
		);
	}
}

if ($popunderpopup_error_found == TRUE && isset($popunderpopup_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $popunderpopup_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($popunderpopup_error_found == FALSE && strlen($popunderpopup_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $popunderpopup_success; ?> <a href="<?php echo POPUNDER_ADMINURL; ?>"><?php _e('Click here', POPUNDER_TDOMAIN); ?></a> 
		<?php _e('to view the details', POPUNDER_TDOMAIN); ?></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo POPUNDER_URL; ?>page/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(POPUNDER_PLUGIN_DISPLAY, POPUNDER_TDOMAIN); ?></h2>
	<form name="popunderpopup_form" method="post" action="#" onsubmit="return _popunderpopup_submit()"  >
      <h3><?php _e('Add details', POPUNDER_TDOMAIN); ?></h3>
      
		<label for="tag-a"><?php _e('Popunder url', POPUNDER_TDOMAIN); ?></label>
		<input name="url" type="text" id="url" value="" size="70" maxlength="255" />
		<p><?php _e('Enter popunder popup url. url must start with either http or https.', POPUNDER_TDOMAIN); ?><br />Example: http://www.gopiplus.com</p>
		
		<label for="tag-a"><?php _e('Start date', POPUNDER_TDOMAIN); ?></label>
		<input name="starttime" type="text" id="starttime" value="2014-05-01" maxlength="10" />
		<p><?php _e('Please enter popunder start date in format YYYY-MM-DD', POPUNDER_TDOMAIN); ?></p>			
		
		<label for="tag-a"><?php _e('Expiration date', POPUNDER_TDOMAIN); ?></label>
		<input name="expiration" type="text" id="expiration" value="9999-12-31" maxlength="10" />
		<p><?php _e('Please enter popunder expiration date in format YYYY-MM-DD', POPUNDER_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Category', POPUNDER_TDOMAIN); ?></label>
		<select name="group" id="group">
			<?php for($i=1; $i<=10; $i++) { ?>
				<option value='Category<?php echo $i; ?>'>Category<?php echo $i; ?></option>
			<?php } ?>
		</select>
		<p><?php _e('Select category for this popunder.', POPUNDER_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Width', POPUNDER_TDOMAIN); ?></label>
		<select name="width" id="width">
			<option value='30'>30%</option>
			<option value='35'>35%</option>
			<option value='40'>40%</option>
			<option value='45'>45%</option>
			<option value='50'>50%</option>
			<option value='55'>55%</option>
			<option value='60' selected="selected">60%</option>
			<option value='65'>65%</option>
			<option value='70'>70%</option>
			<option value='75'>75%</option>
			<option value='80'>80%</option>
			<option value='85'>85%</option>
			<option value='90'>90%</option>
			<option value='95'>95%</option>
		</select>
		<p><?php _e('Select width percentage for popup window.', POPUNDER_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Height', POPUNDER_TDOMAIN); ?></label>
		<select name="height" id="height">
			<option value='30'>30%</option>
			<option value='35'>35%</option>
			<option value='40'>40%</option>
			<option value='45'>45%</option>
			<option value='50'>50%</option>
			<option value='55'>55%</option>
			<option value='60' selected="selected">60%</option>
			<option value='65'>65%</option>
			<option value='70'>70%</option>
			<option value='75'>75%</option>
			<option value='80'>80%</option>
			<option value='85'>85%</option>
			<option value='95'>95%</option>
		</select>
		<p><?php _e('Select height percentage for popup window.', POPUNDER_TDOMAIN); ?></p>
			  
      <input name="id" id="id" type="hidden" value="">
      <input type="hidden" name="popunderpopup_form_submit" value="yes"/>
	  <input type="hidden" name="timeout" id="timeout" value="4000"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', POPUNDER_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_popunderpopup_redirect()" value="<?php _e('Cancel', POPUNDER_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_popunderpopup_help()" value="<?php _e('Help', POPUNDER_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('popunderpopup_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
</div>