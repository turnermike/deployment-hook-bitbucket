See the comments at the top of bitbucket-hook.php for instructions.

# Bitbucket Webhooks Script

## Staging Setup

1. Login to your server via SSH.

2. Clone the repo a level up from the public/www directory, but rename it for 'STAGING'

        $ git clone --mirror git@username/repo-name.git repo-name-STAGING.git

3. Set a GIT_WORK_TREE for the public staging directory

        $ cd repo-name-STAGING.git
        $ GIT_WORK_TREE=/path/to/public/dir/ git checkout -f staging

4. Create a directory within the public/www directory named ".deployment09222015". The numerals on the end are just today's date, used for security purposes. You can use whatever you like, just try to hide the directory from trouble makers.

        $ mkdir .deployment09222015

5. Create the following within the public/www/.deployment09222015 directory for the staging location:

        $ cd .deployment09222015
        $ touch deploy.log
        $ touch deployment-hook.php
        $ touch index.html (for security)
        $ echo '<p>nothing to see here</p>' > index.html

6. Copy the contents of deployment-hook.php from the repository, to the deployment-hook.php file created in step 4.

    To edit the file via bash terminal use:

        $ nano deployment-hook.php

7. Change the $repo_dir and $web_root_dir variables accordingly within deployment-hook.php.

8. Set the 'Webhook' at Bitbucket:

    1. Browse to the repo at Bitbucket
    2. Click the Settings (gear) icon
    3. Click Webhooks
    4. Click Add Webhook
    5. Type 'Staging' in the Title field
    6. Type the URI to the staging deployment script. For example:

            http://domain.ca/.deployment09222015/deployment-hook.php

    7. Leave the Triggers radio button set to "Repository push"
    8. Click the Save button.

## Staging Deployment

Simply push your updates to the "staging" branch. The updates should be pushed to the server instantly.

If you're experiencing problems, or the deployment isn't working, start by looking at the Bitbucket status page here: http://status.bitbucket.org

You may also monitor your deployment hook activity by following these steps:

1. Browse to the repo at Bitbucket
2. Click the Settings (gear) icon
3. Click Webhooks
4. Click View Requests


## Credits
* Source tutorial: http://jonathannicol.com/blog/2013/11/19/automated-git-deployments-from-bitbucket/
* Bitbucket Webhooks documentation: https://confluence.atlassian.com/bitbucket/manage-webhooks-735643732.html
