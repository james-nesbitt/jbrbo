<?php

namespace Drupal\job_posts;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Posted job entity.
 *
 * @see \Drupal\job_posts\Entity\PostedJob.
 */
class PostedJobAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\job_posts\PostedJobInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished posted job entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published posted job entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit posted job entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete posted job entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add posted job entities');
  }

}
