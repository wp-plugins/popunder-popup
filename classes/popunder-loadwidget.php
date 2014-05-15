<?php
class popunderpopup_cls_widget
{
	public static function popunderpopup_widget_int($arr)
	{
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$popunderpopup_session = get_option('popunderpopup_session');
		$display = "NO";
		if($popunderpopup_session <> "YES")
		{
			$display = "YES";
		}
		else if($popunderpopup_session == "YES" && isset($_SESSION['popunder-popup']) <> "YES")
		{
			$display = "YES";
		}
		else if($popunderpopup_session == "YES" && isset($_SESSION['popunder-popup']) == "YES")
		{
			$display = "NO";
		}
		
		if($display == "YES")
		{
			$id = isset($arr['id']) ? $arr['id'] : '0';
			$cat = isset($arr['cat']) ? $arr['cat'] : '';
			$data = array();
			$data = popunderpopup_cls_dbquery::popup_widget($id, $cat);
			
			if( count($data) > 0 )
			{
				$form = array(
					'id' => $data[0]['id'],
					'url' => $data[0]['url'],
					'width' => $data[0]['width'],
					'height' => $data[0]['height'],
					'expiration' => $data[0]['expiration'],
					'starttime' => $data[0]['starttime'],
					'group' => $data[0]['group'],
					'timeout' => $data[0]['timeout']
				);
				
				$width = $form["width"];
				$height = $form["height"];
				
				if(!is_numeric($width)) 
				{
					$width = 70;
				}
				if(!is_numeric($height)) 
				{
					$height = 70;
				}
				require_once(POPUNDER_DIR.'classes'.DIRECTORY_SEPARATOR.'popunder-widget.php');
				?>
				<script type="text/javascript">
				document.onclick = function() 
				{ 
					var openpopunder = document.getElementById("openpopunder");
					if( openpopunder.value == "YES" )
					{
						document.getElementById("openpopunder").value = "NO";
						iframepopupwidow('<?php echo $form["url"]; ?>');
					}
				};
				</script>
				<input name="openpopunder" id="openpopunder" value="YES" type="hidden">
				<?php
				$_SESSION['popunder-popup'] = "YES";
			}
		}
	}
}

function popunderpopup_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[popunder-popup id="1" cat=""]
	//[popunder-popup id="1"]
	//[popunder-popup cat="Category1"]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	$cat = isset($atts['cat']) ? $atts['cat'] : '';
	
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = $cat;
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup()
{
	$arr = array();
	$arr["id"] 	= 0;
	$arr["cat"] = "";
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup_id( $id = "0" )
{
	$arr = array();
	$arr["id"] 	= $id;
	$arr["cat"] = "";
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}

function pp_popup_cat( $cat = "" )
{
	$arr = array();
	$arr["id"] 	= 0;
	$arr["cat"] = $cat;
	echo popunderpopup_cls_widget::popunderpopup_widget_int($arr);
}
?>