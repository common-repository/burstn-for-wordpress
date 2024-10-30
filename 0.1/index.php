<?php
/*
Plugin Name: Burstn for Wordpress
Plugin URI: http://www.wesbos.com/
Description: Display your latest Burstn photos
Author: Wes Bos
Version: 0.1
Author URI: http://www.wesbos.com/

 
*/
// create the variables to pass to our JS

function localize_burstn_vars() {

	$options = get_option("widget_latest_burstn_photos");

    return array(
        'SiteUrl' 	=> get_bloginfo('url'),
        'un'		=> $options['username'],
        'ni'		=> $options['limit']
    );
} //End localize_burstn_vars


// load up our javascript
wp_enqueue_script('burstn_script',   '/wp-content/plugins/burstn/js/wb.js', array('jquery'));
// pass our variables to PHP
wp_localize_script( 'burstn_script', 'burstn_vars', localize_burstn_vars());

function my_burstn_css() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') .'/wp-content/plugins/burstn/css/burstn.css" />' . "\n";
}

add_action('wp_head', 'my_burstn_css');


// Create our core functionaly. This is what prints to the screen. 
function latest_burstn_photos() {
  echo "<ul class='my_latest_bursts'></ul>";
}
 
function widget_latest_burstn_photos($args) {
	  extract($args);
	 
	  $options = get_option("widget_latest_burstn_photos");
	  if (!is_array( $options ))
		
		{
			$options = array(
	    	  //'title' => 'My Latest Burstn Photos', // ?
	      	);
	  	}
	 
		echo $before_widget;
		echo $before_title;
		echo $options['title'];
		echo $after_title;
		//Our Widget Content
		latest_burstn_photos();
		echo $after_widget;

		

											} // end latest burstn photos widget build
 
// Create the controls 

function latest_burstn_photos_control()
	{
	  $options = get_option("widget_latest_burstn_photos");
	  if (!is_array( $options ))
	{
	
	$options = array(
	      'title' => 'My Latest Burstn Photos', // default text
	      'username' => 'wesbos', // default text
	      'limit' => '6' // default text
	      );
	  }
	 
	 // if we are coming back from a save
	  if ($_POST['latest_burstn_photos-Submit'])
	  {
	    $options['title'] = htmlspecialchars($_POST['latest_burstn_photos-WidgetTitle']);
	    $options['limit'] = htmlspecialchars($_POST['latest_burstn_photos-limit']);
	    $options['username'] = htmlspecialchars($_POST['latest_burstn_photos-username']);
	    update_option("widget_latest_burstn_photos", $options);
	  }
	 
	 
	 
	?>
	  <p>
	    <label for="latest_burstn_photos-WidgetTitle">Widget Title: </label><br>
	    <input type="text" id="latest_burstn_photos-WidgetTitle" name="latest_burstn_photos-WidgetTitle" value="<?php echo $options['title'];?>" /><br>
	    <label for="latest_burstn_photos-WidgetTitle">Username: </label><br>
	    <input type="text" id="latest_burstn_photos-username" name="latest_burstn_photos-username" value="<?php echo $options['username'];?>" /><br>
		<label for="latest_burstn_photos-WidgetTitle">Number of photos to show: </label><br>
	    <input type="text" id="latest_burstn_photos-limit" size="3" name="latest_burstn_photos-limit" value="<?php echo $options['limit'];?>" /><br>
	    
	    <input type="hidden" id="latest_burstn_photos-Submit" name="latest_burstn_photos-Submit" value="1" />
	  </p>
	<?php

}
 
 
 
 
function latest_burstn_photos_init()
{
	// these need to be the same
  register_sidebar_widget(__('Latest Burstn Photos'), 'widget_latest_burstn_photos');
  register_widget_control(   'Latest Burstn Photos', 'latest_burstn_photos_control', 300, 200 );
}
add_action("plugins_loaded", "latest_burstn_photos_init"); 
?>
