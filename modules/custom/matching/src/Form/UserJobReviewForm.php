<?php

namespace Drupal\matching\Form;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\job_posts\PostedJobInterface;
use Drupal\reviewed_posts\ReviewedPostsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\matching\MatchingService;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class UserJobReviewForm.
 *
 * @package Drupal\matching\Form
 */
class UserJobReviewForm extends FormBase {

  /**
   * Drupal\matching\MatchingService definition.
   *
   * @var \Drupal\matching\MatchingService
   */
  protected $matching_service;

  /**
   * Job for which this review is taking place
   *
   * @protected Drupal\job_posts\PostedJobInterface $job
   */
  protected $job;

  /**
   * User account for which this review is taking place
   *
   * @protected Drupal\Core\Session\AccountInterface $account
   */
  protected $account;

  /**
   * Constructor
   */
  public function __construct(
    MatchingService $matching_service
  ) {
    $this->matching_service = $matching_service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('matching.service')
    );
  }

  public function Initialize(PostedJobInterface $job, AccountInterface $account) {
    $this->job = $job;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_job_review';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /**
     * Put job and account into the form as values
     * (these are never sent to the client)
     */
    $form['job'] = [
      '#type' => 'value',
      '#value' => $this->job
    ];
    $form['account'] = [
      '#type' => 'value',
      '#value' => $this->account
    ];

    /**
     *  Action buttons
     */
    $form['applay'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Approve'),
      '#description' => $this->t('Apllay for Job'),
      '#state' => 1
    );
    $form['reject'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Reject'),
      '#description' => $this->t('Reject Job Offer'),
      '#state' => 0
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $job = $form_state->get('job');
    $account = $form_state->get('account');

    /** @var EntityStorageInterface $jobReviewStorage */
    $jobReviewStorage = $this->entityTypeManager()->getStorage('reviewed_posts');

    /** @var array $jobReviewMatches */
    $jobReviewMatches = $jobReviewStorage->getQuery()
      ->condition('field_job', $job)
      ->condition('field_user', $account)
      ->range(0,1)
      ->execute();

    /** @var ReviewedPostsInterface $jobReview */

    if (count($jobReviewMatches) > 0) {
      $jobReview = $jobReviewStorage->load(reset($jobReviewStorage));
    }
    else {
      $jobReview = $jobReviewStorage->create([
        'field_job' => $job,
        'field_user' => $account
      ]);
    }

    /** @var array $trigger */
    $trigger = $form_state->getTriggeringElement();
    if (isset($trigger['#state'])) {
      /**
       * Update the state field from the form value
       */

      /** @var FieldItemListInterface $jobReviewState */
      $jobReviewState = $jobReview->get('field_state');
      $jobReviewState->set(0, $trigger['#state']);
      $jobReview->set('field_state', $jobReviewState);

      if ($jobReview->save()) {
        drupal_set_message('Saved job review');
      }
    }

  }

}
