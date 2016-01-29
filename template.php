<?php

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function cleanish_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= backdrop_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= backdrop_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function cleanish_preprocess_node(&$variables) {
  $node = $variables['node'];
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

/**
 * Preprocess menu_link to identify top level of main-menu
 * Note : preprocess_menu_link is FIFO, while theme_menu_tree is LIFO
 */
function cleanish_preprocess_menu_link(&$variables) {
  static $count = 0;
  if ($variables['theme_hook_original'] == 'menu_link__main_menu') {
    if ($count++ == 0) {
      $variables['element']['#attributes']['class'][] = 'top-level-main-menu';
    }
  }
}

/**
 * Theme main-menu to make it responsive easy
 */
function cleanish_menu_tree__main_menu(&$variables) {
//return '<ul class="menu clearfix">' . $variables['tree'] . '</ul>';
  return (strpos($variables['tree'], 'top-level-main-menu') !== FALSE) ?
'<nav id="main-menu" class="responsive-menu" role="navigation">
<a class="nav-toggle" href="#">Navigation</a>
<div class="menu-navigation-container">
<ul class="menu top-level-main-menu clearfix">
' . $variables['tree'] . '
</ul>
</div>
<div class="clear"></div>
</nav><!-- end main-menu -->
'
 : '
<ul class="menu clearfix">
' . $variables['tree'] . '
</ul>
';
}

