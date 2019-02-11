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
 <div class="islandora-compound-prev-next islandora-compound-prev-next--hierarchical table-of-contents">

 <?php if (!empty($previous_pid)): ?>
   <?php //print l(t('Previous'), 'islandora/object/' . $previous_pid); ?>
 <?php endif; ?>
 <?php if (!empty($previous_pid) && !empty($next_pid)): ?>
 <?php endif;?>
 <?php if (!empty($next_pid)): ?>
   <?php //print l(t('Next'), 'islandora/object/' . $next_pid); ?>
 <?php endif; ?>

 <?php if (count($themed_siblings) > 0): ?>
   <h3 class="toc-header">
     Table of Contents
     <A href="#" title="close table of contents" id="closetoc">
       <i class="fa fa-close" aria-hidden="true"></i>
     </A>
  </h3>
  <div class="toc-content dc-compound-items islandora-compound-thumbs">
   <ul>
   <?php
     $hierarchical = array();
     foreach ($themed_siblings as $sibling) {
       $hier = &$hierarchical;
       $level = $sibling['relation'];
       $lps = explode('.', $level);
       foreach ($lps as $lp) {
         if (!isset($hier['children'])) {
           $hier['children'][$lp] = array();
         } 
         $hier = &$hier['children'][$lp];
       }
       foreach ($sibling as $k => $v) {
         $hier[$k] = $v;
       }
     }
    
     $display_level = function($children) use (&$display_level) {
       $query_params = drupal_get_query_parameters();
       foreach ($children as $child) {
         print '<li class="dc-grid-item islandora-compound-thumb">';
         if (isset($child['label'], $child['pid'])) {
           print l($child['label'], 'islandora/object/' . $child['pid'], array('attributes' => array('title' => $child['label']), 'query' => $query_params)); 
         }
         if (isset($child['children'])) {
           print '<ul>';
           $display_level($child['children']);
           print '</ul>';
         }
         print '</li>';
       }
     };

     $display_level($hierarchical['children']);

    ?>
    </ul>
 </div>
 <?php endif; // count($themed_siblings) > 0 ?>
 </div>
