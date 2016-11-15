<?php

namespace Drupal\matching\Form;

use Drupal\Core\Datetime\Element\DateElementBase;
use Drupal\Core\Datetime\Element\Datetime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\reviewed_posts\ReviewedPostsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\matching\MatchingService;

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
   * Constructor
   *
   * @param MatchingService $matching_service
   */
  public function __construct(
    MatchingService $matching_service
  ) {
    $this->matching_service = $matching_service;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('matching.service')
    );
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
     * @var array $buildArgs
     *     arguments passed into the form builder;
     */

   // $buildArgs = $form_state->getBuildInfo();


    /**
     * @TODO check to make sure that we received proper context
     */

    /**
     * Put job and account into the form as values
     * (these are never sent to the client)
     */

//
//    $form['job'] = [
//      '#type' => 'value',
//      '#value' => $buildArgs['job']
//    ];
//
//    $form['account'] = [
//      '#type' => 'value',
//      '#value' => $buildArgs['account']
//    ];


//      $form['field_date_of_review'] = [
//          '#type' => 'value',
//          '#value' => '13/12/2016'
//      ];
//
//
//      $form['status'] = [
//          '#type' => 'value',
//          '#value' => '13/12/2016'
//      ];


   // return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $job = $form_state->get('job');
    $account = $form_state->get('account');

    /** @var ReviewedPostsInterface $jobReview */
   $jobReview = $this->matching_service->getReviewedPost($job, $account);

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

      /**
       * Technically, the above lines can be converted into a 1-line
       *
       * $jobReview->set('field_state', $jobReview->get('field_state')->set(0, $trigger['#state']));
       */

      if ($jobReview->save()) {
        drupal_set_message('Saved job review');
      }
    }

  }

}
