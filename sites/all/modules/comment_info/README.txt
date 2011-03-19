$Id: README.txt,v 1.1.2.1.2.2 2007/02/23 20:20:50 mfer Exp $

Overview
---------
This module allows for anonymous guests to keep persistent comment info 
This is an opt-in feature that will prevent an active anonymous
commenter from having to re-enter their info each time.

Requirements
------------
* Drupal 5.0 or later

Methods
-------
There are 2 methods for storing the anonymous guest information
1) The PHP session.  This is the default method.
2) Using jQuery and cookies.  This method will only work in browsers
with javascript.  This is the prefered method to use with page caching.

See admin >> Settings >> Comment Info for more information.

Authors
-------
Kenn Persinger (cainan) <lestat@iglou.com>
Matt Farina (mfer) <http://drupal.org/user/25701/contact>