<?php

/**
 * @file
 * islandora-compound-object-prev-next.tpl.php
 *
 * @TODO: needs documentation about file and variables
 * $parent_label - Title of compound object
 * $child_count - Count of objects in compound object
 * $parent_url - URL to manage compound object
 * $previous_pid - PID of previous object in sequence or blank if on first
 * $next_pid - PID of next object in sequence or blank if on last
 * $siblings - array of PIDs of sibling objects in compound
 * $siblings_detailed - array of PIDs (key) and details (value) of sibling objects in compound
 * $themed_siblings - array of siblings of model
 *    array(
 *      'pid' => PID of sibling,
 *      'label' => label of sibling,
 *      'TN' => URL of thumbnail or default folder if no datastream,
 *      'class' => array of classes for this sibling,
 *    )
 */

?>
 <div class="islandora-compound-prev-next">

 <?php if (!empty($previous_pid)): ?>
   <?php //print l(t('Previous'), 'islandora/object/' . $previous_pid); ?>
 <?php endif; ?>
 <?php if (!empty($previous_pid) && !empty($next_pid)): ?>
 <?php endif;?>
 <?php if (!empty($next_pid)): ?>
   <?php //print l(t('Next'), 'islandora/object/' . $next_pid); ?>
 <?php endif; ?>

 <?php if (count($siblings_detailed) > 0): ?>
   <?php $query_params = drupal_get_query_parameters(); ?>
   <ul class="dc-grid dc-grid-compound dc-compound-items islandora-compound">
   <?php foreach ($siblings_detailed as $pid => $sibling): ?>
     <li class="<?php if (isset($sibling['view_class'])) { print $sibling['view_class']; } ?>">
     <ul>
     <?php if (isset($sibling['view_url'])): ?>
       <li class="ubl-file-download"><?php print l('Download', $sibling['download_url']); ?></li>
       <li class="ubl-file-view">
         <?php print l(scholarly_filter_metadata($sibling['title']), $sibling['view_url'], array('attributes' => array('target' => '_blank'))); ?>
       </li>
     <?php endif; ?>
     <?php if (!isset($sibling['view_url'])): ?>
       <li class="ubl-file-view ubl-not-accessible">
         <?php print scholarly_filter_metadata($sibling['title']); ?>
       </li>
     <?php endif; ?>
     <?php if (isset($sibling['version']) && $show_version): ?>
     <li class="ubl-file-version">
         <?php print scholarly_filter_metadata($sibling['version']); ?>
     </li>
     <?php endif; ?>
     <li class="ubl-file-remarks ubl-embargo <?php if (isset($sibling['embargo_class'])) { print $sibling['embargo_class']; } ?>">
       <?php if (isset($sibling['embargo_text'])) { print scholarly_filter_metadata($sibling['embargo_text']); } ?>
       <?php if (isset($sibling['license_url'])): ?>
         <?php $options = array(
                 'path' => '/sites/all/themes/scholarly/img/' . $sibling['license_type'] . '.png',
                 'title' => scholarly_filter_metadata($sibling['license_text']),
                 'alt' => $sibling['license_type'],
                 'attributes' => array('class' => 'ubl-file-license'),
               ); ?>
         <?php $licenseimg = theme('image', $options); ?>
         <?php print l($licenseimg, $sibling['license_url'], array('html' => TRUE, 'external' => TRUE, 'attributes' => array('target' => '_blank'))); ?>
       <?php endif; ?>
     </li>
     <?php if (isset($sibling['doi'], $sibling['doi_url'])): ?>
     <li class="ubl-file-doi">
       <?php print l(t('Full text at publishers site'), $sibling['doi_url'], array(
              'attributes' => array('class' => array('ubl-external-link'), 'title' => $sibling['doi'], 'target' => '_blank'),
       )); ?>
     </li>
     <?php endif; ?>
     </ul>
     </li>
   <?php endforeach; // each themed_siblings ?>
   </ul> <!-- //dc-compound-items islandora-compound-thumbs -->
 <?php endif; // count($themed_siblings) > 0 ?>
 </div>
