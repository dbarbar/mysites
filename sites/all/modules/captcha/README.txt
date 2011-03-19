$Id: README.txt,v 1.13.2.1.2.2 2007/07/13 17:44:33 robloach Exp $

### Captcha Readme

captcha.module is the basic captcha module that offers general captcha
adminstration and a simple math captcha challenge.

text_captcha offers another simple text based captcha challenge.

image_captcha offers an image based captcha challenge.

Installation:
  Installation is like all normal modules (e.g. extract in the directory sites/all/modules)
  The basic captcha module has no dependencies, so nothing special is required.
  If you had an old version of the captcha module installed, it is possible
  that you need to uninstall and reinstall this captcha module after
  overwriting/upgrading from the previous version.

Configuration:
  The configuration page is at admin/settings/captcha, here you can configure
  the captcha module and enable captchas for the desired forms.

Caching:
  Captcha interacts with page caching (admin/settings/performance). A captcha
  prevents caching of pages on which it appears. You need to make sure forms
  with a captcha do not appear on too many pages, or cache will be effectively
  off. The comment submission form is the cause for most concern. Make sure you
  set the "Location of comment submission form" to "Display on separate page"
  on Administer » Content management » Comments, tab Settings
  (admin/content/comment/settings) or your content will no longer be cached.
