<?php

namespace Drupal\job_posts;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Link;


/**
 * Defines a class to build a listing of Posted job entities.
 *
 * @ingroup job_posts
 */
class PostedJobViewBuilder extends EntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Posted job ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\job_posts\Entity\PostedJob */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.posted_job.edit_form', array(
          'posted_job' => $entity->id(),
        )
      )
    );

    return $row + parent::buildRow($entity);
  }


  public function view(EntityInterface $entity) {



    $fieldItemList = $entity->get('field_salary')->first();
    $row['field_job'] = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";


    $form['from'] = [
      '#type' => 'item',
      '#title' => t('Salary'),
      '#markup' => $row['field_job'],
    ];

    $row_id = $entity->id();
/*
    $url = Url::fromRoute('entity.posted_job.add_form', ['node' => $row_id]);
    $project_link = Link::fromTextAndUrl(t('Open Project'), $url);
    $project_link = $project_link->toRenderable();
// If you need some attributes.
    $project_link['#attributes'] = ['class' => array('button', 'button-action')];
//print render($project_link);

*/

    $form['custom_1'] = [
      '#type' => 'item',
      '#markup' => "<a href = '". $GLOBALS['base_url'] ."/applicants/$row_id'>Applicant list</a>" ];

    return $form;
  }


}
