<?php
/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

  /* Your code goes here. */
    $entity = $row->_field_data['nid']['entity'];
    $image_uri = file_create_url($entity->field_image_block[LANGUAGE_NONE][0]['uri']);
    $image_alt = file_create_url($entity->field_image_block[LANGUAGE_NONE][0]['alt']);
    ?>

    <div class="ubl-hero" style="background-image: url(<?php print(file_create_url($image_uri)) ?>)">

      <img src="<?php print(file_create_url($image_uri)) ?>" alt="<?php print $image_alt ?>" class="ubl-hero-image">

      <div class="ubl-centercontent">

        <div class="ubl-hero-lead">
          <h1><?php print $entity->title ?></h1>
          <p>
            <a href="<?php print $entity->field_link[LANGUAGE_NONE][0]['url']; ?>">
              <?php print $entity->field_body[LANGUAGE_NONE][0]['safe_value']; ?>
              <i><?php print $entity->field_link[LANGUAGE_NONE][0]['title']; ?></i>
            </a>
          </p>
        </div>

    </div>

</div>




