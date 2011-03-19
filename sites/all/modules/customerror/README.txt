$Id: README.txt,v 1.6 2006/12/25 23:44:48 kbahey Exp $

Copyright 2005 http://2bits.com

Description
-----------
This module allows the site admin to create custom error pages for
404 (not found), and 403 (access denied).

Since the error pages are not real nodes, they do not belong a category
term, and hence will not show up in node listings.

Features
--------
* Configurable page title and descriptions.
* Any HTML formatted text can be be put in the page body.
* Handles 404 and 403 errors at present. Drupal only allows those two
  errors to be assigned custom pages. The design of this module is 
  flexible though and can accommodate future codes easily.
* The pages are themeable using the phptemplate_customerror() function
  in the template.php. The first argument is the error code (currently
  403 or 404), and the message content.
* The messages can contain PHP, using one of two methods:
  - By using the phptemplate_customerror() function (see above).
  - By using the PHP checkbox in the settings.
* Users who are not logged in and try to access an area that requires
  login will be redirected to the page they were trying to access after
  they login.
  (Requires a minor change to common.inc, see INSTALL.txt for details).

Database
--------
This module does not require any new database tables to be installed.

Installation:
-------------
Please see the INSTALL.txt document for details.

Bugs/Features/Patches
---------------------
If you want to report bugs, feature requests, or submit a patch, please do so
at the project page on the Drupal web site.
http://drupal.org/project/customerror

Author
------

Khalid Baheyeldin (http://baheyeldin.com/khalid and http://2bits.com)

If you use this module, find it useful, and want to send the author
a thank you note, then use the Feedback/Contact page at the URL above.

The author can also be contacted for paid customizations of this
and other modules.
