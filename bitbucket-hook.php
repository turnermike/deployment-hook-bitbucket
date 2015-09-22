<?php
/**
 *
 * Source tutorial: http://jonathannicol.com/blog/2013/11/19/automated-git-deployments-from-bitbucket/
 * - mad props to that dude!
 *
 *
 * 1. Clone the repo a level up from the public/www directory, but rename it for 'STAGING'
 * $ git clone --mirror git@username/repo-name.git repo-name-STAGING.git
 *
 * 2. Set a GIT_WORK_TREE for the public staging directory
 * $ cd repo-name-STAGING.git
 * $ GIT_WORK_TREE=/path/to/public/dir/ git checkout -f staging
 *
 * 3. Clone the (same) repo a level up from the public/www directory, but rename it for 'PRODUCTION'
 * $ git clone --mirror git@username/repo-name.git repo-name-PRODUCTION.git
 *
 * 4. Set a GIT_WORK_TREE for the public production directory
 * $ cd repo-name-PRODUCTION.git
 * $ git clone --mirror git@username/repo-name.git repo-name-PRODUCTION
 *
 * 5. SSH to server and create the following within the public/www directory for the staging location:
 * $ mkdir deploy && cd deploy
 * $ touch deploy.log
 * $ touch deployment-hook-staging.php
 * $ touch index.html (for security)
 *
 * 6. Copy this script to deployment-hook-staging.php
 *
 * 7. Change the $repo_dir and $web_root_dir variables accordingly
 *
 * 8. Set the 'Webhook' at BitBucket:
 * - browse to the repo
 * - click the Settings (gear) icon
 * - click Webhooks
 * - click Add Webhook
 * - type 'Staging' in the Title field
 * - type the URI to the staging deployment script (/var/www/vhosts/domain.ca/deploy/deployment-hook-staging.php)
 *
 * 9. Repeat steps 5-8 for 'production'
 *
 * This document is not complete.
 *
 */

// command to set work tree after clone to non-public directory
// GIT_WORK_TREE=/home/<username>/www git checkout -f production

$repo_dir = '/var/www/vhosts/ristaging.ca/buckleys-outbreak.git';
$web_root_dir = '/var/www/vhosts/ristaging.ca/buckleys-outbreak.ristaging.ca';

// Full path to git binary is required if git is not in your PHP user's path. Otherwise just use 'git'.
$git_bin_path = 'git';

$update = false;

// Parse data from Bitbucket hook payload
$payload = json_decode($_POST['payload']);

if (empty($payload->commits)){
  // When merging and pushing to bitbucket, the commits array will be empty.
  // In this case there is no way to know what branch was pushed to, so we will do an update.
  $update = true;
} else {
  foreach ($payload->commits as $commit) {
    $branch = $commit->branch;
    if ($branch === 'staging' || isset($commit->branches) && in_array('staging', $commit->branches)) {
      $update = true;
      break;
    }
  }
}

if ($update) {
  // Do a git checkout to the web root
  exec('cd ' . $repo_dir . ' && ' . $git_bin_path  . ' fetch');
  exec('cd ' . $repo_dir . ' && GIT_WORK_TREE=' . $web_root_dir . ' ' . $git_bin_path  . ' checkout -f');

  // Log the deployment
  $commit_hash = shell_exec('cd ' . $repo_dir . ' && ' . $git_bin_path  . ' rev-parse --short HEAD');
  file_put_contents('deploy.log', date('m/d/Y h:i:s a') . " Deployed branch: " .  $branch . " Commit: " . $commit_hash . "\n", FILE_APPEND);
}
?>