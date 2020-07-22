<?php

/**
 * Theme override for theme_menu_link()
 */
function scholarly_menu_link($variables) {
    $element = $variables['element'];
    $menu_name = $variables['element']['#original_link']['menu_name'];
    $sub_menu = '';
    $classes = implode (' ',$element['#attributes']['class']);

    //add class to menu item if it has children
    if ($element['#below']) {
      $sub_menu = drupal_render($element['#below']);
      $element['#attributes']['class'][] = 'cbp-placeholder';
      $sub_menu = '<div class="cbp-hrsub">
        <div class="cbp-hrsub-inner dc-centercontent"><div>'
        . $sub_menu . '</div></div>';
    }

    $options = array('attributes' => $element['#attributes']);
    if (isset($element['#localized_options']['query'])) {
      $options['query'] = $element['#localized_options']['query'];
    }
    if (url_is_external($element['#href'])) {
      $options['attributes']['target'] = '_blank';
    }
    if ($element['#href'] === 'user/login') {
      $options['query'] = drupal_get_destination();
    }
    $output = l($element['#title'], $element['#href'], $options);

    //create fragment link for <nolink> menu items in first level
    if ($element['#href'] == '<nolink>' && $element['#below']) {
      $output = l($element['#title'], NULL, array(
        'attributes' => $element['#attributes'],
        'fragment' => FALSE
      ));
    }
    //H4 element for <nolink> items in submenu
    if ($element['#href'] == '<nolink>' && !$element['#below']) {
      $output = '<h4>' . $element['#title'] . '</h4>';
    }
    //Change separator menu item to div element
    if ($element['#href'] == '<separator>') {
      $output = '</ul></div><div><ul>';
      return $output;
    }
    //Inject block content when url query contains block
    if (isset($element['#original_link']['options']['query']['block'])) {
      $output = _scholarly_render_block_content(
        $element['#original_link']['options']['query']['block'],
        $element['#original_link']['options']['query']['delta']);
    }

    //Inject search block after last menu item
    if ($element['#original_link']['depth'] === '1' &&
      in_array('last', $element['#attributes']['class']) &&
      $menu_name == 'main-menu') {
      return '<li>' . $output . $sub_menu . '</li>' .
      '<li class="dc-menu-search">' .
        _scholarly_render_block_content('islandora_collection_search', 'islandora_collection_search') . '</li>';
    }
    return '<li class="'.$classes.'">' . $output . $sub_menu . '</li>';
}

/**
 * Implements hook_form_alter().
 */
function scholarly_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'islandora_collection_search_form') {
    //change submit button markup
    $form['simple']['submit'] = array(
      '#type' => 'submit',
      '#suffix' => '<button type="submit" class="form-submit"><i class="fa fa-search"></i></button>',
      '#weight' => 1000,
    );
    //add placeholder to search textbox
    $form['simple']['islandora_simple_search_query']['#attributes']['placeholder'] = t('Search');
  }
}

/**
 * Helper function to find and render a block.
 */
function _scholarly_render_block_content($module, $delta) {
  $output = '';
  if ($block = block_load($module, $delta)) {
    if ($build = module_invoke($module, 'block_view', $delta)) {
      $delta = str_replace('-', '_', $delta);
      drupal_alter(array(
        'block_view',
        "block_view_{$module}_{$delta}"
      ), $build, $block);

      if (!empty($build['content'])) {
        return is_array($build['content']) ? render($build['content']) : $build['content'];
      }
    }
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function scholarly_preprocess_node(&$vars) {
  // Get the node.
  $node = $vars['node'];

  if ($vars['view_mode'] == 'teaser') {
    // Adding hook suggestions.
    switch ($node->type) {
      case 'more_item':
        $vars['theme_hook_suggestions'][] = 'node__more__teaser';
      break;
      case 'home_page_item':
        $vars['theme_hook_suggestions'][] = 'node__home_page_item__teaser';
        break;
    }
  }
}

/**
 * Implements hook_preprocess_page().
 */
function scholarly_preprocess_page(&$vars, $hook) {
  // Unset Drupal message.
  unset($vars['page']['content']['system_main']['default_message']);

  // Unset Persistant URL block when at collection page.
  if (isset($vars['page']['content']['system_main']['islandora_basic_collection_display']) &&
  isset($vars['page']['sidebar_second']['views_58fda38e2111cb9c7dbea57150bbc9b3'])) {
    unset($vars['page']['sidebar_second']['views_58fda38e2111cb9c7dbea57150bbc9b3']);
  }

  // Remove page elements when there is a node found representing a Islandora collection.
  if (isset($vars['page']['content']['system_main']['islandora_basic_collection_display'])) {
    if (strpos(arg(2), 'collection:') !== false) {
      $pid = !empty(arg(2)) ? arg(2) : FALSE;
      // Check query if a collection content type is filled for this pid.
      $result = _scholarly_query_collection_nodes($pid);
      // Check if there is a corresponding node.
      if (isset($result['node'])) {
        // unset various elements in page vars.
        if(isset($vars['page']['sidebar_first']['islandora_solr_basic_facets'])) {
          unset($vars['page']['sidebar_first']['islandora_solr_basic_facets']);
        }
      }
    }
  }
}

function scholarly_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = 5;
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('«')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('››')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first', 'dc-pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous', 'dc-pager-prev'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current', 'dc-pager-active'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next', 'dc-pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last', 'dc-pager-last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
}
function scholarly_preprocess_item_list(&$vars) {

  // make sure we're dealing with a pager item list
  if (isset($vars['attributes']['class'])) {
    if (!is_array($vars['attributes']['class'])) {
      $vars['attributes']['class'] = array($vars['attributes']['class']);
    }
  }
  if (isset($vars['attributes']['class']) && in_array('pager', $vars['attributes']['class'])) {
    // Add an extra class to item list
    $vars['attributes']['class'][] = 'dc-searchresults-pager';

    // loop the items and find the first .pager-item
    foreach ($vars['items'] as $index => $item) {

      // adding classes to first previous next last and active iten
      if(in_array('pager-first', $item['class'] )){
        $vars['items'][$index]['class'][] = 'dc-pager-first';
      }
      if(in_array('pager-previous', $item['class'] )){
        $vars['items'][$index]['class'][] = 'dc-pager-prev';
      }
      if(in_array('pager-current', $item['class'] )){
        $vars['items'][$index]['class'][] = 'dc-pager-active';
      }
      if(in_array('pager-next', $item['class'] )){
        $vars['items'][$index]['class'][] = 'dc-pager-next';
      }
      if(in_array('pager-last', $item['class'] )){
        $vars['items'][$index]['class'][] = 'dc-pager-last';
      }
    }
  }
}

function scholarly_preprocess_islandora_objects_subset(&$variables){
  // Only act on a collection page.
  if (strpos(arg(2), 'collection') !== false) {
    $pid = !empty(arg(2)) ? arg(2) : false;
    // Check query if a collection content type is filled for this pid.
    $result = _scholarly_query_collection_nodes($pid);
    // Check if there is a node.
    if (isset($result['node'])) {
      $node = reset($result['node']);
      // If we have a node disable this display.
      $variables['sidebar-first'] = [];
      $variables['pager'] = [];
      $variables['display_links']= [];
      $variables['content'] = node_view(node_load($node->nid));
      $variables['content']['#objects'] = [];
    }
  }
}

function scholarly_preprocess_islandora_book_page(&$variables) {
  // yuk, largely copied from large image
  $islandora_object = $variables['object'];
  $variables['islandora_object'] = $islandora_object;

  $repository = $islandora_object->repository;
  module_load_include('inc', 'islandora', 'includes/datastream');
  module_load_include('inc', 'islandora', 'includes/utilities');
  module_load_include('inc', 'islandora', 'includes/metadata');

  $variables['parent_collections'] = islandora_get_parents_from_rels_ext($islandora_object);
  $variables['metadata'] = islandora_retrieve_metadata_markup($islandora_object);
  $variables['description'] = islandora_retrieve_description_markup($islandora_object);

  $params = [];

  if (isset($islandora_object['JP2']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['JP2'])) {
    // Get token to allow access to XACML protected datastreams.
    // Always use token authentication in case there is a global policy.
    module_load_include('inc', 'islandora', 'includes/authtokens');
    $token = islandora_get_object_token($islandora_object->id, 'JP2', 2);
    $jp2_url = url("islandora/object/{$islandora_object->id}/datastream/JP2/view",
      array(
        'absolute' => TRUE,
        'query' => array('token' => $token),
      ));
    // Display large image.
    $params['jp2_url'] = $jp2_url;
  }

  $viewer = islandora_get_viewer($params, 'islandora_large_image_viewers', $islandora_object);
  $variables['islandora_content'] = '';
  if ($viewer) {
    if (strpos($viewer, 'islandora-openseadragon') !== FALSE) {
      if (isset($islandora_object['JP2']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['JP2'])) {
        $variables['image_clip'] = theme(
          'islandora_openseadragon_clipper',
          array('pid' => $islandora_object->id)
        );
      }
    }
    $variables['islandora_content'] = $viewer;
  }
  // If no viewer is configured just show the jpeg.
  elseif (isset($islandora_object['JPG']) && islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $islandora_object['JPG'])) {
    $params = array(
      'title' => $islandora_object->label,
      'path' => url("islandora/object/{$islandora_object->id}/datastream/JPG/view"),
    );
    $variables['islandora_content'] = theme('image', $params);
  }
  else {
    $variables['islandora_content'] = NULL;
  }

  // set the label of the book and also (re)set the parent_collections to the collections where the book is part of.
  if ($variables['book_object_id']) {
    $bookobj = islandora_object_load($variables['book_object_id']);
    if ($bookobj) {
      $variables['book_object_label'] = $bookobj->label;
   
      $variables['parent_collections'] = islandora_get_parents_from_rels_ext($bookobj);
    }
  }
}

function scholarly_preprocess_islandora_ead(&$variables) {
  drupal_add_js(drupal_get_path('theme', 'uvl') . '/js/ead.js', 'file');
  $islandora_object = $variables['object'];
  $variables['islandora_object'] = $islandora_object;

  module_load_include('inc', 'islandora', 'includes/datastream');
  module_load_include('inc', 'islandora', 'includes/utilities');
  module_load_include('inc', 'islandora', 'includes/metadata');

  $variables['parent_collections'] = islandora_get_parents_from_rels_ext($islandora_object);
  $variables['metadata'] = islandora_retrieve_metadata_markup($islandora_object);
  $variables['description'] = islandora_retrieve_description_markup($islandora_object);
}

/**
 * Implements hook_preprocess_HOOK().
 *
 * Adds embargo specific values to results array so embargo information can be
 * displayed in the solr search results.
 */
function scholarly_preprocess_islandora_solr(&$variables) {
  drupal_set_title(t("Search results"));
  if (!isset($variables['results'])) {
    return;
  }
  $fieldsep = variable_get('islandora_solr_search_field_value_separator', ', ');
  foreach ($variables['results'] as $key => $result) {
    if (isset($result['solr_doc']['related_mods_accessCondition_type_ms']['value'])) {
      $accessCondType = $result['solr_doc']['related_mods_accessCondition_type_ms']['value'];
      $displayvalue = 'closed access';
      $displayclass = 'ubl-embargo-full-eternal';
      $values = explode($fieldsep, trim($accessCondType, " \t\n\r"));
      $values = array_filter(array_unique($values), function($v) { return $v !== 'use and reproduction'; });
      if (count($values) == 1) {
          switch ($values[0]) {
          case 'info:eu-repo/semantics/openAccess':
            $displayvalue = 'open access';
            $displayclass = 'ubl-embargo-none';
            break;
          case 'info:eu-repo/semantics/closedAccess':
            $displayvalue = 'closed access';
            $displayclass = 'ubl-embargo-full-eternal';
            break;
          case 'info:eu-repo/semantics/embargoedAccess':
            $embargodate = _scholarly_derive_embargodate($result['solr_doc'], $fieldsep);
            if ($embargodate === FALSE) {
              $displayvalue = 'open access';
              $displayclass = 'ubl-embargo-none';
            }
            else {
              $displayvalue = 'under embargo';
              $displayclass = 'ubl-embargo-full-temporary';
              $displayvalue .= ' until ' . $embargodate;
            }
            break;
        }
      }
      else {
         $displayvalue = 'some documents under embargo';
         $displayclass = 'ubl-embargo-partial-eternal';
         $embargodate = _scholarly_derive_embargodate($result['solr_doc'], $fieldsep);
         if (in_array('info:eu-repo/semantics/closedAccess', $values) === FALSE && $embargodate === FALSE) {
           $displayvalue = 'open access';
           $displayclass = 'ubl-embargo-none';
         }
         elseif (in_array('info:eu-repo/semantics/closedAccess', $values) === FALSE && $embargodate !== FALSE) {
           $displayvalue .= ' until ' . $embargodate;
         }
      }
      $variables['results'][$key]['embargo'] = array('value' => $displayvalue, 'class' => $displayclass);
    }
    if (isset($displayvalue) && (($displayvalue === 'closed access' || substr($displayvalue, 0, 13) === 'under embargo'))) {
      $variables['results'][$key]['thumbnail'] = str_replace(str_replace(':', '%3A', $result['thumbnail_url']), 'sites/all/themes/scholarly/img/closed_access.png', $result['thumbnail']);
    }
  }
}

/**
 * Implements hook_preprocess_HOOK().
 *
 * Adds embargo specific values to results array so embargo information can be
 * displayed in the solr search results.
 */
function scholarly_preprocess_islandora_compound_prev_next(&$variables) {
  module_load_include('inc', 'islandora_solr', 'includes/utilities');
  $qp = new IslandoraSolrQueryProcessor();

  $parent_id = islandora_solr_lesser_escape($variables['parent_pid']);
  $relcomp = variable_get('islandora_solr_compound_relationship_field', 'RELS_EXT_isConstituentOf_uri_ms');
  $query = "$relcomp:($parent_id) OR $relcomp:(" . islandora_solr_lesser_escape('info:fedora/') . "$parent_id)";
  $qp->buildQuery("*:*");
  $qp->solrStart = 0;
  $qp->solrParams['facet'] = 'false';
  $qp->solrParams['fq'] = array($query);
  $qp->executeQuery(FALSE);
  if (isset($qp->islandoraSolrResult['response']['numFound']) && $qp->islandoraSolrResult['response']['numFound'] > 0) {
    $fieldsep = variable_get('islandora_solr_search_field_value_separator', ', ');
    foreach ($qp->islandoraSolrResult['response']['objects'] as $solrobj) {
      $pid = $solrobj['PID'];
      unset($datastream);
      $variables['siblings_detailed'][$pid]['embargo_text'] = 'closed access'; 
      $variables['siblings_detailed'][$pid]['embargo_class'] = 'ubl-embargo-full-eternal'; 
      if (isset($solrobj['solr_doc']['mods_accessCondition_use_and_reproduction_xlinkhref_ms'])) {
        $licenseurl = $solrobj['solr_doc']['mods_accessCondition_use_and_reproduction_xlinkhref_ms'][0];
        $licensetype = preg_replace('/^.*(license):(\d+)$/', '${1}_${2}', $licenseurl);
        $licensetext = $solrobj['solr_doc']['mods_accessCondition_use_and_reproduction_s'];
      }
      if (isset($solrobj['solr_doc']['mods_accessCondition_type_custom_ms'])) {
        if (in_array('info:eu-repo/semantics/closedAccess', $solrobj['solr_doc']['mods_accessCondition_type_custom_ms'])) {
          // this is the default...
        }
        elseif (in_array('info:eu-repo/semantics/embargoedAccess', $solrobj['solr_doc']['mods_accessCondition_type_custom_ms'])) {
          $embargodate = _scholarly_derive_embargodate($solrobj['solr_doc'], $fieldsep);
          if ($embargodate === FALSE) {
            $variables['siblings_detailed'][$pid]['embargo_text'] = 'open access'; 
            $variables['siblings_detailed'][$pid]['embargo_class'] = 'ubl-embargo-none'; 
            if (isset($licenseurl, $licensetype)) {
              $variables['siblings_detailed'][$pid]['license_url'] = $licenseurl;
              $variables['siblings_detailed'][$pid]['license_type'] = $licensetype;
              $variables['siblings_detailed'][$pid]['license_text'] = $licensetext;
            }
          }
          else {
            $variables['siblings_detailed'][$pid]['embargo_text'] = 'under embargo until ' . $embargodate; 
            $variables['siblings_detailed'][$pid]['embargo_class'] = 'ubl-embargo-full-temporary'; 
          }
        }
        elseif (in_array('info:eu-repo/semantics/openAccess', $solrobj['solr_doc']['mods_accessCondition_type_custom_ms'])) {
          $variables['siblings_detailed'][$pid]['embargo_text'] = 'open access'; 
          $variables['siblings_detailed'][$pid]['embargo_class'] = 'ubl-embargo-none'; 
          if (isset($licenseurl, $licensetype)) {
            $variables['siblings_detailed'][$pid]['license_url'] = $licenseurl;
            $variables['siblings_detailed'][$pid]['license_type'] = $licensetype;
            $variables['siblings_detailed'][$pid]['license_text'] = $licensetext;
          }
        }
      }
      if (isset($solrobj['solr_doc']['mods_identifier_doi_s'])) {
        $doi = $solrobj['solr_doc']['mods_identifier_doi_s']; 
        $variables['siblings_detailed'][$pid]['doi'] = $doi; 
        $doi_url = preg_replace('!^\s*(?:doi:|https?://(?:dx\.)?doi.org/)(.*)$!', "https://doi.org/$1", $doi);
        $variables['siblings_detailed'][$pid]['doi_url'] = $doi_url; 
      }
      if (isset($solrobj['solr_doc']['RELS_EXT_hasModel_uri_ms'])) {
        $object = islandora_object_load($pid);
        if ($object) {
          $cmodels = $solrobj['solr_doc']['RELS_EXT_hasModel_uri_ms'];
          if (in_array('info:fedora/islandora:sp_pdf', $cmodels)) {
            $filetype = 'pdf';
            foreach (array('PDFA', 'PDF', 'OBJ') as $preferred_datastream) {
              if (isset($object[$preferred_datastream])) {
                $hasaccess = islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object[$preferred_datastream]);
                if ($hasaccess) {
                  $datastream = $preferred_datastream;
                  $filename = preg_replace('/^\s*(.*?)(?:\.pdf)?\s*$/i', "$1.$filetype", $object->label);
                }
                break;
              }
            }
          }
          else {
            $filetype = 'generic';
            if (islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['OBJ'])) {
              $datastream = 'OBJ';
              // TODO: include extension?
              $filename = trim($object->label);
            } 
          }
          if (isset($datastream)) {
            $baseurl = 'access/' . $object->id . '/';
            $variables['siblings_detailed'][$pid]['download_url'] = "{$baseurl}download";
            $variables['siblings_detailed'][$pid]['view_url'] = "{$baseurl}view";
            $variables['siblings_detailed'][$pid]['view_class'] = "ubl-file ubl-file-$filetype";
          }
          else {
            $variables['siblings_detailed'][$pid]['view_class'] = "ubl-file ubl-file-$filetype ubl-file-embargo";
          }
        }
      }
    }
  }
}

function _scholarly_derive_embargodate($solrdoc, $fieldsep) {
  if (isset($solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt']['value'])) {
    $dates = $solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt']['value'];
  }
  elseif (isset($solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'])) {
    $dates = $solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'];
  }
  elseif (isset($solrdoc['mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'])) {
    $dates = $solrdoc['mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'][0];
  }
  if (isset($dates)) {
    if (is_string($dates)) {
      $dates = explode($fieldsep, trim($dates, " \t\n\r"));
    }
    rsort($dates);
    $date = preg_replace('/^(\d\d\d\d-\d\d-\d\d).*$/', '$1', $dates[0]);
    $today = date("Y-m-d");
    if (strcmp($date, $today) > 0) {
      return $date;
    }
  }
  return FALSE;
}

/**
 * Helper function to query (sub)collection nodes by Islandora object identifier.
 *
 * @param string $pid
 *   Islandora object identifier.
 *
 * @return array
 *   Node data.
 */
function _scholarly_query_collection_nodes($pid) {
  $query = new EntityFieldQuery();
  $query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'collection')
    ->propertyCondition('status', NODE_PUBLISHED)
    ->fieldCondition('field_collection_id', 'value', $pid, '=')
    ->range(0, 1);
  $result = $query->execute();

  return $result;
}

/**
 * Implements hook_preprocess_HOOK().
 *
 * Adds embargo specific values to results array so embargo information can be
 * displayed in the solr search results.
 */
function scholarly_preprocess_islandora_compound_object(&$variables) {
  module_load_include('inc', 'islandora_solr', 'includes/utilities');
  if (!isset($variables['islandora_object'])) {
    return;
  }
  $is_closed = TRUE;
  $islandora_object = $variables['islandora_object'];
  $qp = new IslandoraSolrQueryProcessor();
  $object_id = islandora_solr_lesser_escape($islandora_object->id);
  $query = "PID:($object_id)";
  $qp->buildQuery("*:*");
  $qp->solrStart = 0;
  $qp->solrParams['facet'] = 'false';
  $qp->solrParams['fq'] = array($query);
  $qp->executeQuery(FALSE);
  if (isset($qp->islandoraSolrResult['response']['numFound']) && $qp->islandoraSolrResult['response']['numFound'] === 1) {
    $fieldsep = variable_get('islandora_solr_search_field_value_separator', ', ');
    $solrdoc = $qp->islandoraSolrResult['response']['objects'][0]['solr_doc'];
    if (isset($solrdoc['related_mods_accessCondition_type_ms'])) {
      $values = $solrdoc['related_mods_accessCondition_type_ms'];
      $values = array_filter(array_unique($values), function($v) { return $v !== 'use and reproduction'; });
      if (count($values) == 1) {
          switch ($values[0]) {
          case 'info:eu-repo/semantics/openAccess':
            $is_closed = FALSE;
            break;
          case 'info:eu-repo/semantics/closedAccess':
            break;
          case 'info:eu-repo/semantics/embargoedAccess':
            $embargodate = _scholarly_derive_embargodate($solrdoc, $fieldsep);
            if ($embargodate === FALSE) {
              $is_closed = FALSE;
            }
            break;
        }
      }
      else {
         $embargodate = _scholarly_derive_embargodate($solrdoc, $fieldsep);
         if (in_array('info:eu-repo/semantics/openAccess', $values) === TRUE || $embargodate !== FALSE) {
           $is_closed = FALSE;
         }
      }
    }
  }
  if ($is_closed) {
    $params = array(
      'title' => $islandora_object->label,
      'path' => 'sites/all/themes/scholarly/img/closed_access.png',
    );
    $variables['islandora_thumbnail_img'] = theme('image', $params);
  }
}

function scholarly_filter_metadata($value, $allowlink = FALSE) {
  $result = '';
  if (!empty($value)) {
    $filter = 'islandora_solr_metadata_filtered_html';
    $matches = array();
    if (preg_match('!^(<span class=[\'"]toggle-wrapper[\'"]><span>)(.*?)(<a href=[\'"]#[\'"] class=[\'"]toggler[\'"]>[^<]+</a></span><span>)(.*?)(<a href=[\'"]#[\'"] class=[\'"]toggler[\'"]>[^<]+</a></span></span>)$!', $value, $matches)) {
       $result = $matches[1] . check_markup($matches[2], $filter) . $matches[3] . check_markup($matches[4], $filter) . $matches[5];
    }
    elseif ($allowlink && preg_match('!^(<a href="[^"]+">)(.*?)(</a>)$!', $value, $matches)) {
       $result = $matches[1] . check_markup($matches[2], $filter) . $matches[3];
    }
    else {
      $result = check_markup($value, $filter);
      if (preg_match('/[\n\r]/', $value) === 0) {
        if (preg_match('!^<p>(.*?)</p>$!', $result, $matches)) {
          $result = $matches[1];
        }
      }
    }
  }
  return $result;
}
