################################################################################
## Setup Environment
################################################################################

# The Git branch this environment should be attached to.
set :branch, 'master'

# The environment's name. To be used in commands and other references.
set :stage, :staging

# The URL of the website in this environment.
set :stage_url, 'http://puffadvisor.nickzack.space/'

# The environment's server credentials
server '155.138.133.187', user: 'nickey22', roles: %w(web app db)

# The deploy path to the website on this environment's server.
set :deploy_to, '/var/www/html/sites/staging/puffadvisor'

# The web user on this environment's server.
set :web_user, 'www-data'
