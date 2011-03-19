  <div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
  <?php if ($picture) {
      print $picture;
    }?>
<!-- google_ad_section_start -->
    <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
	<div class="submitted"><?php print $submitted?></div>
    <div class="taxonomy">Tags: <?php print $terms?></div> 
<?php if ($links) { ?><div class="links"><?php print $links?></div><?php }; ?> 
	<div class="content"><?php print $content?></div>
<!-- google_ad_section_end -->
	<?php /*
        if ($node->can_receive) {
          $url = url('node/'. $node->nid, NULL, NULL, TRUE);
          $tb_url = url('trackback/'. $node->nid, NULL, NULL, TRUE);
          $autodetect_comments .= "\n<!--\n";
          $autodetect_comments .= "<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:trackback=\"http://madskills.com/public/xml/rss/module/trackback/\">\n";
          $autodetect_comments .= "<rdf:Description rdf:about=\"$url\" dc:identifier=\"$url\" dc:title=\"$node->title\" trackback:ping=\"$tb_url\" />\n";
          $autodetect_comments .= "</rdf:RDF>\n";
          $autodetect_comments .= "-->\n";
        }
print $autodetect_comments;
*/
?>	

  <?php if ($page != 0) { ?>
  	<!-- feedburner -->
	<script src="http://feeds.feedburner.com/~s/davidbarbarisi?i=http://www.davidbarbarisi.com<?php print $node_url ?>" type="text/javascript" charset="utf-8"></script>
	<!-- end feedburner -->

	<div class="googleads">
<script type="text/javascript"><!--
google_ad_client = "pub-1291886954282409";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
//2006-09-28: blog entries
google_ad_channel ="1569274265";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php } ?>

<?php
/*
    if($page!=0)
    {

        $previous_node_link = previous_node($node, NULL, '&lt;&lt; ', NULL);
        $next_node_link = next_node($node, NULL, NULL, ' &gt;&gt;');   
       
        print '<div class="previous-next-links">';
        if($previous_node_link && $next_node_link)
        {
            print $previous_node_link.' | '.$next_node_link;
        }
        else if($previous_node_link)
        {
            print $previous_node_link;
        }
        else if($next_node_link)
        {
            print $next_node_link;
        }
        print '</div>';


print theme('box', t('Trackback URL:'), url('trackback/'. $node->nid, NULL, NULL, TRUE));
$trackbacks = '';
            if ($node->can_receive && count($node->trackbacks_received)) {
              foreach ($node->trackbacks_received as $tr) {
                $trackbacks .= theme('trackback', $tr);
              }
print theme('trackbacks',$trackbacks);
            }	
    }
*/
	?> 
	</div>
