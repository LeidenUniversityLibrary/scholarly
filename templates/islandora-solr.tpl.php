<?php
/**
 * @file
 * Islandora solr search primary results template file.
 *
 * Variables available:
 * - $results: Primary profile results array
 *
 * @see template_preprocess_islandora_solr()
 */

?>
<?php if (empty($results)): ?>
  <p class="no-results"><?php print t('Sorry, but your search returned no results.'); ?></p>
<?php else: ?>
  <div class="dc-results islandora islandora-solr-search-results">
    <?php
      $row_result = 0;
      function embargo_date($solrdoc) {
        if (isset($solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'])):
          $fieldsep = variable_get('islandora_solr_search_field_value_separator', ', ');
          $dates = $solrdoc['related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'];
          $dates = explode($fieldsep, trim($dates['value'], " \t\n\r"));
          rsort($dates);
          $date = preg_replace('/^(\d\d\d\d-\d\d-\d\d).*$/', '$1', $dates[0]);
          $today = date("Y-m-d");
          if (strcmp($date, $today) > 0):
            return $date;
          endif;
        endif;
        return FALSE;
      }
      function access_condition_html($solrdoc) {
        if (isset($solrdoc['related_mods_accessCondition_type_ms']['value'])):
          $fieldsep = variable_get('islandora_solr_search_field_value_separator', ', ');
          $displayvalue = 'under embargo';
          $displayclass = 'ubl-embargo-full-eternal';
          $values = explode($fieldsep, trim($solrdoc['related_mods_accessCondition_type_ms']['value'], " \t\n\r"));
          $values = array_unique($values);
          if (count($values) == 1):
            switch ($values[0]):
              case 'info:eu-repo/semantics/openAccess':
                $displayvalue = 'no restrictions';
                $displayclass = 'ubl-embargo-none';
                break;
              case 'info:eu-repo/semantics/closedAccess':
                $displayvalue = 'under embargo';
                $displayclass = 'ubl-embargo-full-eternal';
                break;
              case 'info:eu-repo/semantics/embargoedAccess':
                $embargodate = embargo_date($solrdoc);
                if ($embargodate === FALSE):
                  $displayvalue = 'no retrictions';
                  $displayclass = 'ubl-embargo-none';
                else:
                  $displayvalue = 'under embargo';
                  $displayclass = 'ubl-embargo-full-temporary';
                  $displayvalue .= ' until ' . $embargodate;
                endif;
                break;
            endswitch;
          else:
             $displayvalue = 'some chapters under embargo';
             $displayclass = 'ubl-embargo-partial-eternal';
             $embargodate = embargo_date($solrdoc);
             if (in_array('info:eu-repo/semantics/closedAccess', $values) === FALSE && $embargodate === FALSE):
               $displayvalue = 'no retrictions';
               $displayclass = 'ubl-embargo-none';
             elseif (in_array('info:eu-repo/semantics/closedAccess', $values) === FALSE && $embargodate !== FALSE):
               $displayvalue .= ' until ' . $embargodate;
             endif;
          endif;
          if (!empty($displayvalue)):
            $fieldclass = $solrdoc['related_mods_accessCondition_type_ms']['class'];
            return '<dd class="solr-value ' . $fieldclass . ' ubl-embargo ' . $displayclass . '">' . $displayvalue . '</dd>';
          endif;
        endif;
        return '';
      }
    ?>
    <?php foreach($results as $key => $result): ?>
      <!-- Search result -->
      <?php $contentmodelclass = strtolower(implode(' ', preg_replace(array('/info:fedora/','#/islandora:#','#[/:]#'), '', $result['content_models']))); ?>
      <div class="row ubl-resultrow islandora-solr-search-result clear-block <?php print $row_result % 2 == 0 ? 'odd' : 'even'; print ' ' . $contentmodelclass ?>">

          <!-- Thumbnail -->
          <figure class="col col-3">
              <?php print $result['thumbnail']; ?>
          </figure>
          <!-- Metadata -->
          <div class="col col-9 solr-fields islandora-inline-metadata">
            <?php foreach($result['solr_doc'] as $key => $value): ?>
              <?php if ($key === 'related_mods_accessCondition_type_ms'): ?>
                <?php print access_condition_html($result['solr_doc']); ?>
              <?php elseif ($key === 'related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'): ?>
                <dd style="display:none;"><?php print trim($value['value'], " \t\n\r"); ?></dd>
              <?php else: ?>
                <dd class="solr-value <?php print $value['class']; ?>"><?php print trim($value['value'], " \t\n\r"); ?></dd>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

      </div>
    <?php $row_result++; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
