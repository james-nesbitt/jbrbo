<?php

/**
 * @file
 * Contains reviewed_posts.page.inc.
 *
 * Page callback for Reviewed posts entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Reviewed posts templates.
 *
 * Default template: reviewed_posts.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_reviewed_posts(array &$variables) {
  // Fetch ReviewedPosts Entity Object.
  $reviewed_posts = $variables['elements']['#reviewed_posts'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
