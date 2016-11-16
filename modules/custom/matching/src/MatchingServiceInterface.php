<?php

namespace Drupal\matching;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\job_posts\PostedJobInterface;
use Drupal\reviewed_posts\ReviewedPostsInterface;

/**
 * Interface MatchingServiceInterface.
 *
 * @package Drupal\matching
 */
interface MatchingServiceInterface {

  /**
   * Get me one job
   *
   * @param \Drupal\Core\Session\AccountInterface $user
   * @return \Drupal\job_posts\PostedJobInterface
   */
  public function getOneJob(AccountInterface $user);


  /**
   * @param \Drupal\job_posts\PostedJobInterface $job
   * @param \Drupal\Core\Session\AccountInterface $user
   * @return EntityInterface
   */
  public function getReviewedPost(PostedJobInterface $job, AccountInterface $user);

  /**
   * @param \Drupal\job_posts\PostedJobInterface $job
   * @param \Drupal\Core\Session\AccountInterface $user
   * @return EntityInterface  ?????
   */
  public function getApplicants(PostedJobInterface $job, AccountInterface $user);

}
