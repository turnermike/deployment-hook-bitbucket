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

5. Copy the contents of deployment-hook.php from the repository, to the deployment-hook.php file created in step 4.

6. Change the $repo_dir and $web_root_dir variables accordingly within deployment-hook.php.

8. Set the 'Webhook' at BitBucket:
    1. Browse to the repo
    2. Click the Settings (gear) icon
    3. Click Webhooks
    4. Click Add Webhook
    5. Type 'Staging' in the Title field
    6. Type the URI to the staging deployment script. For example:
        http://domain.ca/.deployment09222015/deployment-hook.php









## Credits
* Source tutorial: http://jonathannicol.com/blog/2013/11/19/automated-git-deployments-from-bitbucket/