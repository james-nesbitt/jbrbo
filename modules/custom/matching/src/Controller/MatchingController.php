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
   * Drupal\Core\Entity\EntityFormBuilder definition.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entity_form_builder;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $current_user;
  /**
   * {@inheritdoc}
   */
  public function __construct(MatchingService $matching_service, EntityFormBuilder $entity_form_builder, EntityTypeManager $entity_type_manager, AccountProxy $current_user) {
    $this->matching_service = $matching_service;
    $this->entity_form_builder = $entity_form_builder;
    $this->entity_type_manager = $entity_type_manager;
    $this->current_user = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('matching.service'),
      $container->get('entity.form_builder'),
      $container->get('entity_type.manager'),
      $container->get('current_user')
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

    /** @var EntityViewBuilderInterface $viewBuilder
     *        view builder for PostedJob entities */
    $viewBuilder = $this->entityTypeManager()->getViewBuilder('posted_job');

    /**
     * @var array $myOneJob
     */
     $myOneJob = $viewBuilder->view($job);


    $preparedViewedPost = $this->matching_service->getReviewedPost($job, $user);

    /** @var EntityFormBuilderInterface $formBuilder */
    $formBuilder = $this->entityFormBuilder();
    $reviewForm = $formBuilder->getForm($preparedViewedPost, 'review');

//$reviewedPost = $viewBuilder->view($preparedViewedPost);

    //$reviewForm = $this->entityFormBuilder()->getForm('Drupal\matching\Form\UserJobReviewForm');

   // $reviewForm = $this->formBuilder()->getForm('Drupal\matching\Form\UserJobReviewForm');
    //$reviewForm = [ '#type' => 'markup', '#markup' => 'form goes here'];

    // Return job and form
  //  $reviewForm = $this->formBuilder()->getForm('Drupal\matching\Form\UserJobReviewForm');

    return [
      'job' => $myOneJob,
//      'reviewed' => $reviewedPost,
      'form' => $reviewForm
    ];

  }

}
