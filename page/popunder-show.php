<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_popunderpopup_display']) && $_POST['frm_popunderpopup_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$popunderpopup_success = '';
	$popunderpopup_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = popunderpopup_cls_dbquery::popup_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', POPUNDER_TDOMAIN); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('popunderpopup_form_show');
			
			//	Delete selected record from the table
			popunderpopup_cls_dbquery::popup_delete($did);
			
			//	Set success message
			$popunderpopup_success_msg = TRUE;
			$popunderpopup_success = __('Selected record was successfully deleted.', POPUNDER_TDOMAIN);
		}
	}
	
	if ($popunderpopup_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $popunderpopup_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(POPUNDER_PLUGIN_DISPLAY, POPUNDER_TDOMAIN); ?>
	<a class="add-new-h2" href="<?php echo POPUNDER_ADMINURL; ?>&page=popunder-popup&ac=add"><?php _e('Add New', POPUNDER_TDOMAIN); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = popunderpopup_cls_dbquery::popup_select(0);
		?>
		<script language="JavaScript" src="<?php echo POPUNDER_URL; ?>page/setting.js"></script>
		<form name="frm_popunderpopup_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th class="check-column" scope="col">
			<input type="checkbox" name="es_checkall" id="es_checkall" onClick="_popunderpopup_checkall('frm_popunderpopup_display', 'chk_delete[]', this.checked);" /></th>
			<th scope="col"><?php _e('Id', POPUNDER_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Popunder url', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Start', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Expiration', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Category', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Width', POPUNDER_TDOMAIN); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th class="check-column" scope="col">
			<input type="checkbox" name="es_checkall" id="es_checkall" onClick="_popunderpopup_checkall('frm_popunderpopup_display', 'chk_delete[]', this.checked);" /></th>
			<th scope="col"><?php _e('Id', POPUNDER_TDOMAIN); ?></th>
            <th scope="col"><?php _e('Popunder url', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Start', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Expiration', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Category', POPUNDER_TDOMAIN); ?></th>
			<th scope="col"><?php _e('Width', POPUNDER_TDOMAIN); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input name="chk_delete[]" id="chk_delete[]" type="checkbox" value="<?php echo $data['id'] ?>" /></td>
						<td><?php echo $data['id']; ?></td>
						<td><?php echo stripslashes($data['url']); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo POPUNDER_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['id']; ?>"><?php _e('Edit', POPUNDER_TDOMAIN); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_popunderpopup_delete('<?php echo $data['id']; ?>')" href="javascript:void(0);"><?php _e('Delete', POPUNDER_TDOMAIN); ?></a>
						</span> 
						</div>
						</td>
						<td><?php echo substr($data['starttime'],0,10); ?></td>
						<td><?php echo substr($data['expiration'],0,10); ?></td>
						<td><?php echo $data['group']; ?></td>
						<td><?php echo $data['width']; ?>%</td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="7" align="center"><?php _e('No records available.', POPUNDER_TDOMAIN); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('popunderpopup_form_show'); ?>
		<input type="hidden" name="frm_popunderpopup_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo POPUNDER_ADMINURL; ?>&amp;ac=add"><?php _e('Add New', POPUNDER_TDOMAIN); ?></a>
	  <a class="button add-new-h2" href="<?php echo POPUNDER_ADMINURL; ?>&amp;ac=set"><?php _e('Session Setting', POPUNDER_TDOMAIN); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo POPUNDER_FAV; ?>"><?php _e('Help', POPUNDER_TDOMAIN); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', POPUNDER_TDOMAIN); ?></h3>
	<ol>
		<li><?php _e('Add popup into specific  post or page using short code', POPUNDER_TDOMAIN); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code', POPUNDER_TDOMAIN); ?></li>
	</ol>
	<p class="description"><?php echo POPUNDER_OFFICIAL; ?></p>
	</div>
</div>