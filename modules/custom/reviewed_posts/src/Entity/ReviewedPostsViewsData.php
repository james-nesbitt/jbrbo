<?php

namespace Drupal\reviewed_posts\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Reviewed posts entities.
 */
class ReviewedPostsViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['reviewed_posts']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Reviewed posts'),
      'help' => $this->t('The Reviewed posts ID.'),
    );

    return $data;
  }

}
