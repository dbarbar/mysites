load 'deploy' if respond_to?(:namespace) # cap2 differentiator

# added to avoid server complaining about SUDO commands
# (http://www.mail-archive.com/capistrano@googlegroups.com/msg04755.html)
default_run_options[:pty] = true

require 'rubygems'
require 'railsless-deploy' # Removes railsisms from Capistrano
require 'capistrano/ext/multistage' # enables dev/qa/production staged deploy

load 'config/deploy' # remove this line to skip loading any of the default tasks

after "deploy:setup", "deploy:post_setup"
after "deploy:update_code", "deploy:post_update_code"

set :drush, "/usr/local/bin/drush"

namespace :deploy do

  # Overwritten to provide flexibility for people who aren't using Rails.
  desc "Prepares one or more servers for deployment."
  task :setup, :except => { :no_release => true } do
    dirs = [deploy_to, releases_path, shared_path]
    domains.each do |domain|
      dirs += [shared_path + "/#{domain}/shared"]
    end
    dirs += static_dirs.map { |d| File.join(shared_path, d) }
    run "umask 02 && mkdir -p #{dirs.join(' ')}"
  end

  desc "Set up symlink from web root to current revision"
  task :post_setup do
    # sudo "rm -rf #{web_path}"
    # fail if dir exists
    sudo "ln -s #{deploy_to}/current #{web_path}"
    sudo "chown -R #{shared_path}/files #{apache_user}" if static_dirs.include? "files"

  end

  desc "link file dirs"
  task :post_update_code do
    domains.each do |domain|
      # link settings file
      run "ln -nfs #{deploy_to}/#{shared_dir}/#{domain}/settings.php #{release_path}/sites/#{domain}/settings.php"
      # remove any link or directory that was exported from SCM, and link to remote Drupal filesystem
      static_dirs.each do |dir|
        run "rm -rf #{release_path}/#{dir}"
        run "ln -nfs #{deploy_to}/#{shared_dir}/#{dir} #{release_path}/#{dir}"
      end
#      sudo "chown #{apache_user} -R #{release_path}/jobs/_cache"
#      sudo "chown #{apache_user} -R #{release_path}/jobs/uploads"
    end
  end

  # desc '[internal] Touches up the released code.'
  task :finalize_update, :except => { :no_release => true } do
    run "chmod -R g+w #{release_path}"
    sudo "chmod -R +x #{release_path}/scripts"
    sudo "chmod -R g+w #{shared_path}/cached-copy" if deploy_via == :remote_cache
  end

  desc "Flush the Drupal cache system."
  task :cacheclear, :roles => :db, :only => { :primary => true } do
    domains.each do |domain|
      run "#{drush} --uri=#{domain} cache clear"
    end
  end

  namespace :web do
    desc "Set Drupal maintainance mode to online."
    task :enable do
      domains.each do |domain|
        php = 'variable_set("site_offline", FALSE)'
        run "#{drush} --uri=#{domain} eval '#{php}'"
      end
    end

    desc "Set Drupal maintainance mode to off-line."
    task :disable do
      domains.each do |domain|
        php = 'variable_set("site_offline", TRUE)'
        run "#{drush} --uri=#{domain} eval '#{php}'"
      end
    end
  end

  # after "deploy", "deploy:cacheclear"
  after "deploy", "deploy:cleanup"
  after "deploy", "deploy:restart"


  # Each of the following tasks are Rails specific. They're removed.
  task :migrate do
  end

  task :migrations do
  end

  task :cold do
  end

  task :start do
  end

  task :stop do
  end

  task :restart do
    sudo "/sbin/apachectl graceful"
  end

end


desc "Download a backup of the database(s) from the given stage."
task :download_db, :roles => :db, :only => { :primary => true } do
  # filename = "#{domain}_#{stage}.sql"
  run "#{drush} -r #{web_path} dump-site"
  sudo "rm /tmp/dbdump.sql.gz"
  run "gzip /tmp/dbdump.sql"
  download("/tmp/dbdump.sql", "#{filename}", :via=> :scp)
  #end
end
