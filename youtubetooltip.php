<?php
/*
Plugin Name: Youtube ToolTip
Version: 1.0.0
Plugin URI: http://javiergalicia.wordpress.com
Description: "Youtube ToolTip" Click on any of your links to get a quick preview of the youtube video.
Author: Javier Galicia
Author URI: http://javiergalicia.wordpress.com/
*/

if (!class_exists("YoutubeToolTip")) {


	class YoutubeToolTip {
		function YoutubeToolTip() { //constructor
			
		}
		function addCode() {
			$path = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';	// Path
			echo '<script type="text/javascript" src="' . $path . 'jquery-1.3.2.min.js"></script>'."\n";	// Adds the Jquery library to the header
			echo '<script type="text/javascript" src="' . $path . 'jquery.qtip-1.0.0-rc3.min.js"></script>'."\n";	// Adds the JavaScript to the header
			echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>'."\n"; //Adds the Google's player
			?>
			<script type="text/javascript">
				$(document).ready(function()
				{
				   // Use each method to gain access to all youtube links
				   $('a[href*="youtube."]').each(function()
				   {
				      // Grab video ID from the url
				      var videoID = $(this).attr('href').match(/watch\?v=(.+)+/);
				      videoID = videoID[1];

      			// Create content using url as base
		      $(this).qtip(
    		  {
    		     // Create content DIV with unique ID for swfObject replacement
    	     content: '<div id="youtube-embed-'+videoID+'">You need Flash player 8+ to view this video.</div>',
    	     position: {
    	        corner: {
    	           tooltip: 'bottomMiddle', // ...and position it center of the screen
    	           target: 'topMiddle' // ...and position it center of the screen
    	        }
    	     },
    	     show: {
    	        when: 'click', // Show it on click...
    	        solo: true // ...and hide all others when its shown
    	     },
    	     hide: 'unfocus', // Hide it when inactive...
    	     style: {
    	        width: 432,
    	        height: 264,
    	        padding: 0,
    	        tip: true,
    	        name: 'dark'
    	     },
  	  	     api: {
  	  	        onRender: function()
  	  	        {
  	  	           // Setup video paramters
  	  	           var params = { allowScriptAccess: 'always', allowfullScreen: 'false' };
  	  	           var attrs = { id: 'youtube-video-'+videoID };
		
  	  	           // Embed the youtube video using SWFObject script
  	  	           swfobject.embedSWF('http://www.youtube.com/v/'+videoID+'&enablejsapi=1&playerapiid=youtube-api-'+videoID,
  	  	                             'youtube-embed-'+videoID, '425', '264', '8', null, null, params, attrs);
  	  	        },
		
  	  	        onHide: function(){
  	  	           // Pause the vide when hidden
  	  	           var playerAPI = this.elements.content.find('#youtube-video-'+videoID).get(0);
  	  	           if(playerAPI && playerAPI.pauseVideo) playerAPI.pauseVideo();
  	  	        }
  	  	     }
  	  	  }
  	  	  ).attr('href', '#');
  			 });
				});
				</script>
			<?php
		}

		
	}

} //End Class ExposeIt

if (class_exists("YoutubeToolTip")) {
	$dl_plugin = new YoutubeToolTip();
}
//Actions
if (isset($dl_plugin)) {
	//Add Action To Footer
	add_action('wp_footer', array(&$dl_plugin, 'addCode'));
}

?>
