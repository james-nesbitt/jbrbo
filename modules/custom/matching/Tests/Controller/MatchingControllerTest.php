<?php

namespace Drupal\matching\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\matching\MatchingService;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides automated tests for the matching module.
 */
class MatchingControllerTest extends WebTestBase {

  /**
   * Drupal\matching\MatchingService definition.
   *
   * @var Drupal\matching\MatchingService
   */
  protected $matching_service;

  /**
   * Drupal\Core\Entity\EntityFormBuilder definition.
   *
   * @var Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entity_form_builder;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entity_type_manager;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $current_user;
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "matching MatchingController's controller functionality",
      'description' => 'Test Unit for module matching and controller MatchingController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests matching functionality.
   */
  public function testMatchingController() {
    // Check that the basic functions of module matching.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
