<?php

namespace Drupal\job_posts;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Posted job entities.
 *
 * @ingroup job_posts
 */
interface PostedJobInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Posted job name.
   *
   * @return string
   *   Name of the Posted job.
   */
  public function getName();

  /**
   * Sets the Posted job name.
   *
   * @param string $name
   *   The Posted job name.
   *
   * @return \Drupal\job_posts\PostedJobInterface
   *   The called Posted job entity.
   */
  public function setName($name);

  /**
   * Gets the Posted job creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Posted job.
   */
  public function getCreatedTime();

  /**
   * Sets the Posted job creation timestamp.
   *
   * @param int $timestamp
   *   The Posted job creation timestamp.
   *
   * @return \Drupal\job_posts\PostedJobInterface
   *   The called Posted job entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Posted job published status indicator.
   *
   * Unpublished Posted job are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Posted job is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Posted job.
   *
   * @param bool $published
   *   TRUE to set this Posted job to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\job_posts\PostedJobInterface
   *   The called Posted job entity.
   */
  public function setPublished($published);




}
