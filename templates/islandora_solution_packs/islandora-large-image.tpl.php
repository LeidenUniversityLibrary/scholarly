<?php

/**
 * @file
 * This is the template file for the object page for large image
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file
 * - $islandora_dublin_core: The DC datastream object
 * - $dc_array: The DC datastream object values as a sanitized array. This
 *   includes label, value and class name.
 * - $islandora_object_label: The sanitized object label.
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 * - $islandora_thumbnail_img: A rendered thumbnail image.
 * - $islandora_content: A rendered image. By default this is the JPG datastream
 *   which is a medium sized image. Alternatively this could be a rendered
 *   viewer which displays the JP2 datastream image.
 *
 * @see template_preprocess_islandora_large_image()
 * @see theme_islandora_large_image()
 */
?>
<section class="dc-viewer">
  <div class="islandora-large-image-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="ImageObject">
    <div class="islandora-large-image-content-wrapper clearfix islandora-viewer">
      <?php if ($islandora_content): ?>
        <?php if (isset($image_clip)): ?>
          <?php //print $image_clip; ?>
        <?php endif; ?>
        <div class="islandora-large-image-content">
          <?php print $islandora_content; ?>
        </div>
      <?php endif; ?>
    </div>
    <?php
    //Render the compound navigation block
    $block = module_invoke('islandora_compound_object', 'block_view', 'compound_navigation');
    print render($block['content']);
    ?>
  </div>
</section>
  <div class="islandora-large-image-metadata islandora-metadata">
    <?php print $description; ?>
    <div class="dc-sidebox dc-sidebox-right">
      <?php

      // Render the detail tools block
      $block = module_invoke_all('detail_tools_block_view');

      $block['list']['#type'] = 'ul';
      $block['list']['#theme'] = 'item_list';

      if (isset($block['list']['#attributes']['class'])) {
        $block['list']['#attributes']['class'] = array_unique($block['list']['#attributes']['class']);
      }

      print render($block);
      ?>
      <?php if ($parent_collections): ?>
      <div>
        <h3 class="dc-sidebox-header"><?php print t('In collections'); ?></h3>
        This item can be found in the following collections:
        <ul class="dc-related-searches">
          <?php foreach ($parent_collections as $collection): ?>
            <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    </div>
    <div class="dc-box">
      <H3><?php print t('Description'); ?></H3>
      <?php print $metadata; ?>
    </div>
  </div>

