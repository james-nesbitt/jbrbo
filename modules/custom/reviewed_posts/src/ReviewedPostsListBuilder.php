<?php

namespace Drupal\reviewed_posts;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Reviewed posts entities.
 *
 * @ingroup reviewed_posts
 */
class ReviewedPostsListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Reviewed posts ID');
 //   $header['name'] = $this->t('Name');
    $header['field_job'] = $this->t('Job Post ID');
    $header['field_user'] = $this->t('User ID');
    $header['field_status'] = $this->t("Status<br><small>(Y=2 N=1)</small>");
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {




    /* @var $entity \Drupal\reviewed_posts\Entity\ReviewedPosts */
    $row['id'] = $entity->id();
//    $row['name'] = $this->l(
//        $entity->label(),
//        new Url(
//            'entity.reviewed_posts.edit_form', array(
//                'reviewed_posts' => $entity->id(),
//            )
//        )
//    );



    /** @var \Drupal\Core\TypedData\TypedDataInterface $fieldItemList */
    $fieldItemList = $entity->get('field_job')->first();
    $row['field_job'] = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";

    $fieldItemList = $entity->get('field_user')->first();
    $row['field_user'] = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";


    $fieldItemList = $entity->get('field_status')->first();
    $row['field_status'] = (!empty($fieldItemList)) ? $fieldItemList->getString() : "EMPTY";



    //$row['field_status'] = "STATUS";

    return $row + parent::buildRow($entity);
  }

}
