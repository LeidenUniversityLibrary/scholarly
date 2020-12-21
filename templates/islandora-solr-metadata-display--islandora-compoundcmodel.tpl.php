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
              'mods_name_AuthorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_AuthorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_AuthorRole_namePart_custom_ms']['value'] : (!empty($solr_fields['mods_name_personal_AuthorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_personal_AuthorRole_namePart_custom_ms']['value'] : NULL),
              'mods_name_EditorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_EditorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_EditorRole_namePart_custom_ms']['value'] : NULL,
              'mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s' => !empty($solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value']) ? $solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['value'] : NULL,
              'mods_titleInfo_title_custom_ms' => !empty($solr_fields['mods_titleInfo_title_custom_ms']['value']) ? $solr_fields['mods_titleInfo_title_custom_ms']['value'] : NULL,
              'mods_titleInfo_subTitle_ms' => !empty($solr_fields['mods_titleInfo_subTitle_ms']['value']) ? $solr_fields['mods_titleInfo_subTitle_ms']['value'] : NULL,
              'mods_genre_authority_local_s' => !empty($solr_fields['mods_genre_authority_local_s']['value']) ? $solr_fields['mods_genre_authority_local_s']['value'] : NULL,
              'mods_name_personal_affiliation_department_ms' => !empty($solr_fields['mods_name_personal_affiliation_department_ms']['value']) ? $solr_fields['mods_name_personal_affiliation_department_ms']['value'] : NULL,
              'mods_abstract_ms' => !empty($solr_fields['mods_abstract_ms']['value']) ? $solr_fields['mods_abstract_ms']['value'] : NULL,
              'mods_subject_topic_ms' => !empty($solr_fields['mods_subject_topic_ms']['value']) ? $solr_fields['mods_subject_topic_ms']['value'] : NULL,
              'mods_note_reasonInauguralAddress_ms' => !empty($solr_fields['mods_note_reasonInauguralAddress_ms']['value']) ? $solr_fields['mods_note_reasonInauguralAddress_ms']['value'] : NULL,
              'mods_note_editorship_ms' => !empty($solr_fields['mods_note_editorship_ms']['value']) ? $solr_fields['mods_note_editorship_ms']['value'] : NULL,
              'mods_name_DegreesupervisorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_DegreesupervisorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_DegreesupervisorRole_namePart_custom_ms']['value'] : NULL,
              'mods_name_ThesisadvisorRole_namePart_custom_ms' => !empty($solr_fields['mods_name_ThesisadvisorRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_ThesisadvisorRole_namePart_custom_ms']['value'] : NULL,
              'mods_name_CommitteememberRole_namePart_custom_ms' => !empty($solr_fields['mods_name_CommitteememberRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_CommitteememberRole_namePart_custom_ms']['value'] : NULL,
              'mods_name_InterviewerRole_namePart_custom_ms' => !empty($solr_fields['mods_name_InterviewerRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_InterviewerRole_namePart_custom_ms']['value'] : NULL,
              'mods_name_corporate_dgg_affiliation_institution_ms' => !empty($solr_fields['mods_name_corporate_dgg_affiliation_institution_ms']['value']) ? $solr_fields['mods_name_corporate_dgg_affiliation_institution_ms']['value'] : NULL,
              'mods_name_corporate_dgg_affiliation_faculty_ms' => !empty($solr_fields['mods_name_corporate_dgg_affiliation_faculty_ms']['value']) ? $solr_fields['mods_name_corporate_dgg_affiliation_faculty_ms']['value'] : NULL,
              'mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms' => !empty($solr_fields['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms']['value']) ? $solr_fields['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms']['value'] : NULL,
              'mods_relatedItem_host_titleInfo_title_ms' => !empty($solr_fields['mods_relatedItem_host_titleInfo_title_ms']['value']) ? $solr_fields['mods_relatedItem_host_titleInfo_title_ms']['value'] : NULL,
              // editors
              'mods_relatedItem_host_originInfo_edition_ms' => !empty($solr_fields['mods_relatedItem_host_originInfo_edition_ms']['value']) ? $solr_fields['mods_relatedItem_host_originInfo_edition_ms']['value'] : NULL,
              'mods_relatedItem_host_part_detail_volume_number_ms' => !empty($solr_fields['mods_relatedItem_host_part_detail_volume_number_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_detail_volume_number_ms']['value'] : NULL,
              'mods_relatedItem_host_part_detail_issue_number_ms' => !empty($solr_fields['mods_relatedItem_host_part_detail_issue_number_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_detail_issue_number_ms']['value'] : NULL,
              'mods_relatedItem_host_part_detail_section_title_ms' => !empty($solr_fields['mods_relatedItem_host_part_detail_section_title_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_detail_section_title_ms']['value'] : NULL,
              'mods_note_patentNumber_ms' => !empty($solr_fields['mods_note_patentNumber_ms']['value']) ? $solr_fields['mods_note_patentNumber_ms']['value'] : NULL,
              'mods_relatedItem_host_part_extent_start_ms' => !empty($solr_fields['mods_relatedItem_host_part_extent_start_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_extent_start_ms']['value'] : NULL,
              'mods_relatedItem_host_part_extent_end_ms' => !empty($solr_fields['mods_relatedItem_host_part_extent_end_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_extent_end_ms']['value'] : NULL,
              'mods_relatedItem_host_note_advancedPublication_ms' => !empty($solr_fields['mods_relatedItem_host_note_advancedPublication_ms']['value']) ? $solr_fields['mods_relatedItem_host_note_advancedPublication_ms']['value'] : NULL,
              'mods_note_annotationNumber_ms' => !empty($solr_fields['mods_note_annotationNumber_ms']['value']) ? $solr_fields['mods_note_annotationNumber_ms']['value'] : NULL,
              'mods_originInfo_place_placeTerm_text_ms' => !empty($solr_fields['mods_originInfo_place_placeTerm_text_ms']['value']) ? $solr_fields['mods_originInfo_place_placeTerm_text_ms']['value'] : NULL,
              'mods_originInfo_publisher_ms' => !empty($solr_fields['mods_originInfo_publisher_ms']['value']) ? $solr_fields['mods_originInfo_publisher_ms']['value'] : NULL,
              'mods_language_languageTerm_text_ms' => !empty($solr_fields['mods_language_languageTerm_text_ms']['value']) ? $solr_fields['mods_language_languageTerm_text_ms']['value'] : NULL,
              'mods_identifier_isbn_ms' => !empty($solr_fields['mods_identifier_isbn_ms']['value']) ? $solr_fields['mods_identifier_isbn_ms']['value'] : NULL,
              'mods_identifier_eisbn_ms' => !empty($solr_fields['mods_identifier_eisbn_ms']['value']) ? $solr_fields['mods_identifier_eisbn_ms']['value'] : NULL,
              'mods_identifier_doi_ms' => !empty($solr_fields['mods_identifier_doi_ms']['value']) ? $solr_fields['mods_identifier_doi_ms']['value'] : NULL,
              'mods_identifier_uri_ms' => !empty($solr_fields['mods_identifier_uri_ms']['value']) ? $solr_fields['mods_identifier_uri_ms']['value'] : NULL,
              'mods_identifier_uriDataset_ms' => !empty($solr_fields['mods_identifier_uriDataset_ms']['value']) ? $solr_fields['mods_identifier_uriDataset_ms']['value'] : NULL,
              'mods_relatedItem_series_titleInfo_title_ms' => !empty($solr_fields['mods_relatedItem_series_titleInfo_title_ms']['value']) ? $solr_fields['mods_relatedItem_series_titleInfo_title_ms']['value'] : NULL,
              'mods_relatedItem_host_part_detail_series_number_ms' => !empty($solr_fields['mods_relatedItem_host_part_detail_series_number_ms']['value']) ? $solr_fields['mods_relatedItem_host_part_detail_series_number_ms']['value'] : NULL,
              'mods_relatedItem_host_titleInfo_partNumber_ms' => !empty($solr_fields['mods_relatedItem_host_titleInfo_partNumber_ms']['value']) ? $solr_fields['mods_relatedItem_host_titleInfo_partNumber_ms']['value'] : NULL,
              'mods_note_coverageCourt_ms' => !empty($solr_fields['mods_note_coverageCourt_ms']['value']) ? $solr_fields['mods_note_coverageCourt_ms']['value'] : NULL,
              'mods_part_date_ms' => !empty($solr_fields['mods_part_date_ms']['value']) ? $solr_fields['mods_part_date_ms']['value'] : NULL,
              'mods_part_detail_caseNumber_number_ms' => !empty($solr_fields['mods_part_detail_caseNumber_number_ms']['value']) ? $solr_fields['mods_part_detail_caseNumber_number_ms']['value'] : NULL,
              'mods_identifier_ecli_ms' => !empty($solr_fields['mods_identifier_ecli_ms']['value']) ? $solr_fields['mods_identifier_ecli_ms']['value'] : NULL,
              'mods_relatedItem_original_titleInfo_title_ms' => !empty($solr_fields['mods_relatedItem_original_titleInfo_title_ms']['value']) ? $solr_fields['mods_relatedItem_original_titleInfo_title_ms']['value'] : NULL,
              'mods_relatedItem_original_name_personal_aut_namePart_ms' => !empty($solr_fields['mods_relatedItem_original_name_personal_aut_namePart_ms']['value']) ? $solr_fields['mods_relatedItem_original_name_personal_aut_namePart_ms']['value'] : NULL,
              'mods_relatedItem_original_name_corporate_aut_namePart_ms' => !empty($solr_fields['mods_relatedItem_original_name_corporate_aut_namePart_ms']['value']) ? $solr_fields['mods_relatedItem_original_name_corporate_aut_namePart_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_titleInfo_title_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_titleInfo_title_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_titleInfo_title_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_name_personal_aut_namePart_family_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_name_personal_aut_namePart_family_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_name_personal_aut_namePart_family_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_originInfo_dateIssued_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_originInfo_dateIssued_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_originInfo_dateIssued_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_relatedItem_series_titleInfo_title_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_relatedItem_series_titleInfo_title_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_relatedItem_series_titleInfo_title_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms']['value'] : NULL,
              'mods_relatedItem_reviewOf_originInfo_publisher_ms' => !empty($solr_fields['mods_relatedItem_reviewOf_originInfo_publisher_ms']['value']) ? $solr_fields['mods_relatedItem_reviewOf_originInfo_publisher_ms']['value'] : NULL,
              'mods_relatedItem_host_name_conference_namePart_ms' => !empty($solr_fields['mods_relatedItem_host_name_conference_namePart_ms']['value']) ? $solr_fields['mods_relatedItem_host_name_conference_namePart_ms']['value'] : NULL,
              'mods_relatedItem_host_name_conference_type_date_namePart_ms' => !empty($solr_fields['mods_relatedItem_host_name_conference_type_date_namePart_ms']['value']) ? $solr_fields['mods_relatedItem_host_name_conference_type_date_namePart_ms']['value'] : NULL,
              'mods_relatedItem_host_name_conference_description_ms' => !empty($solr_fields['mods_relatedItem_host_name_conference_description_ms']['value']) ? $solr_fields['mods_relatedItem_host_name_conference_description_ms']['value'] : NULL,
              'mods_note_sponsorship_ms' => !empty($solr_fields['mods_note_sponsorship_ms']['value']) ? $solr_fields['mods_note_sponsorship_ms']['value'] : NULL,
              'mods_note_sponsorshipCode_ms' => !empty($solr_fields['mods_note_sponsorshipCode_ms']['value']) ? $solr_fields['mods_note_sponsorshipCode_ms']['value'] : NULL,
            ];
            ?>
              <?php if (!empty($selection['mods_name_AuthorRole_namePart_custom_ms']) || !empty($selection['mods_name_EditorRole_namePart_custom_ms'])): ?>
              <dd class="first author">
                <?php if (!empty($selection['mods_name_AuthorRole_namePart_custom_ms'])): ?>
                <span class="name">
                  <?php print scholarly_authors_apa6($variables['separator'], $selection['mods_name_AuthorRole_namePart_custom_ms']) ?>
                </span>
                <?php elseif (!empty($selection['mods_name_EditorRole_namePart_custom_ms'])): ?>
                <span class="name">
                  <?php print scholarly_authors_apa6($variables['separator'], $selection['mods_name_EditorRole_namePart_custom_ms']) ?>
                </span>
                <?php endif; ?>
                <span class="year">
                  <?php $year = scholarly_filter_metadata($selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s'][0]); if (preg_match('!(\d\d\d\d)(?:-[0-9-]+)?!', $year, $matches)) { print '(' . $matches[1] . ')'; } ?>
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
              <?php function scholarly_display_label_and_value($solr_fields, $solr_field_name, $separator) {
                      if (!empty($solr_fields[$solr_field_name]['value'])): ?>
                        <?php $solr_field = $solr_fields[$solr_field_name]; ?>
                        <dl title="<?php print $solr_field['display_label']; ?>" class="<?php print $solr_field_name; ?>">
                          <dt><?php print $solr_field['display_label']; ?></dt>
                          <dd><?php print scholarly_filter_metadata(implode($separator, $solr_field['value'])) ?></dd>
                        </dl>
                      <?php endif;
                    } ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_reasonInauguralAddress_m', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_AuthorRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_EditorRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_editorship_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_DegreesupervisorRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_ThesisadvisorRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_CommitteememberRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_name_InterviewerRole_namePart_custom_ms', $variables['separator']); ?> 
              <?php if (isset($selection['mods_genre_authority_local_s'][0]) && preg_match('/>?Doctoral Thesis<?/', $selection['mods_genre_authority_local_s'][0])): ?>
                <dl title="Qualification" class="mods_genre_authority_local_s">
                  <dt>Qualification</dt>
                  <dd>Doctor of Philosophy (Ph.D.)</dd>
                </dl>
              <?php endif; ?>
              <?php if (isset($selection['mods_name_corporate_dgg_affiliation_institution_ms']) || isset($selection['mods_name_corporate_dgg_affiliation_faculty_ms']) || isset($selection['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms'])): ?>
                <dl title="Awarding Institution" class="mods_genre_authority_local_s">
                  <dt>Awarding Institution</dt>
                  <dd>
                    <?php if (isset($selection['mods_name_corporate_dgg_affiliation_institution_ms'][0])): ?>
                      <?php print scholarly_filter_metadata($selection['mods_name_corporate_dgg_affiliation_institution_ms'][0]); ?>
                      <?php if (isset($selection['mods_name_corporate_dgg_affiliation_faculty_ms'][0]) || isset($selection['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms'][0])): ?>
                        <?php print ', '; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if (isset($selection['mods_name_corporate_dgg_affiliation_faculty_ms'][0]) ): ?>
                      <?php print scholarly_filter_metadata($selection['mods_name_corporate_dgg_affiliation_faculty_ms'][0]); ?>
                      <?php if (isset($selection['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms'][0])): ?>
                        <?php print ', '; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php if (isset($selection['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms'][0])): ?>
                      <?php print scholarly_filter_metadata($selection['mods_name_corporate_DegreegrantinginstitutionRole_namePart_custom_ms'][0]); ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if (isset($selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']) && preg_match('/issue/i', $solr_fields['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']['display_label']) !== 1): ?>
                <?php scholarly_display_label_and_value($solr_fields, 'mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s', $variables['separator']); ?> 
              <?php else: ?>
                <?php unset($selection['mods_originInfo_encoding_w3cdtf_keyDate_yes_dateIssued_s']); ?>
              <?php endif; ?>
              <?php if (isset($selection['mods_relatedItem_host_titleInfo_title_ms'])): ?>
                <?php $label = preg_match('!>?(?:Annotation|Article / Letter to editor)<?!i', $selection['mods_genre_authority_local_s'][0]) ? 'Journal' : 'Title of host publication'; ?>
                <dl title="<?php print $label; ?>" class="mods_relatedItem_host_titleInfo_title_ms">
                  <dt><?php print $label; ?></dt>
                  <dd>
                    <?php print scholarly_filter_metadata(implode($variables['separator'], $selection['mods_relatedItem_host_titleInfo_title_ms'])); ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php /* editors Editors of host publication */ ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_originInfo_edition_ms', $variables['separator']); ?> 
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_part_detail_volume_number_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_part_detail_issue_number_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_part_detail_section_title_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_patentNumber_ms', $variables['separator']); ?>
              <?php if (isset($selection['mods_relatedItem_host_part_extent_start_ms'][0]) || isset($selection['mods_relatedItem_host_part_extent_end_ms'][0])): ?>
                <dl title="Pages" class="mods_relatedItem_host_part_extent_start_ms mods_relatedItem_host_part_extent_end_ms">
                  <dt>Pages</dt>
                  <dd>
                    <?php print scholarly_filter_metadata($selection['mods_relatedItem_host_part_extent_start_ms'][0]); ?>
                    <?php if (isset($selection['mods_relatedItem_host_part_extent_start_ms'][0]) && isset($selection['mods_relatedItem_host_part_extent_end_ms'][0])): ?>
                      -
                    <?php endif; ?>
                    <?php print scholarly_filter_metadata($selection['mods_relatedItem_host_part_extent_end_ms'][0]); ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php if (isset($selection['mods_relatedItem_host_note_advancedPublication_ms'][0]) && $selection['mods_relatedItem_host_note_advancedPublication_ms'][0] === 'Yes'): ?>
                <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_note_advancedPublication_ms', $variables['separator']); ?>
              <?php endif; ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_annotationNumber_ms', $variables['separator']); ?>
              <?php if (isset($selection['mods_originInfo_place_placeTerm_text_ms'][0]) || isset($selection['mods_originInfo_publisher_ms'][0])): ?>
                <dl title="Publisher" class="mods_originInfo_place_placeTerm_text_ms mods_originInfo_publisher_ms">
                  <dt>Publisher</dt>
                  <dd>
                    <?php print scholarly_filter_metadata($selection['mods_originInfo_place_placeTerm_text_ms'][0]); ?><?php if (isset($selection['mods_originInfo_place_placeTerm_text_ms'][0], $selection['mods_originInfo_publisher_ms'][0])): ?>:<?php endif; ?>
                    <?php print scholarly_filter_metadata($selection['mods_originInfo_publisher_ms'][0]); ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_language_languageTerm_text_ms', $variables['separator']); ?>
              <?php if (isset($selection['mods_identifier_isbn_ms']) || isset($selection['mods_identifier_eisbn_ms'])): ?>
                <dl title="ISBN" class="mods_identifier_isbn_ms mods_identifier_eisbn_ms">
                  <dt>ISBN</dt>
                  <dd>
                    <?php if (isset($selection['mods_identifier_isbn_ms'])): ?>
                      <?php print scholarly_filter_metadata(implode($variables['separator'], $selection['mods_identifier_isbn_ms'])); ?>
                    <?php endif; ?>
                    <?php if (isset($selection['mods_identifier_isbn_ms']) && isset($selection['mods_identifier_eisbn_ms'])): ?>
                      <?php print $variables['separator']; ?>
                    <?php endif; ?>
                    <?php if (isset($selection['mods_identifier_eisbn_ms'])): ?>
                      <?php print scholarly_filter_metadata(implode($variables['separator'], $selection['mods_identifier_eisbn_ms'])); ?>
                    <?php endif; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_language_languageTerm_text_ms', $variables['separator']); ?>
              <?php if (isset($selection['mods_identifier_doi_ms'])): ?>
                <dl title="DOI" class="mods_identifier_doi_ms">
                  <dt>DOI</dt>
                  <dd>
                    <?php foreach ($selection['mods_identifier_doi_ms'] as $doi): ?>
                      <?php print l(scholarly_filter_metadata($doi), "https://doi.org/$doi", array('attributes' => array('absolute' => TRUE, 'target' => '_blank'))); ?>
                    <?php endforeach; ?>
                  </dd>
                </dl>
              <?php endif; ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_language_languageTerm_text_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_identifier_uri_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_identifier_uriDataset_ms', $variables['separator']); ?>

            <?php
            // Loop though all other fields and print values.
            ?>
            <?php $row_field = 0; ?>
            <?php foreach ($solr_fields as $solr_field => $value): ?>
              <?php if (!array_key_exists($solr_field, $selection)): ?>
                <dl title="<?php print $value['display_label']; ?>" class="<?php print $solr_field; ?>">
                  <dt class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print $value['display_label']; ?></dt>
                  <dd class="<?php print $row_field == 0 ? ' first' : ''; ?>"><?php print scholarly_filter_metadata(implode($variables['separator'], $value['value'])); ?></dd>
                  <?php $row_field++; ?>
                </dl>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (isset($selection['mods_relatedItem_series_titleInfo_title_ms']) || isset($selection['mods_relatedItem_host_titleInfo_partNumber_ms'])): ?>
              <H4>Publication Series</H4>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_series_titleInfo_title_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_titleInfo_partNumber_ms', $variables['separator']); ?>
            <?php endif; ?>
            <?php if (isset($selection['mods_note_coverageCourt_ms']) || isset($selection['mods_part_date_ms']) || isset($selection['mods_part_detail_caseNumber_number_ms']) || isset($selection['mods_identifier_ecli_ms'])): ?>
              <H4>Juridical information</H4>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_coverageCourt_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_part_date_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_part_detail_caseNumber_number_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_identifier_ecli_ms', $variables['separator']); ?>
            <?php endif; ?>
            <?php if (isset($selection['mods_relatedItem_original_titleInfo_title_ms']) || isset($selection['mods_relatedItem_original_name_personal_aut_namePart_ms']) || isset($selection['mods_relatedItem_original_name_corporate_aut_namePart_ms'])): ?>
              <H4>Translation of</H4>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_original_titleInfo_title_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_original_name_personal_aut_namePart_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_original_name_corporate_aut_namePart_ms', $variables['separator']); ?>
            <?php endif; ?>
            <?php if (isset($selection['mods_relatedItem_reviewOf_titleInfo_title_ms']) || isset($selection['mods_relatedItem_reviewOf_name_personal_aut_namePart_family_ms']) || isset($selection['mods_relatedItem_reviewOf_originInfo_dateIssued_ms']) || isset($selection['mods_relatedItem_reviewOf_relatedItem_series_titleInfo_title_ms']) || isset($selection['mods_relatedItem_host_part_detail_series_number_ms']) || isset($selection['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms']) || isset($selection['mods_relatedItem_reviewOf_originInfo_publisher_ms'])): ?>
              <H4>Review of</H4>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_reviewOf_titleInfo_title_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_reviewOf_name_personal_aut_namePart_family_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_reviewOf_originInfo_dateIssued_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_reviewOf_relatedItem_series_titleInfo_title_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_part_detail_series_number_ms', $variables['separator']); ?>
              <?php if (isset($selection['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms'][0]) || isset($selection['mods_relatedItem_reviewOf_originInfo_publisher_ms'][0])): ?>
                <dl title="Publisher" class="mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms mods_relatedItem_reviewOf_originInfo_publisher_ms">
                  <dt>Publisher</dt>
                  <dd>
                    <?php print scholarly_filter_metadata($selection['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms'][0]); ?><?php if (isset($selection['mods_relatedItem_reviewOf_originInfo_place_placeTerm_text_ms'][0], $selection['mods_relatedItem_reviewOf_originInfo_publisher_ms'][0])): ?>:<?php endif; ?>
                    <?php print scholarly_filter_metadata($selection['mods_relatedItem_reviewOf_originInfo_publisher_ms'][0]); ?>
                  </dd>
                </dl>
              <?php endif; ?>
            <?php endif; ?>
            <?php if (isset($selection['mods_relatedItem_host_name_conference_namePart_ms']) || isset($selection['mods_relatedItem_host_name_conference_type_date_namePart_ms']) || isset($selection['mods_relatedItem_host_name_conference_description_ms'])): ?>
              <H4>Conference</H4>
              <?php if(isset($solr_fields['mods_relatedItem_host_name_conference_namePart_ms'])) {
                      // Hack...
                      $solr_fields['mods_relatedItem_host_name_conference_namePart_ms']['value'] = array($solr_fields['mods_relatedItem_host_name_conference_namePart_ms']['value'][0]);
                    } ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_name_conference_namePart_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_name_conference_type_date_namePart_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_relatedItem_host_name_conference_description_ms', $variables['separator']); ?>
            <?php endif; ?>
            <?php if (isset($selection['mods_note_sponsorship_ms']) || isset($selection['mods_note_sponsorshipCode_ms'])): ?>
              <H4>Funding</H4>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_sponsorship_ms', $variables['separator']); ?>
              <?php scholarly_display_label_and_value($solr_fields, 'mods_note_sponsorshipCode_ms', $variables['separator']); ?>
            <?php endif; ?>
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
