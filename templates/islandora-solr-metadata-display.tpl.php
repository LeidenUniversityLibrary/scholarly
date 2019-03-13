<?php
/**
 * @file
 * Islandora_solr_metadata display template.
 *
 * Variables available:
 * - $solr_fields: Array of results returned from Solr for the current object
 *   based upon defined display configuration(s). The array structure is:
 *   - display_label: The defined display label corresponding to the Solr field
 *     as defined in the configuration in translatable string form.
 *   - value: An array containing all the result(s) found for the specific field
 *     in Solr for the current object when queried against Solr.
 * - $found: Boolean indicating if a Solr doc was found for the current object.
 * - $not_found_message: A string to print if there was no document found in
 *   Solr.
 *
 * @see template_preprocess_islandora_solr_metadata_display()
 * @see template_process_islandora_solr_metadata_display()
 */
?>
<?php if ($found):
  if (!(empty($solr_fields) && variable_get('islandora_solr_metadata_omit_empty_values', FALSE))):?>
    <section <?php $print ? print('class="dc-metadata islandora islandora-metadata"') : print('class="dc-metadata islandora islandora-metadata"');?>>
      <!-- Metadata -->
      <div class="fieldset-wrapper">
          <?php $row_field = 0; ?>
          <?php foreach($solr_fields as $solr_field => $value): ?>
          <dl title="<?php print $value['display_label']; ?>">
              <dt class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print $value['display_label']; ?></dt>
              <dd class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print check_markup(implode("\n", $value['value']), 'islandora_solr_metadata_filtered_html'); ?></dd>
              <?php $row_field++; ?>
          </dl>
          <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
<?php else: ?>
  <section <?php $print ? print('class="dc-metadata islandora islandora-metadata"') : print('class="dc-metadata islandora islandora-metadata"');?>>
    <legend><span class="fieldset-legend"><?php print t('Details'); ?></span></legend>
    <?php //XXX: Hack in markup for message. ?>
    <div class="messages--warning messages warning">
      <?php print $not_found_message; ?>
    </div>
  </section>
<?php endif; ?>
