<?php

namespace Drupal\job_posts;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
//use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\taxonomy\Entity\Term;

use Drupal\Core\Field\FieldItemListInterface;



/**
 * Defines a class to build a listing of Posted job entities.
 *
 * @ingroup job_posts
 */
class PostedJobViewBuilder extends EntityListBuilder {



  // Needed method. Called from core/lib/Drupal/Core/Field/FieldConfigBase.php on line 282
  // If is not declared, then site crash on job_posts fields update

  public function resetCache() {

  }




  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'summary') {



    // dsm($entity->toArray());

  //$form = $build_list[0];
    $row_id = $entity->id();

    $form['name'] = [
      '#type' => 'item',
      //'#title' => t('JOB'),
      '#markup' => $entity->label(),
    ];


    $fieldItemList = $entity->get('field_salary')->first();
    $row['field_salary'] = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";


    $form['field_salary'] = [
      '#type' => 'item',
      '#title' => t('Salary'),
      '#markup' => $row['field_salary'],
    ];


    /** @var FieldItemListInterface $fieldItemList */
    $fieldItemList = $entity->get('field_licence');



    /** @var DataDefinitionInterface $fieldLicence */
    $fieldLicence = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";

    $termIds = $fieldItemList->getValue();

    //dsm($termIds);

    $terms = "";
    $reviewed_ids = array();
    foreach ($termIds as $key => $jobs) {
      foreach ($jobs as $values) {
        $terms .= Term::load($values)->getName() . ', ';
      }
    }

    foreach ($termIds as $key => $jobs) {

    }
   // $terms = Term::load($reviewed_ids[0])->getName();

   // dsm($reviewed_ids);



   // dsm($terms);

    $form['field_licence'] = [
      '#type' => 'item',
      '#title' => t('Licence'),
      '#markup' => $fieldLicence . ':<br>' . $terms,
    ];

   // print_r($fieldItemList);


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
