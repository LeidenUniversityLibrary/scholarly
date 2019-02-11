<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="dc-feat-more">
  <a href='/islandora/search?type=dismax&islandora_solr_search_navigation=0&f[0]=RELS_EXT_isMemberOfCollection_uri_ms%3A"info\%3Afedora\/collection\%3A<?php $arg2exp = explode(':', arg(2)); if (isset($arg2exp[1])) { print $arg2exp[1]; } ?>"'>
  <span><i class="fa fa-chevron-circle-right"></i>show all items</span>
  </a>
</div>
<ul>
  <?php foreach ($rows as $id => $row): ?>
    <li<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
      <?php print $row; ?>
    </li>
  <?php endforeach; ?>
</ul>
