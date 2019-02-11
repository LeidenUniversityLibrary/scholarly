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
  <table class="dc-results islandora islandora-solr-search-results">
    <tbody>
    <?php $row_result = 0; ?>
    <?php foreach($results as $key => $result): ?>
      <!-- Search result -->
      <?php $contentmodelclass = strtolower(implode(' ', preg_replace(array('/info:fedora/','#/islandora:#','#[/:]#'), '', $result['content_models']))); ?>
      <tr class="islandora-solr-search-result clear-block <?php print $row_result % 2 == 0 ? 'odd' : 'even'; print ' ' . $contentmodelclass ?>">

          <!-- Thumbnail -->
          <td>

              <?php print $result['thumbnail']; ?>

          </td>
          <!-- Metadata -->
          <td class="solr-fields islandora-inline-metadata">
            <?php foreach($result['solr_doc'] as $key => $value): ?>
              <dt class="solr-label <?php print $value['class']; ?>">
                <?php print $value['label']; ?>
              </dt>
              <dd class="solr-value <?php print $value['class']; ?>">
                <?php print $value['value']; ?>
              </dd>
            <?php endforeach; ?>
          </td>

      </tr>
    <?php $row_result++; ?>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
