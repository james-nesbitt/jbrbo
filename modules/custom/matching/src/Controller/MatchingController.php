<?php

namespace Drupal\matching\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\job_posts\PostedJobInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\matching\MatchingService;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountProxy;


/**
 * Class MatchingController.
 *
 * @package Drupal\matching\Controller
 */
class MatchingController extends ControllerBase {

  /**
   * Drupal\matching\MatchingService definition.
   *
   * @var \Drupal\matching\MatchingService
   */
  protected $matching_service;

  /**
   * {@inheritdoc}
   */
  public function __construct(MatchingService $matching_service,) {
    $this->matching_service = $matching_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('matching.service')
    );
  }

  /**
   * Findcandidates.
   *
   * @return string
   *   Return Hello string.
   */
  public function findCandidates() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: findCandidates')
    ];
  }
  /**
   * Myjobs.
   *
   * @return string
   *   Return Hello string.
   */
  public function myJobs() {

    /**
     * @var AccountInterface $user
     *    The current user
     */
    $user = $this->currentUser();

    /** @var PostedJobInterface $job */
    $job = $this->matching_service->getOneJob($user);

    /** @var EntityViewBuilderInterface $viewBuilder */
    $viewBuilder = $this->entityTypeManager()->getViewBuilder('posted_job');

    /** @var array $myOneJob */
    $myOneJob = $viewBuilder->view($job);

    $preparedViewedPost = $this->matching_service->getReviewedPost($job, $user);

    // Return job and form
    $reviewForm = $this->formBuilder()->getForm('Drupal\matching\Form\UserJobReviewForm', $job, $user);

    return [
      'job' => $myOneJob,
//      'reviewed' => $reviewedPost,
      'form' => $reviewForm
    ];

  }

}
