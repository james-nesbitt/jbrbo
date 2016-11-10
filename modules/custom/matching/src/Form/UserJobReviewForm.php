<?php

namespace Drupal\matching\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;
  public function __construct(
    MatchingService $matching_service,
    EntityTypeManager $entity_type_manager
  ) {
    $this->matching_service = $matching_service;
    $this->entity_type_manager = $entity_type_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('matching.service'),
      $container->get('entity_type.manager')
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
    $form['applay'] = array(
      '#type' => 'button',
      '#value' => $this->t('Approve'),
      '#description' => $this->t('Apllay for Job'),
    );
    $form['reject'] = array(
      '#type' => 'button',
      '#value' => $this->t('Reject'),
      '#description' => $this->t('Reject Job Offer'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
