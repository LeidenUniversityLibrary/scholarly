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
                <?php // do not display the access condition here, do it below genre / department ?>
              <?php elseif ($key === 'related_mods_originInfo_encoding_w3cdtf_type_embargo_dateOther_mdt'): ?>
                <dd style="display:none;"><?php print scholarly_filter_metadata(trim($value['value'], " \t\n\r")); ?></dd>
              <?php elseif ($key === 'mods_genre_authority_local_s'): ?>
                <dd class="solr-value <?php print $value['class']; ?>">
                  <?php print scholarly_filter_metadata(trim($value['value'], " \t\n\r")); ?>
                  <?php if (isset($result['solr_doc']['mods_name_personal_affiliation_department_ms']['value'])): ?>
                     <?php print ' | ' . scholarly_filter_metadata(trim($result['solr_doc']['mods_name_personal_affiliation_department_ms']['value'], " \t\n\r")); ?>
                  <?php endif; ?>
                </dd>
                <?php if (isset($result['embargo'])): ?>
                  <dd class="solr-value <?php print $value['class']; ?> ubl-embargo <?php print $result['embargo']['class']; ?>"><?php print scholarly_filter_metadata($result['embargo']['value']); ?></dd>
                <?php endif; ?>
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
              <?php elseif ($key === 'mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s'): ?>
                <?php // do not display the issue date here, doing it below already ?>
              <?php elseif ($key === 'mods_name_personal_aut_etal_ms'): ?>
                <?php // do not display the issue date here, doing it below already ?>
              <?php elseif ($key === 'mods_name_personal_edt_etal_ms'): ?>
                <?php // do not display the issue date here, doing it below already ?>
              <?php elseif ($key === 'mods_name_AuthorRole_namePart_custom_ms' || $key === 'mods_name_EditorRole_namePart_custom_ms'): ?>
                <?php if ($key === 'mods_name_EditorRole_namePart_custom_ms' && isset($result['solr_doc']['mods_name_AuthorRole_namePart_custom_ms'])):
                         continue;
                      endif; ?>
                <dd class="solr-value <?php print $value['class']; ?>">
                  <?php $authorsString = isset($result['solr_doc']['mods_name_AuthorRole_namePart_custom_ms']['value']) ? $result['solr_doc']['mods_name_AuthorRole_namePart_custom_ms']['value'] : $result['solr_doc']['mods_name_EditorRole_namePart_custom_ms']['value'];
                        $authors = preg_split('/\\s*;\\s*/', trim($authorsString, " \t\n\r"));
                        print scholarly_authors_apa6('; ', $authors); ?>
                  <?php if (isset($result['solr_doc']['mods_name_personal_aut_etal_ms']['value'])):
                          print $result['solr_doc']['mods_name_personal_aut_etal_ms']['value'];
                        elseif (isset($result['solr_doc']['mods_name_personal_edt_etal_ms']['value']) && $key === 'mods_name_EditorRole_namePart_custom_ms'):
                          print $result['solr_doc']['mods_name_personal_edt_etal_ms']['value'];
                        endif;
                  ?>
                  <?php if (isset($result['solr_doc']['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value'])): ?>
                     <span class="solr-value <?php print $result['solr_doc']['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['class']; ?>"><?php print scholarly_filter_metadata(trim($result['solr_doc']['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value'], " \t\n\r")); ?></span>
                  <?php endif; ?>
                </dd>
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
