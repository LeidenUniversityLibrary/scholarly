<?php

/**
 * @file
 * Template file for default facets
 *
 * @TODO document available variables
 */
?>
<div id="dc-facet-keywords" class="dc-facet-list dc-checklist <?php print $classes; ?>">
  <?php foreach($buckets as $key => $bucket): ?>
    <label>
      <?php print $bucket['link']; ?>
      <span class="count">(<?php print $bucket['count']; ?>)</span>
      <span class="plusminus">
        <?php print $bucket['link_plus']; ?>
        <?php print $bucket['link_minus']; ?>
      </span>
    </label>
  <?php endforeach; ?>
</div>


