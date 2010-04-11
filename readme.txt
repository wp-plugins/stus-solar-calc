=== Plugin Name ===
Contributors: stu-in-flag
Donate link: http://stu-in-flag.net/sqp_plugin
Tags: sunrise, sunset, twilight, solar, astronomical, calculator 
Requires at least: 2.9.2
Tested up to: 2.9.2
Stable tag: 0.2

A simple plug-in widget to allow the display of sunrise/set data.

== Description ==

	*	This is pretty straight forward plugin that takes your locally infor-
	mation and produces a set of sunrise, sunset and twilight data. 
	*	You need to know how many hours your time zone is from Greenwich Mean Time.
	There is a feature for selecting Daylight Savings Time (DST), but this must
	be done	manually when your location makes the shift. Because of different 
	DST	practices and occassional changes made by the governments, I did not
	try to code DST changes. This can be found at many time zone sites, like
	http://www.worldtimezone.com/ and http://www.time.gov.
	*	Also, you have to be able to input your decimal	degrees latitude and long-
	itude. Google Earth can be set up to get this. 		
	*	I am using this widget on my own blog and intend to for the long-term. So, I
	think it is reasonably safe. There is very little error trapping for 
	entering the wrong values in the admin window on the widgets page. If you have
	issues with the plugin, or ideas for improvements, please let me know.	
		
		stu-in-flag@stu-in-flag.net. 
	
		I'll see what I can do.

== Installation ==

1. 	Upload the unzipped folder and contents to the `/wp-content/plugins/` directory
2. 	Activate the plugin through the 'Plugins' menu in WordPress
3. 	Include the widget on your sidebar, header or footer as allowed by your theme.
	This is done on the 'Widgets' admin page which is found in the 'Appearance'
	section of the admin menu. See screenshot2.png. Drag the widget to the appro-
	priate section.
4.	Setup the widget to show your picture using the admin window. Your latitude
	and longitude need to be in decimal degree format. You can find this on many
	map websites. Google Earth works well for this. The time zone is set with GMT
	time zone difference. This can be found at many time zone sites, like
	http://www.worldtimezone.com/ and http://www.time.gov.
5.	Very important: DAYIGHT SAVINGS TIME MUST MANUALLY CHANGED. With differences
	around the world, and local law changes, it's would be craziness to try and code
	these. So, when you spring-forward or fall-back, change the Daylight Savings
	Time checkbox. Lucky for me, I live in Arizona where we don't mess with the time.

== Screenshots ==

screenshot1.png		This screenshot shows the output of the widget on my blog.
					It is in the right sidebar.

screenshot2.png		This screenshot shows the 'Widget' admin page in WordPress
					There are several useful parts. First, on the middle left
					side of the image, the location of the 'Widget' menu selection
					is located under the 'Appearance' tab. Secoond, it shows the
					widget in the sidebar location. Third, it shows the admin
					control window and the variables which can be altered.

== Changelog ==
0.1	Version 0.1 plain and simple. It seems to work.

0.2 Version 0.2 Daylight Savings Time (DST) was incorrectly calculated.
	Changed "-" to "+" in lines 101 and 130. Thanks to DLinton for catching
	this error. 