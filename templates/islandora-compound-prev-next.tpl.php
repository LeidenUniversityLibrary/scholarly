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

 <?php if (count($themed_siblings) > 0): ?>
   <?php $query_params = drupal_get_query_parameters(); ?>
   <ul class="dc-grid dc-grid-compound dc-compound-items islandora-compound-thumbs">
   <?php foreach ($themed_siblings as $sibling): ?>
     <li class="dc-grid-item islandora-compound-thumb">
     <?php
       print l(
       '<div class="dc-grid-pic">'.theme_image(
         array(
           'path' => $sibling['TN'],
           'attributes' => array('class' => 'dc-object-fit'),
         )
       ).'</div><h4>'.$sibling['shortlabel'].'</h4>',
       'islandora/object/' . $sibling['pid'],
       array('attributes' => array('title' => $sibling['label']),'html' => TRUE, 'query' => $query_params)
     );?>
     </li>
   <?php endforeach; // each themed_siblings ?>
   </ul> <!-- //dc-compound-items islandora-compound-thumbs -->
 <?php endif; // count($themed_siblings) > 0 ?>
 </div>
