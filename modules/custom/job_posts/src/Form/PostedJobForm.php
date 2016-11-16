<?php

namespace Drupal\job_posts\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Posted job edit forms.
 *
 * @ingroup job_posts
 */
class PostedJobForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\job_posts\Entity\PostedJob */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;




    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Posted job.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Posted job.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.posted_job.canonical', ['posted_job' => $entity->id()]);
  }

}
