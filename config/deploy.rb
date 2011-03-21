### This file contains project-specific settings ###
 
# The project name.
set :application, "drupal"

# List the Drupal multi-site folders.  Use "default" if no multi-sites are installed.
set :domains, ["default"]

# List folders that reside outside of SVN
set :static_dirs, ["files"]
 
# username of owner of apache process
set :apache_user, "apache"
 
# Set the repository type and location to deploy from.
set :scm, "git"
set :repository, "git@github.com:dbarbar/mysites.git"

default_run_options[:pty] = true  # Must be set for the password prompt from git to work
# set :user, "deployer"  # The server's user for deploys
# set :scm_passphrase, "p@ssw0rd"  # The deploy user's password
ssh_options[:forward_agent] = true
set :branch, "master"

# Use a remote cache to speed things up
set :deploy_via, :remote_cache

# Get the submodules
set :git_enable_submodules, 1

# Multistage support - see config/deploy/[STAGE].rb for specific configs
set :default_stage, "production"
set :stages, %w(production)
 
# Generally don't need sudo for this deploy setup
set :use_sudo, false

# figure out username of current user
case `whoami`.chomp
when "dbarbarisi"
	set :user, "david"
else
#	set(:user) do
#	   Capistrano::CLI.ui.ask "Enter SSH username: "
#	end
end

# set :user, "dummy"

####
