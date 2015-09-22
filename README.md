See the comments at the top of bitbucket-hook.php for instructions.

# Bitbucket Webhooks Script

## Staging Setup

1. Clone the repo a level up from the public/www directory, but rename it for 'STAGING'

        $ git clone --mirror git@username/repo-name.git repo-name-STAGING.git

2. Set a GIT_WORK_TREE for the public staging directory

        $ cd repo-name-STAGING.git
        $ GIT_WORK_TREE=/path/to/public/dir/ git checkout -f staging

3. Create a directory within the public/www directory named ".deployment09222015". The numerals on the end are just today's date, used for security purposes.

        $ mkdir .deployment09222015

4. Create the following within the public/www/.deployment09222015 directory for the staging location:

        $ touch deploy.log
        $ touch deployment-hook.php
        $ touch index.html (for security)
        $ echo '<p>nothing to see here</p>' > index.html










# Credits
* Source tutorial: http://jonathannicol.com/blog/2013/11/19/automated-git-deployments-from-bitbucket/