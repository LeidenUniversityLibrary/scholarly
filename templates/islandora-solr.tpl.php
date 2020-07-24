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
    <?php $row_result = 0; ?>
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
                <?php if (isset($result['embargo'])): ?>
                  <dd class="solr-value <?php print $value['class']; ?> ubl-embargo <?php print $result['embargo']['class']; ?>"><?php print scholarly_filter_metadata($result['embargo']['value']); ?></dd>
                <?php endif; ?>
              <?php elseif ($key === 'related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'): ?>
                <dd style="display:none;"><?php print scholarly_filter_metadata(trim($value['value'], " \t\n\r")); ?></dd>
              <?php elseif ($key === 'mods_genre_authority_local_s'): ?>
                <dd class="solr-value <?php print $value['class']; ?>">
                  <?php print scholarly_filter_metadata(trim($value['value'], " \t\n\r")); ?>
                  <?php if (isset($result['solr_doc']['mods_name_personal_affiliation_department_ms']['value'])): ?>
                     <?php print ' | ' . scholarly_filter_metadata(trim($result['solr_doc']['mods_name_personal_affiliation_department_ms']['value'], " \t\n\r")); ?>
                  <?php endif; ?>
                </dd>
              <?php elseif ($key === 'mods_name_personal_affiliation_department_ms'): ?>
                <?php // do not display the department here, did it above already ?>
              <?php elseif ($key === 'mods_titleInfo_title_custom_ms'): ?>
                <dd class="solr-value <?php print $value['class']; ?>">
                  <?php $title = trim($value['value'], " \t\n\r"); ?>
                  <?php if (preg_match('!^(<a [^>]+>)(.*?)(</a>)$!', $title, $matches)): ?>
                    <?php $ahref = $matches[1]; ?> 
                    <?php $title = $matches[2]; ?> 
                    <?php $aend = $matches[3]; ?> 
                  <?php else: ?>
                    <?php $ahref = ''; ?> 
                    <?php $aend = ''; ?> 
                  <?php endif; ?>
                  <?php if (!empty($result['solr_doc']['mods_titleInfo_subTitle_ms']['value'])): ?>
                     <?php if (preg_match('/\w\s*$/', $title) === 1): ?>
                       <?php $title .= ': '; ?>
                     <?php else: ?>
                       <?php $title .= ' '; ?>
                     <?php endif; ?>
                     <?php $title .= trim($result['solr_doc']['mods_titleInfo_subTitle_ms']['value'], " \t\n\r"); ?> 
                  <?php endif; ?>
                  <?php print $ahref . scholarly_filter_metadata($title) . $aend; ?>
                </dd>
              <?php elseif ($key === 'mods_titleInfo_subTitle_ms'): ?>
                <?php // do not display the subtitle here, did it above already ?>
              <?php else: ?>
                <dd class="solr-value <?php print $value['class']; ?>"><?php print scholarly_filter_metadata(trim($value['value'], " \t\n\r")); ?></dd>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

      </div>
    <?php $row_result++; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
