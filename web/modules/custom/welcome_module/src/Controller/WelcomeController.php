<?php

namespace Drupal\welcome_module\Controller;

/**
 *
 */
class WelcomeController {

  /**
   *
   */
  public function welcome() {
    return [
      '#markup' => 'Welcome to our Website.',
    ];
  }

}
