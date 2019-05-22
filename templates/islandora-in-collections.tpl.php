<?php

/**
 * @file
 * The In Collections Block template.
 *
 * Available variables:
 * - $collections: Parent collections of the object if applicable.
 *
**/
?>

<?php if ($collections): ?>
<p>This item can be found in the following collections:</p>
<ul>
  <?php foreach ($collections as $collection): ?>
    <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

