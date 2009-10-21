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
		echo '<div class="ajaxmessage updated fade below-h2 message"><p></p></div>';
		echo '<div class="metabox-holder wrap" id="poststuff" class="stuffbox">';
		echo '<h2 class="custom">' . $this->Name . ' Settings</h2>';
		if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade below-h2" style="background-color: rgb(255, 251, 204); margin-bottom:16px;"><p style="font-style:normal;font-size:13px;">' . $this->Name . ' Settings Saved Successfully.</p></div>';
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
			}
			if($ToPrint) echo $ToPrint;
		}
		echo '</form>';

	if( $_POST[ 'ce' ] ) {
		$message = ce_process();
	}
	$options = ce_get_options();
	?>
	<div class="wrap">
		<h2>Category Excluder Options</h2>
		<?php echo $message ?>
		<p>Use this section allows you to select the categories you wish to exclude and where you would like to exclude them from.</p>
		<p>Note: If a post is in more the one category, it will be excluded if it matches any of the excluded categories</p>
	<form action="themes.php?page=control-panel.php" method="post">
	<table class="widefat">
		<thead>
			<tr>
				<th scope="col">Category</th>
				<th scope="col">Exclude from Main Page?</th>
				<th scope="col">Exclude from Feeds?</th>
				<th scope="col">Exclude from Archives?</th>
			</tr>
		</thead>
		<tbody id="the-list">
	<?php
		//print_r( get_categories() );
		$cats = get_categories();
		$alt = 0;
		foreach( $cats as $cat ) {
			?>
			<tr<?php if ( $alt == 1 ) { echo ' class="alternate"'; $alt = 0; } else { $alt = 1; } ?>>
				<th scope="row"><?php echo $cat->cat_name; //. ' (' . $cat->cat_ID . ')'; ?></th>
				<td>
					<input type="checkbox" name="exclude_main[]" value="-<?php echo $cat->cat_ID ?>" <?php if ( in_array( '-' . $cat->cat_ID, $options['exclude_main'] ) ) { echo 'checked="true" '; } ?>/>
				</td>
				<td><input type="checkbox" name="exclude_feed[]" value="-<?php echo $cat->cat_ID ?>" <?php if ( in_array( '-' . $cat->cat_ID, $options['exclude_feed'] ) ) { echo 'checked="true" '; } ?>/></td>
				<td><input type="checkbox" name="exclude_archives[]" value="-<?php echo $cat->cat_ID ?>" <?php if ( in_array( '-' . $cat->cat_ID, $options['exclude_archives'] ) ) { echo 'checked="true" '; } ?>/></td>
			</tr>			
		<?php
		}
	?>
	</table>
	<p class="submit"><input type="submit" value="Update" /></p>
	<input type="hidden" name="ce" value="true" />
	</form>
	</div><?php

	if ( $_POST['robots_txt'] ){
		update_option( 'robots_txt', $_POST['robots_txt'] );
		$urlwarning = str_replace('http://', '', get_bloginfo('url') );
		$urlwarning = substr( $urlwarning, 0, -1 );	// in case there is a trailing slash--don't want it so set off our warning
		if ( strpos( $urlwarning, '/' ) )			// this is our warning checker
			$urlwarning = '<p>It appears that your blog is installed in a subdirectory, not in a subdomain or at your domain\'s root. Be aware that search engines do not look for robots.txt files in subdirectories. <a href="http://www.robotstxt.org/wc/exclusion-admin.html">Read more</a>.</p>';
		else
			unset($urlwarning);
		print '<div id="message" class="updated fade"><p><strong>Robots.txt updated.</strong> <a href="'.get_bloginfo('url').'/robots.txt">View robots.txt</a>.</p>'.$urlwarning.'</div>';
	}
	
	$robotstxt_out = get_option('robots_txt');
	
	print '
	<div class="wrap">
	<div class="stuffbox custom">
		<h3 class="hndle">Robots.txt Editor</h3>
		<div class="inside">
			<div class="wrap">
				<p>Edit your robots.txt file in the space below. Lines beginning with <code>#</code> are treated as comments.</p>
				<p>Using robots.txt, you can ban specific robots, ban all robots, or block robot access to specific pages or areas of your site. If you are not sure what to type, look at the bottom of this page for examples.</p>
				<form method="post" action="http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">
					<textarea id="robots_txt" name="robots_txt" rows="10" cols="45" class="widefat">'.$robotstxt_out.'</textarea>
					<p class="submit" style="width:420px;"><input type="submit" value="Submit Robots.txt &raquo;" /></p>
				</form>
				<h2>Robots.txt Samples</h2>
				<h4>Ban all robots</h4>	
				<blockquote><code>User-agent: *<br />Disallow: /</code></blockquote>
				<h4>Allow all robots</h4>
				<p>To allow any robot to access your entire site, you can simply leave the robots.txt
				file blank, or you could use this:</p>
				<blockquote><code>User-agent: *<br />Allow: /</code></blockquote>

			</div>
		</div>
	</div>

	</div>
	</div>
	</div>
	';
	}
	function Settings($Option)
	{
		return $this->Settings[$Option];
	}
}

?>
