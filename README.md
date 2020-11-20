# Drupal 7: Programmatically Create a Block
 How to programmatically create a block for your Drupal 7 web site

So you want to add a block to your module in Drupal 7. First, define its internal name and human-readable title (for the Blocks UI) with hook_block_info():

```php	
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
```

Then, give it the permissions needed to view it, a title (to appear for your site visitors), and some content with hook_block_view():

```php	
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
```

If you want to give the block a visual configurator -- the "Configure" link in the Blocks UI -- beyond what's already provided by the Block module (title, description, visibility settings, etc.), use hook_block_configure() and hook_block_save():

```php	
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
    variable_set('YOUR-BLOCK-TEXT', $edit['YOUR-BLOCK-NAME-FORM']);
  }
}
```

By using variable_set() and variable_get(), when you save some text in your custom field, Drupal will write the text into the variables table in its database and retrieve the text whenever the block is displayed.
