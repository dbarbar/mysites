### This file contains stage-specific settings ###

# Set the deployment directory on the target hosts.
set :deploy_to, "/var/apps/#{application}"
set :web_path, "/var/www/#{application}"

# The hostnames to deploy to.
role :web, "5millionthings.com"
 
# Specify one of the web servers to use for database backups or updates.
# This server should also be running Drupal.
role :db, "5millionthings.com", :primary => true
 
# The username on the target system, if different from your local username
# ssh_options[:user] = 'alice'

# The path to drush
# set :drush, "cd #{current_path} ; /usr/bin/php /data/lib/php/drush/drush.php"
