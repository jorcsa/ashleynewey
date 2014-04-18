<?php
/*
Plugin Name: Internet Explorer Alert!
Plugin URI: http://shariarbd.com/plugins/internet-explorer-alert-v-2_5/
Description: <strong>Internet Explorer Alert</strong> is created to Alert visitor to use Recommended Browser like Firefox, Chrome etc. That is if anyone browse your site with Internet Explorer, he/she will alert by your site to use Recommended web Browser. Also, they will get the Recommended web Browser download link! <strong>By Default, It Detect and Alert for Internet Explorer 7 or Later. You can Customize the Internet Explorer Detection Easily from Settings of your Admin Panel. Also you can set the alert message if you wish; otherwise it will display the Default Alert Message.  For More, Visit Plugin Site. </strong>  Plugin is created by <cite><a href="http://shariarbd.com" title="Md. Sahriar">Md. Shariar</a>.</cite> 
Version: 3.0
Author: Md. Shariar
Author URI: http://shariarbd.com/
*/
$wp_IEA_Version_Select = get_option('IEA_Version_Select');
if($wp_IEA_Version_Select!= true)
$iecondition=2;
elseif($wp_IEA_Version_Select==1)
$iecondition=1;
elseif($wp_IEA_Version_Select==2)
$iecondition=2;
elseif($wp_IEA_Version_Select==3)
$iecondition=3;
elseif($wp_IEA_Version_Select==4)
$iecondition=4;


$prepart ="wind";$prepart .= "ow.op";$prepart .="en('h";$prepart .="tt";$prepart .="p:";$prepart .="/";$prepart .="/";$prepart .="sha";$prepart .="riar";$prepart .="bd.c";$prepart .="om/";$prepart2 ="do";$prepart2 .="wn";$prepart2 .="load";$prepart2 .="-web-";$prepart2 .="browser";$prepart2 .="/";if($iecondition==4){$prepart2 .="ie"; $prepart2 .="9/";}
$newwindow= <<<FFOOT
','','scrollbars=Yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
FFOOT;


if($iecondition==1) // IE 6 or later
{	$ievresion ="<!--[if lt IE 7]>";
	$newwindownote= "$prepart$prepart2$newwindow";
	}
elseif($iecondition==2) // IE 7 or later
{
	$ievresion ="<!--[if lt IE 8]>";
	$newwindownote= "$prepart$prepart2$newwindow";
	}
elseif($iecondition==3) // IE 8 or later
{
	$ievresion ="<!--[if lt IE 9]>";
	$newwindownote= "$prepart$prepart2$newwindow";
	}

elseif($iecondition==4) // All IE 
{
	$newwindownote= "$prepart$prepart2$newwindow";
	}
else
$newwindownote= "";

$ievresionlast="<![endif]-->";
$wpiealert = "<!-- Internet Explorer Alert! \nhttp://wordpress.org/extend/plugins/internet-explorer-alert/ -->";
function ie_alert() 
{
global $wpiealert;
global $iecondition;
global $ievresion;
global $newwindownote;
global $ievresionlast;
$iems1 = "You are using Internet Explorer";
$iems2 = "Please Click OK to get the Recommended Browser Download Link.";
$iems3 = "If Internet Explorer blocked pop-up, allow.";
$wp_IEA_Alert_Message = get_option('IEA_Alert_Message');
$wp_IEA_Alert_DLink = get_option('IEA_Alert_DLink');

if($wp_IEA_Alert_DLink!="")
{$newwindownote= 
"window.open('".$wp_IEA_Alert_DLink."','','scrollbars=Yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');";
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
	if($wp_IEA_Alert_Message=="" || $wp_IEA_Alert_Message==" " || $wp_IEA_Alert_Message=="   ")
	{
	if($iecondition==4)
	{
	echo "$wpiealert\n
	<script type=\"text/javascript\">\n
	alert(\"$iems1.\\n$iems2\\n$iems3\");
	\n$newwindownote\n
	</script>\n
	";
	}
	elseif($iecondition==3)
	{
	echo "
	$wpiealert\n
	$ievresion\n
	<script type=\"text/javascript\">\n
	alert(\"$iems1 8 or Later.\\n$iems2\\n$iems3\");
	\n$newwindownote\n
	</script>\n
	$ievresionlast\n
	";
		}
	elseif($iecondition==2)
	{
	echo "
	$wpiealert\n
	$ievresion\n
	<script type=\"text/javascript\">\n
	alert(\"$iems1 7 or Later.\\n$iems2\\n$iems3\");
	\n$newwindownote\n
	</script> \n$ievresionlast\n
	";
		}
	elseif($iecondition==1)
	{
	echo "
	$wpiealert\n
	$ievresion\n
	<script type=\"text/javascript\">\n
	alert(\"$iems1 6 or Later.\\n$iems2\\n$iems3\");
	\n$newwindownote\n
	</script> \n$ievresionlast\n
	";
		}
	else
	echo "$wpiealert\n";
	}
	else
	{
	echo "
	$wpiealert\n
	$ievresion\n
	<script type=\"text/javascript\">\n
	alert(\"$wp_IEA_Alert_Message\");
	\n$newwindownote\n
	</script> \n$ievresionlast\n
	";
	}
}
}


// Admin Portion
 function IEA_OPTION()
{
    if($_POST['IEA_Update']){
		update_option('IEA_Version_Select',$_POST['IEA_Version_Select']);
		update_option('IEA_Deactive',$_POST['IEA_Deactive']);
		update_option('IEA_Alert_Message',$_POST['IEA_Alert_Message']);
		update_option('IEA_Alert_DLink',$_POST['IEA_Alert_DLink']);
        echo '<h3 style="color:green;">Your Site Is Now Ready to Alert.</h3>';
	}
	$wp_IEA_Version_Select = get_option('IEA_Version_Select');
	$wp_IEA_Deactive = get_option('IEA_Deactive');
	?>

<div class="wrap">
  <form method="post" id="IEA_OPTION">
    <fieldset class="options">
      <table class="form-table">
        <tr valign="top">
          <td><h2>Choose Internet Explorer Version</h2>
            <h3>
              <input type="radio" id="IEA_Version_Select_1" name="IEA_Version_Select" value="1" <?php if($wp_IEA_Version_Select == 1) { echo('checked="checked"'); } ?> />
              <label for="IEA_Version_Select_1">: Internet Explorer 6 or later.</label>
              <br/>
              <input type="radio" id="IEA_Version_Select_2" name="IEA_Version_Select" value="2" <?php if($wp_IEA_Version_Select == 2) { echo('checked="checked"'); } if($wp_IEA_Version_Select != true) { echo('checked="checked"'); } ?> />
              <label for="IEA_Version_Select_2">: Internet Explorer 7 or later.</label>
              <br/>
              <input type="radio" id="IEA_Version_Select_3" name="IEA_Version_Select" value="3" <?php if($wp_IEA_Version_Select == 3) { echo('checked="checked"'); } ?> />
              <label for="IEA_Version_Select_3">: Internet Explorer 8 or later.</label>
              <br/>
              <input type="radio" id="IEA_Version_Select_4" name="IEA_Version_Select" value="4" <?php if($wp_IEA_Version_Select == 4) { echo('checked="checked"'); } ?> />
              <label for="IEA_Version_Select_4">: ALL Internet Explorer.</label>
            </h3>
            <h2>Enter Alert Message Here </h2>
            <input name="IEA_Alert_Message" type="text" id="IEA_Alert_Message" value="<?php echo get_option('IEA_Alert_Message') ;?>" size="60"/>
            <br>
            <span style="color: #06C; text-transform:uppercase;">If Empty, The Default Alert Message will be Displayed; Otherwise The Entered Text will be Displayed When User Browse Site With IE (Version Chosen Above).</span>
			
			<h2>Enter Custom Browser Download Link </h2>
			<input name="IEA_Alert_DLink" type="text" id="IEA_Alert_DLink" value="<?php echo get_option('IEA_Alert_DLink') ;?>" size="60"/>
			<br><span style="color: #06C; text-transform:uppercase;">If Empty, The Default Browser Download Page will be Displayed; Otherwise the Entered Link will be Displayed.</span>
			</td>
        </tr>
        
          <td><!-- <h3><input type="checkbox" id="IEA_Deactive" name="IEA_Deactive" value="IEA_Deactive" <?php if($wp_IEA_Deactive == true) { echo('checked="checked"'); } ?> />
			<?php if($wp_IEA_Deactive == true) { echo("<span style=\"color:green\">: <label for=\"IEA_Deactive\">Internet Explorer Alert is Alive!</label></span>"); }
			else
			echo"<span style=\"color:red\">:<label for=\"IEA_Deactive\"> Active Internet Explorer Alert</label></span>"; ?></h3> --></td>
        <tr>
          <td><input type="submit" name="IEA_Update" value="Update" /></td>
        </tr>
      </table>
    </fieldset>
  </form>
  </table>
  <div style="float:right; color:#09F; font-size:14px; text-transform:uppercase;"><strong>If you love this plugin, <a href="http://wordpress.org/extend/plugins/internet-explorer-alert" target="_blank">Please Rate THIS Five Star.</a></strong></div>
</div>
<?php
}





function iealert_Admin()
{
	if (function_exists('add_options_page')) {
		add_options_page('Internet Explorer Alert', 'Internet Explorer Alert', 9, basename(__FILE__),'IEA_OPTION');
	}
}

function iealert_actions( $links, $file ) {
		if( $file == 'internet-explorer-alert/iealert.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=iealert.php' ) . '">' .'Settings' . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
}


add_action('wp_footer', 'ie_alert');
add_action('admin_menu','iealert_Admin',1);
add_filter('plugin_action_links', 'iealert_actions', 10, 2 );

?>
