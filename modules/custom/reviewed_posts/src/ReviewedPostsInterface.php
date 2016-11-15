<?php

namespace Drupal\reviewed_posts;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Reviewed posts entities.
 *
 * @ingroup reviewed_posts
 */
interface ReviewedPostsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
    const REJECTED = 1;
    const ACCEPTED = 2;

  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Reviewed posts name.
   *
   * @return string
   *   Name of the Reviewed posts.
   */
  public function getName();

  /**
   * Sets the Reviewed posts name.
   *
   * @param string $name
   *   The Reviewed posts name.
   *
   * @return \Drupal\reviewed_posts\ReviewedPostsInterface
   *   The called Reviewed posts entity.
   */
  public function setName($name);

  /**
   * Gets the Reviewed posts creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Reviewed posts.
   */
  public function getCreatedTime();

  /**
   * Sets the Reviewed posts creation timestamp.
   *
   * @param int $timestamp
   *   The Reviewed posts creation timestamp.
   *
   * @return \Drupal\reviewed_posts\ReviewedPostsInterface
   *   The called Reviewed posts entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Reviewed posts published status indicator.
   *
   * Unpublished Reviewed posts are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Reviewed posts is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Reviewed posts.
   *
   * @param bool $published
   *   TRUE to set this Reviewed posts to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\reviewed_posts\ReviewedPostsInterface
   *   The called Reviewed posts entity.
   */
  public function setPublished($published);

}
