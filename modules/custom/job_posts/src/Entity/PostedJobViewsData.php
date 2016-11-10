<?php

namespace Drupal\job_posts\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Posted job entities.
 */
class PostedJobViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['posted_job']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Posted job'),
      'help' => $this->t('The Posted job ID.'),
    );

    return $data;
  }

}
