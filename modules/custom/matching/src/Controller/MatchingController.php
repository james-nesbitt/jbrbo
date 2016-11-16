<?php

namespace Drupal\matching\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\job_posts\PostedJobInterface;
use Drupal\matching\Form\UserJobReviewForm;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\matching\MatchingService;


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
  public function __construct(MatchingService $matching_service) {
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
   * ApplicantList.
   *
   * @return string
   *   Return Hello string.
   */
  public function applicantList($posted_job) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: applicantList with 1 argument (<b>'. $posted_job. '</b>) - Posted job')
    ];
  }




  /**
   * Myjobs.
   *

   */
  public function myJobs() {

    /** @var AccountInterface $user */
    $user = $this->currentUser();

    /** @var PostedJobInterface $job */
    $job = $this->matching_service->getOneJob($user);


    /** @var EntityViewBuilderInterface $viewBuilder */
    $viewBuilder = $this->entityTypeManager()->getViewBuilder('posted_job');


    if (!empty($job)) {
      // if there is any job post, then show it...
      $preparedViewedPost = $this->matching_service->getReviewedPost($job, $user);

      /** @var EntityFormBuilderInterface $formBuilder */
      $formBuilder = $this->entityFormBuilder();

      /** @var array $reviewForm */
      $reviewForm = $formBuilder->getForm($preparedViewedPost, 'review');
      return [
        'job' => $viewBuilder->view($job),
        //'form' => $this->formBuilder()->buildForm('Drupal\matching\Form\UserJobReviewForm');
        'form' => $reviewForm
      ];
    }

    else {
      // If there are no more jobs to offer, say something
      return [
        '#type' => 'markup',
        '#markup' => $this->t("All posts reviewed or not created. Nothing to see...<br />(SadFace)")
      ];

    }


  }

}
