<?php

/**
* Implements hook_block_info().
*/
function YOUR-MODULE_block_info() {
  $blocks = array();
  $blocks['YOUR-BLOCK-NAME'] = array(
    'info' => t('MY BLOCK TITLE'),
    'cache' => DRUPAL_NO_CACHE
  );
  return $blocks;
}

/**
* Implements hook_block_view().
*/
function YOUR-MODULE_block_view($delta = '') {
  $block = array();
  switch ($delta) {
    case 'YOUR-BLOCK-NAME':
      if (user_access('access content')) {
          $block['subject'] = t('MY BLOCK TITLE');
          $block['content'] = variable_get('YOUR-BLOCK-TEXT', '');
      }
      else {
          $block['content'] = t('No content available.');
      }
    break;
  }
  return $block;
}

/**
 * Implements hook_block_configure()
 */
function YOUR-MODULE_block_configure($delta = '') {
  $form = array();
  if ($delta == 'YOUR-BLOCK-NAME') {
    $form['YOUR-BLOCK-NAME-FORM'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter some text to display'),
      '#size' => 128,
      '#maxlength' => 128,
      '#default_value' => variable_get('YOUR-BLOCK-TEXT', ''),
    );
  }
  return $form;
}
 
/**
 * Implements hook_block_save()
 */
function YOUR-MODULE_block_save($delta = '', $edit = array()) {
  if ($delta == 'YOUR-BLOCK-NAME') {
    variable_set('YOUR-BLOCK-TEXT', $edit['YOUR-BLOCK-TEXT']);
  }
}

?>