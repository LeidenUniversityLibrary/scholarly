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
<ul class="dc-grid dc-grid-related">
  <?php foreach ($rows as $id => $row): ?>
    <li class="dc-grid-item">
      <?php print $row; ?>
    </li>
  <?php endforeach; ?>
</ul>
