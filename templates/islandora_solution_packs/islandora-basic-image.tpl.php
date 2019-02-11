<?php

/**
 * @file
 * This is the template file for the object page for basic image
 *
 * @TODO: add documentation about file and available variables
 */
?>

<div class="islandora-basic-image-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="ImageObject">
  <div class="islandora-basic-image-content-wrapper clearfix islandora-viewer">
    <?php if (isset($islandora_content)): ?>
      <div class="islandora-basic-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php
  //Render the compound navigation block
  $block = module_invoke('islandora_compound_object', 'block_view', 'compound_navigation');
  print render($block['content']);
  ?>
  <div class="islandora-basic-image-metadata islandora-metadata">
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
</div>
