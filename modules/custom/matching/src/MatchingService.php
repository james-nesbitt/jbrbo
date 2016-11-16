<?php

namespace Drupal\matching;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountInterface;
use Drupal\job_posts\PostedJobInterface;
use Drupal\reviewed_posts\ReviewedPostsInterface;
use Drupal\Core\Database\Query;

/**
 * Class MatchingService.
 *
 * @package Drupal\matching
 */
class MatchingService implements MatchingServiceInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Constructor.
   *
   * @param EntityTypeManager $entity_type_manager
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entity_type_manager = $entity_type_manager;
  }

  /**
   * @param \Drupal\Core\Session\AccountInterface $user
   * @return PostedJobInterface
   */
  public function getOneJob(AccountInterface $user) {

    /** @var \Drupal\Core\Entity\EntityStorageInterface $storagePostedJobs */


    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage */
//      $storage = $this->entity_type_manager->getStorage('reviewed_posts');
//
//
//      $query = $storage->getQuery();
//      $query->condition('field_user', $user->id(), '<>');
//      $query->condition('field_status', 0,'>');
//      //$query->range(0,1);
//      $ids = $query->execute();


    $db = \Drupal::database();

    /** @var \Drupal\Core\Database\Connection $sql_query
     *         query for getting users reviewed posts
     */

    $sql_query =  "select posted_job.id as jobs from posted_job 
    inner join reviewed_posts__field_job on posted_job.id = reviewed_posts__field_job.field_job_target_id 
    inner join reviewed_posts on reviewed_posts.id = reviewed_posts__field_job.entity_id 
    inner join reviewed_posts__field_user on reviewed_posts.id = reviewed_posts__field_user.entity_id 
    where reviewed_posts__field_user.field_user_target_id = " . $user->id() . " group by posted_job.id;";


    /** @var \Drupal\Core\Database\Connection $dbValues */
    $dbValues = $db->query($sql_query)->fetchAllAssoc('jobs');


    /**
     * @var array $reviewed_ids
     *      Contains all jobs user reviewed
     *      Processing to make array usable in 'NOT IN' condition
     */

    foreach ($dbValues as $key => $jobs) {
      foreach ($jobs as $values) {
        $reviewed_ids[] = $values['jobs'];
      }
    }


   // drupal_set_message('Total: '. count($reviewed_ids). '. IDs: '. print_r($reviewed_ids). ' '.$user->id());


    /** @var \Drupal\Core\Entity\EntityStorageInterface $storagePostedJobs */
    $storagePostedJobs = $this->entity_type_manager->getStorage('posted_job');

    /** @var \Drupal\Core\Entity\Query\QueryInterface $query */
    $query = $storagePostedJobs->getQuery();
    if (count($reviewed_ids) > 0) {
      // If user never reviewed, then do not perform condition, because empty array will be passed: NOT IN()
      $query->condition('id', $reviewed_ids, 'NOT IN');
    }

    $query->range(0,1);
    $ids = $query->execute();


   // if (!empty($ids)) {
      $job = $storagePostedJobs->load(reset($ids));
   // }

    return $job;

  }


  /**
   * @param PostedJobInterface $job
   * @param AccountInterface $user
   * @return ReviewedPostsInterface
   */

  public function getReviewedPost(PostedJobInterface $job, AccountInterface $user) {

    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage */
    $storage = $this->entity_type_manager->getStorage('reviewed_posts');

    $query = $storage->getQuery();
    $query->condition('field_job', $job->id());
    $query->condition('field_user', $user->id());
    $query->range(0,1);

    $ids = $query->execute();

    /** @var ReviewedPostsInterface $reviewedPost */

    if (count($ids)>0) {
      $reviewedPost = $storage->load(reset($ids));
    }
    else {
      $reviewedPost = $storage->create([
        'field_job'=> $job->id(),
        'field_user'=> $user->id(),
        // also date field can be added
      ]);
    }

    return $reviewedPost;
  }




  public function getApplicants(PostedJobInterface $job, AccountInterface $user)
  {


  }

}
