<?php

namespace Drupal\reviewed_posts;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Reviewed posts entities.
 *
 * @ingroup reviewed_posts
 */
class ReviewedPostsListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Reviewed posts ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\reviewed_posts\Entity\ReviewedPosts */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.reviewed_posts.edit_form', array(
          'reviewed_posts' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
