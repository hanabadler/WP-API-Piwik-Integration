# WP-API-Piwik-Integration
A wordpress Plugin that captures all REST calls and send them to Piwik Server.good for audit REST Call

#Dependecies
The plugin use the "PiwikTracker.php" file from https://github.com/piwik/piwik-php-tracker.

#Piwik Setting that need to be changed

The plugin send the REST Request and resonse as custom variable. Custom variables on piwik database located at Table: piwik_log_link_visit_action
A modification for field "custom_var_v1" is requred.tyhe change can be done :
In phpmyadmin,executing the following sql:

ALTER TABLE `piwik_log_link_visit_action` CHANGE `custom_var_v1` `custom_var_v1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

