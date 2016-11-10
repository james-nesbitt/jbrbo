<?php

namespace Drupal\reviewed_posts;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Reviewed posts entity.
 *
 * @see \Drupal\reviewed_posts\Entity\ReviewedPosts.
 */
class ReviewedPostsAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\reviewed_posts\ReviewedPostsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished reviewed posts entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published reviewed posts entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit reviewed posts entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete reviewed posts entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add reviewed posts entities');
  }

}
