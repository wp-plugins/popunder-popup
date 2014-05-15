<?php
class popunderpopup_cls_registerhook
{
	public static function popunderpopup_activation()
	{
		global $wpdb, $popunderpopup_db_version;
		$prefix = $wpdb->prefix;
		
		add_option('popunderpopup_popup_db', "1.0");
		add_option('popunderpopup_session', "NO");
		
		// Plugin tables
		$array_tables_to_plugin = array('popunderpopup');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = POPUNDER_DIR.'sql'.DS.'popunder-tbl.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), POPUNDER_TDOMAIN);
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , POPUNDER_TDOMAIN ) );
			return false;
		}
		else
		{
			popunderpopup_cls_dbquery::popup_default();
		}
        return true;
	}
	
	public static function popunderpopup_deactivation()
	{
		// do not generate any output here
	}
	
	public static function popunderpopup_adminmenu()
	{
		if (is_admin()) 
		{
			add_options_page( __('Popunder popup', POPUNDER_TDOMAIN), 
				__('Popunder popup', POPUNDER_TDOMAIN), 'manage_options', POPUNDER_PLUGIN_NAME, array( 'popunderpopup_cls_intermediate', 'popunderpopup_admin' ) );
		}		
	}
	
	function popunderpopup_add_javascript_files() 
	{
		if (!is_admin())
		{
			wp_enqueue_script('jquery');
		}
	}
}
?>