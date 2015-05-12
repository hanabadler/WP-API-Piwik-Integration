# WP-API-Piwik-Integration
A wordpress Plugin that captures all REST calls and send them to Piwik Server.good for audit REST Call

#Dependecies
The plugin use the "PiwikTracker.php" file from https://github.com/piwik/piwik-php-tracker.

#Piwik Settings that need to be changed

The plugin send the REST Request and resonse as custom variable. Custom variables on piwik database located at Table: piwik_log_link_visit_action
A modification for field "custom_var_v1" is requred.tyhe change can be done :
In phpmyadmin,executing the following sql:

ALTER TABLE `piwik_log_link_visit_action` CHANGE `custom_var_v1` `custom_var_v1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

#Plugin Settings Screen
The plugin Settings page has 4 settings the admin need to insert
<ul>
<li>Piwik URL:this url need to insert in the following form "http://piwik.mydomain.com/" or "http://www.mydomain.com/piwik/" . Please not the last slash is required</li>
<li>Website ID:this is the number the website has once its configured in piwik admin console
<li>User Authentication Token</li>
<li>WP-API Rest Url:this url is teh wp-api rest url on the worpress itself.e.g : http://www.mydomain.com/wp-json</li>
</ul>
