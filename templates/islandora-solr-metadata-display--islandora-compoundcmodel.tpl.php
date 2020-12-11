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
              'mods_name_personal_EditorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_personal_EditorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_personal_EditorRole_namePart_custom_ms']['value'] : NULL,
              'mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s' => !empty($solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value']) ? $solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value'] : NULL,
              'mods_titleInfo_title_custom_ms' => !empty($solr_fields['mods_titleInfo_title_custom_ms']['value']) ? $solr_fields['mods_titleInfo_title_custom_ms']['value'] : NULL,
              'mods_titleInfo_subTitle_ms' => !empty($solr_fields['mods_titleInfo_subTitle_ms']['value']) ? $solr_fields['mods_titleInfo_subTitle_ms']['value'] : NULL,
              'mods_genre_authority_local_s' => !empty($solr_fields['mods_genre_authority_local_s']['value']) ? $solr_fields['mods_genre_authority_local_s']['value'] : NULL,
              'mods_name_personal_affiliation_department_ms' => !empty($solr_fields['mods_name_personal_affiliation_department_ms']['value']) ? $solr_fields['mods_name_personal_affiliation_department_ms']['value'] : NULL,
              'mods_abstract_ms' => !empty($solr_fields['mods_abstract_ms']['value']) ? $solr_fields['mods_abstract_ms']['value'] : NULL,
              'mods_subject_topic_ms' => !empty($solr_fields['mods_subject_topic_ms']['value']) ? $solr_fields['mods_subject_topic_ms']['value'] : NULL,
            ];
            ?>
              <?php if (!empty($selection['mods_name_personal_AuthorRole_namePart_custom_ms']) || !empty($selection['mods_name_personal_EditorRole_namePart_custom_ms'])): ?>
              <dd class="first author">
                <?php if (!empty($selection['mods_name_personal_AuthorRole_namePart_custom_ms'])): ?>
                <span class="name">
                  <?php print scholarly_authors_apa6($variables['separator'], $selection['mods_name_personal_AuthorRole_namePart_custom_ms']) ?>
                </span>
                <?php elseif (!empty($selection['mods_name_personal_EditorRole_namePart_custom_ms'])): ?>
                <span class="name">
                  <?php print scholarly_authors_apa6($variables['separator'], $selection['mods_name_personal_EditorRole_namePart_custom_ms']) ?>
                </span>
                <?php endif; ?>
                <span class="year">
                  <?php $year = scholarly_filter_metadata($selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s'][0]); if (preg_match('!(\d\d\d\d)-[0-9-]+!', $year, $matches)) { print '(' . $matches[1] . ')'; } ?>
                </span>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_titleInfo_title_custom_ms'])): ?>
              <dd class="title">
                  <h3>
                    <?php $title = implode($variables['separator'], $selection['mods_titleInfo_title_custom_ms']) ?>
                    <?php if (!empty($selection['mods_titleInfo_subTitle_ms'])): ?>
                      <?php if (preg_match('/\w\s*$/', $title) === 1): ?>
                        <?php $title .= ': '; ?>
                      <?php else: ?>
                        <?php $title .= ' '; ?>
                      <?php endif; ?>
                      <?php $title .= implode($variables['separator'], $selection['mods_titleInfo_subTitle_ms']) ?>
                    <?php endif; ?>
                    <?php print scholarly_filter_metadata($title); ?>
                  </h3>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_genre_authority_local_s'])): ?>
              <dd class="genre">
                <?php $text = scholarly_filter_metadata($selection['mods_genre_authority_local_s'][0]);
                      if ($text !== NULL && strlen($text) > 0 && $selection['mods_name_personal_affiliation_department_ms'][0] !== NULL && strlen($selection['mods_name_personal_affiliation_department_ms'][0]) > 0) {
                        $text .= ' | ';
                      }
                      $text .= scholarly_filter_metadata($selection['mods_name_personal_affiliation_department_ms'][0]);
                      $text = preg_replace('!</?p[^>]*?>!i', '', $text); 
                      print $text;
                ?>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_abstract_ms'])): ?>
              <dd class="abstract">
                <?php print scholarly_filter_metadata(implode($variables['separator'], $selection['mods_abstract_ms'])) ?>
              </dd>
              <?php endif; ?>
              <?php if (!empty($selection['mods_subject_topic_ms'])): ?>
                <dd class="topics">
                <?php
                  foreach ($selection['mods_subject_topic_ms'] as $tag) {
                      print '<div class="tag">' . scholarly_filter_metadata($tag, TRUE) . '</div>';
                  }
                ?>
              </dd>
              <?php endif; ?>
              
            <?php
            // Loop though all other fields and print values.
            ?>
            <?php $row_field = 0; ?>
            <?php unset($selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']); ?>
            <?php foreach ($solr_fields as $solr_field => $value): ?>
              <?php if (!array_key_exists($solr_field, $selection)): ?>
                    <dl title="<?php print $value['display_label']; ?>" class="<?php print $solr_field; ?>">
                        <dt class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print $value['display_label']; ?></dt>
                        <dd class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print scholarly_filter_metadata(implode($variables['separator'], $value['value'])); ?></dd>
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
