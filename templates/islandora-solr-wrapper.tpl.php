<?php
/**
 * @file
 * Islandora solr search results wrapper template
 *
 * Variables available:
 * - $variables: all array elements of $variables can be used as a variable.
 *   e.g. $base_url equals $variables['base_url']
 * - $base_url: The base url of the current website. eg: http://example.com .
 * - $user: The user object.
 *
 * - $secondary_profiles: Rendered secondary profiles
 * - $results: Rendered search results (primary profile)
 * - $islandora_solr_result_count: Solr result count string
 * - $solrpager: The pager
 * - $solr_debug: debug info
 *
 * @see template_preprocess_islandora_solr_wrapper()
 */
if( arg(2) ){
  $search_for = arg(2);
}
else{
  $search_for = '';
}

// build url for display buttons.
//Get current url
$path = current_path();

//Get current query paramaters
$parameters = drupal_get_query_parameters();
if(!is_array($parameters)){
  $parameters = array();
}

//Build a new array per list type so we can add query parameters
$parameters_list = array();
$parameters_list = $parameters;
$parameters_list['display'] = 'default';

$parameters_grid = array();
$parameters_grid = $parameters;
$parameters_grid['display'] = 'grid';

//Get statest based on query parameter
if(is_array($parameters) && isset($parameters['display'])){
  if($parameters['display'] == 'tud_grid'){
    $list_view_active = '';
    $grid_view_active = 'active';
  }
  else{
    $list_view_active = 'active';
    $grid_view_active = '';
  }
}

$list_view = url($path, array('query'=> $parameters_list));
$grid_view = url($path, array('query'=> $parameters_grid));
?>

<div id="islandora-solr-top">
  <?php print $secondary_profiles; ?>
  <div id="islandora-solr-result-count"><?php print $islandora_solr_result_count; ?></div>
</div>
<div class="islandora-solr-content">
  <?php print $solr_pager; ?>
  <ul class="dc-searchresults-tools">
    <li><a class="dc-searchresults-btn-grid" title="show grid" href="<?php print $grid_view; ?>"><span>show grid</span></a></li>
    <li><a class="dc-searchresults-btn-list" title="show list" href="<?php print $list_view; ?>"><span>show list</span></a></li>
    <li><a class="dc-searchresults-btn-save" title="save search" href="#"><span>save search</span></a></li>
  </ul>
  <?php print $results; ?>
  <?php print $solr_debug; ?>
  <?php print $solr_pager; ?>
</div>
