<?php
    /*
		Plugin Name: Stu's Solar Calc
		Plugin URI: http://stu-in-flag.net/blog/
		Description: A simple plug-in widget to allow the display of sunrise/set data.
		Version: 0.2
		Author: Stu-in-Flag
		Author URI: http://stu-in-flag.net
		Author email: stu-in-flag@stu-in-flag.net
	*/

	/*  Copyright 2010  Stuart Broyles  (email : stu-in-flag@stu-in-flag.net)

	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License as published by
	    the Free Software Foundation; either version 2 of the License, or
	    (at your option) any later version.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program; if not, write to the Free Software
	    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/
	
	/*	DISCLOSURE: I am not a professional programmer. While I would like to hear 
	  	feedback on how the plugin is functioning for others, I am making no 
	  	commitment to solving integration issues, providing updates, or any other 
	  	sort of support that you would expect of a professional. I just don't have 
	  	the knowledge to do that.
	 	
	 	I am using this widget on my own blog and intend to for the long-term. So, I
	 	think it is reasonably safe. There is very little error trapping for 
	 	entering the wrong values in the admin window on the widgets page. You are 
	 	the error trap. If you enter goofy things, you will get goofy, possibly 
	 	dangerous results. Still, you can just delete it manually and move along.
	 	
	 	With all those disclaimers, I hope this tool works for you. Please, let me
	 	if you have thoughts, questions or suggestions at stu-in-flag@stu-in-flag.net. 
	 	I'll see what I can do.
	 */
	
	//	Add function to widgets_init that'll load our widget.
	add_action( 'widgets_init', 'SSC_load_widget' );
	//  Register widget
	function SSC_load_widget() {
		register_widget('StuSolarCalc_Widget');	
	}
	class StuSolarCalc_Widget extends WP_Widget {
		function StuSolarCalc_Widget() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'solar', 'description' => 'A simple plug-in widget to allow the display of sunrise/set data.');
			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'solar' );
			/* Create the widget. */
			$this->WP_Widget( 'solar', 'Stu Solar Calc', $widget_ops, $control_ops );
		}
		
		function form($instance) {
			// outputs the options form on admin
			/* 	Variable list - Initialized to Flagstaff, AZ, USA (We don't use Daylight Savings)
					lat = Your latitude
					long = Your longitude
					location = Your location name
					offset = Your time offset from GMT for non-Daylight Savings Time
					dst = True for Daylight Savings Time (on/off values for checkbox)
					zenith = 90.83 or 90+50/60; Removed as variable 
						adjust zenith in the $defaults below, but only if you know what you are doing!!!
			*/
			$defaults = array( 'lat' => '35.20562', 'long' => '-111.63786', 'location' => 'Flagstaff, AZ', 'offset' => '-7', 'dst' => 'off');
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'lat' ); ?>">Latitude (XX.XXXXX degrees):</label>
				<input id="<?php echo $this->get_field_id( 'lat' ); ?>" name="<?php echo $this->get_field_name( 'lat' ); ?>" value="<?php echo $instance['lat']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'long' ); ?>">Longitude (+/-XXX.XXXXX):</label>
				<input id="<?php echo $this->get_field_id( 'long' ); ?>" name="<?php echo $this->get_field_name( 'long' ); ?>" value="<?php echo $instance['long']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'offset' ); ?>">Offset from GMT (hours):</label>
				<input id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo $instance['offset']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'location' ); ?>">Location name:</label>
				<input id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>" value="<?php echo $instance['location']; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'dst' ); ?>">Daylight Savings Time in Effect?</label>
				<input class="checkbox" type="checkbox" <?php checked( $instance['dst'], 'on' ); ?> id="<?php echo $this->get_field_id( 'dst' ); ?>" name="<?php echo $this->get_field_name( 'dst' ); ?>" />
			</p>
												
			<?php
			
			if ($instance['dst']=='on') {
				$timeGMT = gmdate("H:i", time() + 3600*($instance['offset']+1));  //  with Daylight Savings Time
			}
			else{
				$timeGMT = gmdate("H:i", time() + 3600*$instance['offset']);  //  without Daylight Savings Time
			}
			echo 'Current Time: ' . $timeGMT;
			echo $instance['dst'];		
		}
	
		function update($new_instance, $old_instance) {
			// processes widget options to be saved
			
			$instance = $old_instance;
			$instance['lat'] =  $new_instance['lat'];
			$instance['long'] =  $new_instance['long'];
			$instance['offset'] =  $new_instance['offset'];
			$instance['dst'] =  $new_instance['dst'];
			$instance['location'] = $new_instance['location'];
			//$instance['zenith'] = $new_instance['zenith']; Removed as variable. Change only if you understand zenith.
			return $instance;
	
		}
		function widget($args, $instance) {
			// Actual widget - displays a image file from a URL
			extract($args);
			echo $before_widget;
			echo $before_title.'Daily Sunrise/Sunset'.$after_title;	
			
			if ($instance['dst']=='on') {
				$timeGMT =  gmdate("H:i", time() + 3600*($instance['offset']+1));  //  with Daylight Savings Time
			}
			else {
				$timeGMT =  gmdate("H:i", time() + 3600*$instance['offset']);  //  without Daylight Savings Time
			}
				
			$sunrisetime = date_sunrise(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 90.83, $instance['offset']);
			$sunsettime = date_sunset(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 90.83, $instance['offset']);
			$civilstart = date_sunrise(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 96, $instance['offset']);  //  96 replaces $zenith
			$civilend = date_sunset(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 96, $instance['offset']);  //  96 replaces $zenith
			$nautstart = date_sunrise(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 102, $instance['offset']);  //  102 replaces $zenith
			$nautend = date_sunset(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 102, $instance['offset']);  //  102 replaces $zenith
			$astrostart = date_sunrise(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 108, $instance['offset']);  //  108 replaces $zenith
			$astroend = date_sunset(time(), SUNFUNCS_RET_STRING, $instance['lat'], $instance['long'], 108, $instance['offset']);  //  108 replaces $zenith

	        if ($timeGMT > $astroend) { 
	        $setday = 'Night Time';     
	        }     
	        else if ($timeGMT >= $nautend) { 
	        $setday = 'Astronomical Twilight';     
	        }     
	        else if ($timeGMT >= $civilend) {
	        $setday = 'Nautical Twilight';   
	        }   
	        else if ($timeGMT > $sunsettime) {
	        $setday = 'Civil Twilight';   
	        }   
	        else if ($timeGMT == $sunsettime) {
	        $setday = 'SUNSET';   
	        } 
	        else if ($timeGMT > $sunrisetime) {
	        $setday = 'Daylight';   
	        } 
	        else if ($timeGMT == $sunrisetime) {
	        $setday = 'SUNRISE';   
	        } 
	        else if ($timeGMT >= $civilstart) {
	        $setday = 'Civil Twilight';   
	        }   
	        else if ($timeGMT >= $nautstart) {
	        $setday = 'Nautical Twilight';   
	        } 
	        else if ($timeGMT >= $astrostart) {
	        $setday = 'Astronomical Twilight';   
	        } 
	        else  {
	        $setday = 'Night Time';
	        }
			
		echo '<center>'."\n";
		echo '<b>Current Time ' . $timeGMT . '</b><br>' . "\n";
		echo 'Current Event ' . $setday . '<br>' .  "\n"; 
		echo 'Astronomical Twilight starts ' . $astrostart . '<br>' . "\n";
		echo 'Nautical Twilight starts ' . $nautstart . '<br>' . "\n";
		echo 'Civil Twilight starts ' . $civilstart . '<br>' . "\n";
		echo '<b>SUNRISE ' . $sunrisetime . "\n";
		echo 'SUNSET ' . $sunsettime . '</b><br>' . "\n";
		echo 'Civil Twilight ends ' . $civilend  . '<br>' . "\n";
		echo 'Nautical Twilight ends ' . $nautend . '<br>' . "\n";
		echo 'Astronomical Twilight ends ' . $astroend . '<br>' . "\n";
			
		
		echo '<b>' . $instance['location'] . '</b></center>';
		echo $after_widget;
		}
	}
?>