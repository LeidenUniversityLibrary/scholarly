<?php
/**
 * @file
 * Islandora solr search navigation block.
 *
 * Variables available:
 * - $return_link: link to reutrn to original search.
 * - $prev_link: Link to previous object in search result.
 * - $next_link: link to next object in the search result.
 *
 */

function uvl_replace_icon($link, $icon, $text) {
  $iconhtml = '><span>' . $text . '</span><i class="fa fa-' . $icon . '" aria-hidden="true"></i><';
  if ($link) {
    return preg_replace('/>.+</', $iconhtml, $link);
  }
  else {
    return "<A href=\"#\" class=\"disabled\"$iconhtml/A>";
  }
}
?>


<div id="islandora-solr-search-prev-link"><?php print uvl_replace_icon($prev_link, 'arrow-left', '< Prev'); ?></div>
<div id="islandora-solr-search-return-link"><?php print uvl_replace_icon($return_link, 'arrow-up', 'Results'); ?></div>
<div id="islandora-solr-search-next-link"><?php print uvl_replace_icon($next_link, 'arrow-right', 'Next >'); ?></div>


