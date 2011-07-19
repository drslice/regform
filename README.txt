Setting up the site:

Website settings:
	If you are putting this into a subdirectory of the DOCROOT: 
	edit /.htaccess and change the RewriteBase to your subdir,
	also edit /application/bootstrap.php and change the base_url in the Kohana::init section.
	If you are leaving it in the DOCROOT, you can leave those files alone.

Database settings:
	Edit /application/config/database.php and put in your database settings.
	Import the /application/reg.sql file to populate it.
	If you wish to use a different table prefix than the default, you will need to edit the reg.sql file to match your new prefix along with changing it in the config.

Enabling the admin (and/or test) account:
	Either set the webserver KOHANA_ENV variable to something other than PRODUCTION
	or manually edit the /application/bootstrap.php file to set the environment.
	Then go to $servername/?force_login=admin and go to the user management section to change users' passwords.