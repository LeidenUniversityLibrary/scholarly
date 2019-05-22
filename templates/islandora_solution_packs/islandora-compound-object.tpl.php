<?php
/**
 * @file
 * This is the template file for the object page for compound objects.
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file.
 * - $islandora_thumbnail_img: The thumbnail image of the compound object.
 * - $description: Defined metadata descripton for the object.
 * - $parent_collections: Parent collections of the object if applicable.
 * - $metadata: Rendered metadata display for the compound object.
 *
 * @see template_preprocess_islandora_compound_object()
 * @see theme_islandora_compound_object()
 */
?>

<div class="islandora-compound-object-object islandora">
  <div class="islandora-compound-object-content-wrapper clearfix">
    <?php if (isset($islandora_thumbnail_img)): ?>
      <div class="islandora-compound-object-content">
        <?php print $islandora_thumbnail_img; ?>
      </div>
    <?php endif; ?>
  </div>
    <?php print $metadata; ?>
  <?php print $description; ?>

</div>

