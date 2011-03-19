<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language ?>" lang="<?php print $language ?>">
  <head>
    <title><?php print $head_title ?></title>
    <?php print str_replace('http://www.davidbarbarisi.com/rss.xml', 'http://feeds.feedburner.com/davidbarbarisi', $head) ?>
    <?php print $styles ?>
    <?php print $scripts ?>
  </head>

<body>
<div id="header">
      <?php if ($site_name) { ?><h1 class='site-name'><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print $site_name ?></a></h1><?php } ?>
      <?php if ($site_slogan) { ?><div class='site-slogan'><?php print $site_slogan ?></div><?php } ?>
<div id="menu">
      <?php if (isset($secondary_links)) { ?><div id="secondary"><?php print theme('links', $secondary_links) ?></div><?php } ?>
      <?php if (isset($primary_links)) { ?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php } ?>
      <?php print $search_box ?>
</div>
	  <div><?php print $header ?></div>
</div>
	  
<div id="content">
    <?php if ($sidebar_left) { ?><div id="sidebar-left">
      <?php print $sidebar_left ?>
    </div><?php } ?>
    <?php if ($sidebar_right) { ?><div id="sidebar-right">
      <?php print $sidebar_right ?>
    </div><?php } ?>
	<div>
      <?php if ($mission) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
      <div id="main">
        <h2 class="title"><?php print $title ?></h2>
        <div class="tabs"><?php print $tabs ?></div>
        <?php print $help ?>
        <?php print $messages ?>
        <?php print $content; ?>
      </div>
</div>

</div>
<div id="footer">
  <?php print $footer_message ?>
</div>
<?php print $closure ?>
</body>
</html>
