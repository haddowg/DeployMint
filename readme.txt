=== Plugin Name ===
Contributors: ammmze
Donate link:
Tags: deploy, staging, multi-site, multisite
Requires at least: 3.0.1
Tested up to: 3.4.2
Stable tag: 2.3.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A staging and deployment system for WordPress

== Description ==

DeployMint allows you to create a snapshot of your site and quickly and easily deploy it to another site, while leaving comments in-place.

Managing Blogs
--------------

This is only applicable to single-site mode (when in multi-site mode, we use the blogs as defined by current wordpress network). In single-site mode, we need to define the blogs that should be available to us.

* Enter the name for the blog (currently doesn't really do anything for you, since we still just show the url)
* Optionally ignore SSL certificate errors when making an XML-RPC request.
* Enter the Blog URL. You may optionally omit the 'http://' portion. If omitted, we will use 'https://'


Creating a Project
------------------

A Project is a group of blogs which will share snapshots. You will be able to create a snapshot of one blog within the project, and then deploy that snapshot to another blog within that same project.

* From the DeployMint admin, go to 'Manage Projects'
* Enter a name for the project...anything you like
* Enter the Git Origin location
    * This is where we will fetch/pull/push snapshots to. This should be accessible by all blogs within the project. If you are running in Multi-Site mode, you don't **need** to use this option.
* Add whichever blogs you want to the project.
    * Note: When in single-site mode, you will prompted for a username and password. This username and password should be valid for all blogs within the project. (For those who want to know what is happening here...we are making an XML-RPC request to all the blogs within the project with the updated project information, including the blogs that are associated with the project)


Creating a Snapshot
-------------------

Once a project is all setup, you may go to the project page, where you can select the blog to create snapshot. This basically makes a dump of the primary wordpress tables and copys all the themes, plugins and uploads/blogs.dir and stores it all in a branch within the git repo. If an origin is specified, it is also pushed to the origin. Note: themes and plugins are only copied in single-site mode, since in multi-site they are all shared between sites. When in single-site mode, you will be asked for a login, this is the login of the blog you are taking the snapshot of.


Deploying a Snapshot
--------------------

Once a snapshot has been created, you will see it in the list of available snapshots. You can select what to deploy (database tables, uploads, themes or plugins). Then specify which blog to deploy to. When in single-site mode, you will be asked for a login, this is the login of the blog you are deploying to.


Emergency Revert
----------------

This is currently only available in the multi-site mode. This will restore your entire wordpress network as it was prior to deploying a snapshot.

== Installation ==

* Upload all files within wp-content/plugins/DeployMint
* Within WordPress Admin, go to Plugins and Activate the plugin 'DeployMint'
* Update DeployMint options
    * In multi-site mode, the options are in the network admin, and available only to network admins
    * In single-site mode, the options are located in the top-level wordpress admin and are available only to admins.

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 2.3.2 =
* Enhancement: Blogs are now editable in the Manage blogs
* Enhancement: Blog names are now shown instead of urls

= 2.3.1 =
* Fixed: Support PHP 5.4
* Refactor: Removed un-necessary use prepare method

= 2.3.0 =
* Enhancement: Snapshots include all tables with the specified db prefix
* Enhancement: Paths to plugins, themes, etc are no longer hard coded
* Fixed: Url's in postmeta table are not fixed
* Fixed: Deploying to a host with a different database prefix loses user permission

= 2.2.2 =
* Include must-use plugins
* Fix custom table deployments

= 2.2.1 =
* Fixed clicking anywhere in deploy started archive process
* User tables are included in snapshots
* Single site will now deploy user tables (eventually will make it an option)

= 2.2.0 =
* Added ability to archive snapshots

= 2.1.1 =
* Fix bugs with editing origin and tables.
* Filter custom tables that are empty

= 2.1.0 =
* Added ability to specify additional tables to include in the snapshots
* Make use of WordPress dbDelta method to update database schema

= 2.0.0 =
* First released version with single site support

= 1.2 =
* Latest version by Mark Maunder

== Upgrade Notice ==

= 2.0.0 =
Lots of new features. Single site support. If you are running an un-released version from Mark Maunder, you will need to uninstall it and remove all the dep_* tables.

