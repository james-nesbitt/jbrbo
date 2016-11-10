<?php

/**
 * @file
 * Contains posted_job.page.inc.
 *
 * Page callback for Posted job entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Posted job templates.
 *
 * Default template: posted_job.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_posted_job(array &$variables) {
  // Fetch PostedJob Entity Object.
  $posted_job = $variables['elements']['#posted_job'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
