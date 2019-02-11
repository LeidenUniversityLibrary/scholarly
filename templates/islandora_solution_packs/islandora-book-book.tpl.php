<?php
/**
 * @file
 * Template file to style output.
 */

?>

<?php if(isset($viewer)): ?>
  <div id="book-viewer">
    <?php print $viewer; ?>
  </div>
<?php endif; ?>
<?php
//Render the compound navigation block
$block = module_invoke('islandora_compound_object', 'block_view', 'compound_navigation');
print render($block['content']);
?>

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
      <?php print t('This item can be found in the following collections:'); ?>
      <ul class="dc-related-searches">
        <?php foreach ($parent_collections as $collection): ?>
          <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>
<div class="dc-box">
<?php if($display_metadata === 1): ?>
  <H3><?php print t('Description'); ?></H3>
  <?php print $description; ?>
  <?php print $metadata; ?>
</div>
<?php endif; ?>
