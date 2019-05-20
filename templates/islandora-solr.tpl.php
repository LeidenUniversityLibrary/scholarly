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
                  <dd class="solr-value <?php print $value['class']; ?> ubl-embargo <?php print $result['embargo']['class']; ?>"><?php print $result['embargo']['value']; ?></dd>
                <?php endif; ?>
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
