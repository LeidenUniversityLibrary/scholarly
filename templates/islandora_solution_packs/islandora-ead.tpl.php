<?php

/**
 * @file
 * This is the template file for the object page for ead
 *
 * Available variables:
 * - $islandora_object: An Islandora object
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 * - $islandora_thumbnail_img: A rendered thumbnail image.
 * - $islandora_content: A rendered image. By default this is the JPG datastream
 *   which is a medium sized image. Alternatively this could be a rendered
 *   viewer which displays the JP2 datastream image.
 *
 * @see template_preprocess_islandora_ead()
 * @see theme_islandora_ead()
 */
?>

  <div class="islandora-ead-metadata islandora-metadata">
    <?php print $description; ?>
  <div class="islandora-ead-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="EADObject">
    <div class="islandora-ead-content-wrapper islandora-viewer">
      <?php print $content['narrative']; ?>
    </div>
  </div>
    <div class="dc-sidebox dc-sidebox-right">
      <?php

      // Render the detail tools block
      $block = module_invoke_all('detail_tools_block_view');

      $block['list']['#type'] = 'ul';
      $block['list']['#theme'] = 'item_list';

      if (isset($block['list']['#attributes']['class'])) {
        $block['list']['#attributes']['class'] = array_unique($block['list']['#attributes']['class']);
      }

      // Add the print button
      $block['list']['#items'][] = l(
          '<span>print</span><i class="fa fa-print" aria-hidden="true"></i>',
          'javascript:window.print();',
          array('attributes' => array('title' => 'print'),'html' => TRUE, 'external' => TRUE)
      );

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

