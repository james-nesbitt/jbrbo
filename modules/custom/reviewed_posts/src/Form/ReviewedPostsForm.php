<?php

namespace Drupal\reviewed_posts\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Reviewed posts edit forms.
 *
 * @ingroup reviewed_posts
 */
class ReviewedPostsForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\reviewed_posts\Entity\ReviewedPosts */
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
        drupal_set_message($this->t('Created the %label Reviewed posts.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Reviewed posts.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.reviewed_posts.canonical', ['reviewed_posts' => $entity->id()]);
  }

}
