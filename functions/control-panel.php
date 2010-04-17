<?php

class ControlPanel
{
	var $Name = null;
	var $Options = array();
	var $Settings = null;
	
	/* Constructor */
	function ControlPanel($Name)
	{
		$this->Name = $Name;
	}
	
	/* Initializing all the settings, and adding all the hooks */
	function Initialize()
	{
		add_action('admin_menu', array(&$this, 'AdminMenu'));
		add_action('admin_head', array(&$this, 'AdminHead'));
		
		/* Get Current Settings */
		$this->Settings = get_option($this->Name . 'Settings');
		if($this->Settings) $this->Settings = unserialize($this->Settings);
		
		/* Initialize Options */
		$this->SetDefaultSettings();
		
		/* Saving Settings */
		if ( $_GET['page'] == basename(__FILE__) )
		{
		
			if ( 'save' == $_REQUEST['action'] )
			{
				$NewSettings = array();
				foreach($this->Options as $Option)
				{
					if(isset($Option['ID']))
					{
						if(isset($_POST[$Option['ID']]))
							$NewSettings [$Option['ID']] = $_POST[$Option['ID']];
						elseif($Option['Type'] == 'CheckBox') // Nothing is POST'ed if a checkbox is unchecked
							$NewSettings [$Option['ID']] = 'false';
					}
				}
				print_r($NewSettings);
				update_option($this->Name . 'Settings', serialize($NewSettings));
				if($_REQUEST['mode'] == 'ajax')
				die($this->Theme . ' Settings Saved Successfully.');
				else
				header('Location: themes.php?page=control-panel.php&saved=true');
				die;
				
			}
			elseif( 'reset' == $_REQUEST['action'] )
			{
				
				header('Location: themes.php?page=control-panel.php&reset=true');
				die;
			
			}
		}
	}
	function AdminMenu()
	{
		add_theme_page($this->Name . ' Control Panel', $this->Name . ' Control Panel', 'edit_themes', basename(__FILE__), array(&$this, 'OptionsMenu'));
	}
	
	function AdminHead()
	{
		echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/control-panel.css" type="text/css" media="screen" />';
		wp_enqueue_script('jquery-form', get_bloginfo('template_url').'/js/jquery.form.js', array('jquery'), '1.0');
	}
	function SetOptions($Options)
	{
		$this->Options = $Options;
	}
	
	function SetDefaultSettings()
	{
		{
			if(isset($Option['ID']))
			{
				if(!isset($this->Settings[$Option['ID']]) && isset($Option['Default']))
				{
					$this->Settings[$Option['ID']] = $Option['Default'];
				}
			}
		}
	}

	/* Print the options page */
	function OptionsMenu()
	{
		echo '<div class="wrap">';
		echo '<div class="icon32" id="icon-themes"></div><h2>' . $this->Name . ' Settings</h2>';
		echo '<div class="wrap" id="poststuff">';
		if ( $_REQUEST['saved'] == true ) echo '<div id="message" class="updated fade below-h2" style="background-color: rgb(255, 251, 204); margin-bottom:16px;"><p style="font-style:normal;font-size:13px;">' . $this->Name . ' Settings Saved Successfully.</p></div>';
		echo '<form method="post" action="themes.php?page=' . basename(__FILE__) . '" id="settings">';
		$Settings = $this->Settings;
		foreach( $this->Options as $Option)
		{
			$Type = $Option['Type'];
			$Label = $Option['Label'];
			$ID = $Option['ID'];
			$Description = $Option['Description'];
			$Value = $Option['Value'];
			$Values = $Option['Values'];
			$ToPrint = '';

			/* Print Options */
			switch ($Type)
			{
				case 'Title':
					$ToPrint .= '<div class="stuffbox custom"><h3 class="hndle">' . $Value . '</h3><div class="inside">';
					break;
				case 'Close':
					$ToPrint .= '<p class="submit custom"><input name="save" type="submit" value="Save All Changes" /><input type="hidden" name="action" value="save" /></p>';
					break;
				case 'End':
					$ToPrint .= "</div></div>";
					break;
				case 'Text':
					if(isset($Label)) $ToPrint .= '<label for="' .  $ID . '">' . $Label . '<br>';
					$ToPrint .= '<input class="textbox" id="' . $ID . '" name="' .  $ID . '"  type="text" value="' . ($Settings[$ID]) . '"/>';
					if(isset($Label)) $ToPrint .= '</label>';
					if(isset($Description)) $ToPrint .= '<p class="description">' .  $Description . '</p>';
					break;
				case 'TextArea':
					if(isset($Label)) $ToPrint .= '<label for="' .  $ID . '">' . $Label . '<br><br>';
					$ToPrint .= '<textarea  class="textarea" id="' .  $ID . '" name="' .  $ID . '" type="textarea">' . ($Settings[$ID]) . '</textarea>';
					if(isset($Label)) $ToPrint .=  '</label>';
					if(isset($Description)) $ToPrint .= '<p class="description">' .  $Description . '</p>';
					break;
				case 'Select':
					if(isset($Label)) $ToPrint .= '<label for="' .  $ID . '">' . $Label . '<br>';
					$ToPrint .= '<select class="select" name="' .  $ID . '" id="' .  $ID . ' name="' .  $ID . '">' ;
					foreach($Values as $Key => $Value)
						$ToPrint .= '<option value="' . $Key . '" ' . (($Settings[$ID] == $Key)? 'selected="selected"' : '') . '>' .  $Value . '</option>';
					$ToPrint.= '</select>';
					if(isset($Label)) $ToPrint .= '</label>';
					if(isset($Description)) $ToPrint .= '<p class="description">' .  $Description . '</p>';
					break;
				case 'CheckBox':          
					if(isset($Label)) $ToPrint .= '<label for="' .  $ID . '">';
					$ToPrint .= '<input class="checkbox" id="' . $ID . '" name="' . $ID . '"  type="checkbox" value="true"' . 
					($Settings[$ID] == 'true' ? 'checked="checked"': '') . '/> ';
					if(isset($Label)) $ToPrint .= $Label . '</label>';
					if(isset($Description)) $ToPrint .= '<p class="description">' .  $Description . '</p>';
					break; 
				case 'CategoryList':
					echo "<label for='" .  $ID . "'>" . $Label . "</label><br />";
                                        wp_dropdown_categories('hide_empty=0&hierarchical=1&selected=' . $Settings[$ID] . '&name=' . $ID);
                                        if(isset($Description)) $ToPrint .= '<p class="description">' .  $Description . '</p>';
                                        break;

			}
			if($ToPrint) echo $ToPrint;
		}
		echo '</form>';

        // Add Category Excluder to the Control Pannel
        if (function_exists('ce_controlpanel')) {
          ce_controlpanel();
        }
        // End Category Excluder to the Control Pannel
	
	// Add Robots.txt to the Control Panel
	if (function_exists('mdr_robots_controlpanel')) {
          mdr_robots_controlpanel();
        }
	// End Robots.txt to the Control Panel
	}

	function Settings($Option)
	{
		return $this->Settings[$Option];
	}
}

$Options =
array
(
array
(
'Type'=>'Title',
'Value'=>'Google Analytics Options'
),
array
(
'Type'=>'CheckBox',
'ID'=>'GoogleAnalyticsEnabled',
'Label'=>'<strong>Enable Google Analytics</strong>',
'Description' => 'This module requres a <a href="http://analytics.google.com">Google Analytics</a> account.<br />The Google Analytics code will NOT be displayed for logged in users.',
'Default'=> 'false'
),
array
(
'Type'=>'Text',
'ID'=>'GoogleAnalyticsID',
'Label'=>'<strong>Google Analytics ID</strong>',
'Description'=>'Enter your <a href="http://analytics.google.com">Google Analytics</a> account ID.'
),
array
(
Type=>'End'
),
array
(
'Type'=>'Title',
'Value'=>'Google Webmaster Tools Options'
),
array
(
'Type'=>'CheckBox',
'ID'=>'GoogleWebmasterToolsEnabled',
'Label'=>'<strong>Enable Google Webmaster Tools</strong>',
'Description' => 'This module requres a <a href="http://www.google.com/webmasters/tools">Google Webmaster Tools</a> account.',
'Default'=> 'false'
),
array
(
'Type'=>'Text',
'ID'=>'GoogleWebmasterToolsID',
'Label'=>'<strong>Google Webmaster Tools ID</strong>',
'Description'=>'Enter your <a href="http://www.google.com/webmasters/tools">Google Webmaster Tools</a> account ID.'
),
array
(
Type=>'End'
),
array
(
'Type'=>'Title',
'Value'=>'Twitter Options'
),
array
(
'Type'=>'CheckBox',
'ID'=>'TwitterEnabled',
'Label'=>'<strong>Enable Twitter Post Type</strong>',
'Description' => 'To use this funiction, it is assumed you have the <a href="http://alexking.org/projects/wordpress">Twitter Tools</a> Plugin installed. <br /> You also need to create a page and select the "Twitter Page" page template, to view your tweets.',
'Default'=> 'false'
),
array
(
'Type'=>'CategoryList',
'ID'=>'TwitterCategory',
'Label'=>'Twitter Category',
'Description'=>'Select the Category you wish to move to the Twitter Post Type.  Once a post is moved, it can NOT be undone. <br /> Note: you may not use the "Uncategorized" category as this is the default category.'
),
array
(
'Type'=>'Text',
'ID'=>'TwitterID',
'Label'=>'Twitter ID',
'Description'=>'This is your Twitter username or ID, for display purpuses only.'
),
array
(
'Type'=>'Text',
'ID'=>'TwitterName',
'Label'=>'Twitter Name',
'Description'=>'This is the Display name for the twitter page.'
),
array
(
Type=>'End'
),
array
(
                'Type'=>'Title',
                'Value'=>'Copyright logo'
        ),
        array
        (
                'Type'=>'CheckBox',
                'ID'=>'copyenable',
                'Label'=>'<strong>Enable CC Copyright Logo</strong>',
                'Description' => '',
                'Default'=> 'false'
        ),
        array
        (
                Type=>'End'
        ),
array
(
Type=>'Close'
)
);
 
$Panel = new ControlPanel('Milly');
$Panel->SetOptions($Options);
$Panel->Initialize();

?>
