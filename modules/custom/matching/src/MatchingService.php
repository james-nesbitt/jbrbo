<?php

namespace Drupal\matching;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Session\AccountInterfa;
use Drupal\Core\Session\AccountInterface;
use Drupal\job_posts\PostedJobInterface;
use Drupal\reviewed_posts\ReviewedPostsInterface;

/**
 * Class MatchingService.
 *
 * @package Drupal\matching
 */
class MatchingService implements MatchingServiceInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entity_type_manager = $entity_type_manager;
  }

  /**
   * @param \Drupal\Core\Session\AccountInterface $user
   * @return PostedJobInterface
   */
  public function getOneJob(AccountInterface $user) {

    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage */
    $storage = $this->entity_type_manager->getStorage('posted_job');


    $job = $storage->load(1);
    return $job;

  }


  /**
   * @param PostedJobInterface $job
   * @param AccountInterface $user
   * @return ReviewedPostsInterface
   */

  public function getReviewedPost(PostedJobInterface $job, AccountInterface $user) {

    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage */
    $storage = $this->entity_type_manager->getStorage('reviewed_posts');

    $query = $storage->getQuery();
    $query->condition('field_job', $job->id());
    $query->condition('field_user', $user->id());
    $query->range(0,1);

    $ids = $query->execute();
    if (count($ids)>0) {
      $reviewedPost = $storage->load(reset($ids));
    }
    else {
      $reviewedPost = $storage->create([
        'field_job'=> $job->id(),
        'field_user'=> $user->id(),
      ]);
    }

    return $reviewedPost;

  }

}
