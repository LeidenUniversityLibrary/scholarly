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
  if (!(empty($solr_fields) && variable_get('islandora_solr_metadata_omit_empty_values',
      FALSE))): ?>
      <section <?php $print ? print('class="dc-metadata islandora islandora-metadata"') : print('class="dc-metadata islandora islandora-metadata"'); ?>>
          <!-- Metadata -->
          <div class="fieldset-wrapper">
            <?php
            $selection = [
              'mods_name_personal_AuthorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_personal_AuthorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_personal_AuthorRole_namePart_custom_ms']['value'] : NULL,
              'mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s' => !empty($solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value']) ? $solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value'] : NULL,
              'mods_titleInfo_title_ms' => !empty($solr_fields['mods_titleInfo_title_ms']['value']) ? $solr_fields['mods_titleInfo_title_ms']['value'] : NULL,
              'mods_genre_ms' => !empty($solr_fields['mods_genre_ms']['value']) ? $solr_fields['mods_genre_ms']['value'] : NULL,
              'mods_abstract_ms' => !empty($solr_fields['mods_abstract_ms']['value']) ? $solr_fields['mods_abstract_ms']['value'] : NULL,
              'mods_subject_topic_ms' => !empty($solr_fields['mods_subject_topic_ms']['value']) ? $solr_fields['mods_subject_topic_ms']['value'] : NULL,
            ];
            ?>
              <?php if (!empty($selection['mods_name_personal_AuthorRole_namePart_custom_ms']) && !empty($selection['mods_name_personal_AuthorRole_namePart_custom_ms'])): ?>
              <dd class="first author">
                <span class="name">
                  <?php print check_plain(implode("\n",
                    $selection['mods_name_personal_AuthorRole_namePart_custom_ms'])) ?>
                </span>
                  <span class="year">(<?php print substr(check_plain(implode("\n",
                      $selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s'])),
                      0, 4); ?>)
                  </span>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_titleInfo_title_ms'])): ?>
              <dd class="title">
                  <h3>
                    <?php print check_plain(implode("\n",
                      $selection['mods_titleInfo_title_ms'])) ?>
                  </h3>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_genre_ms'])): ?>
              <dd class="genre">
                <?php print check_plain(implode(" | ",
                  $selection['mods_genre_ms'])) ?>
              </dd>
                <?php endif; ?>
                <?php if (!empty($selection['mods_abstract_ms'])): ?>
              <dd class="abstract">
                <?php print check_plain(implode("\n",
                  $selection['mods_abstract_ms'])) ?>
              </dd>
            <?php endif; ?>
            <?php if (!empty($selection['mods_subject_topic_ms'])): ?>
                <dd class="topics">
                <?php
                  foreach ($selection['mods_subject_topic_ms'] as $tag) {
                      print '<div class="tag">' . check_plain($tag) . '</div>';
                  }
                ?>
              </dd>
            <?php endif; ?>
            <?php
            // Loop though all other fields and print values.
            ?>
            <?php $row_field = 0; ?>
            <?php foreach ($solr_fields as $solr_field => $value): ?>
              <?php if (!array_key_exists($solr_field, $selection)): ?>
                    <dl title="<?php print $value['display_label']; ?>">
                        <dt class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print $value['display_label']; ?></dt>
                        <dd class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print check_markup(implode("\n",
                            $value['value']),
                            'islandora_solr_metadata_filtered_html'); ?></dd>
                      <?php $row_field++; ?>
                    </dl>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
      </section>
  <?php endif; ?>
<?php else: ?>
    <section <?php $print ? print('class="dc-metadata islandora islandora-metadata"') : print('class="dc-metadata islandora islandora-metadata"'); ?>>
        <legend><span
                    class="fieldset-legend"><?php print t('Details'); ?></span>
        </legend>
      <?php //XXX: Hack in markup for message. ?>
        <div class="messages--warning messages warning">
          <?php print $not_found_message; ?>
        </div>
    </section>
<?php endif; ?>