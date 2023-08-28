<?php 

namespace Drupal\fuel_calculator\Controller;

use Drupal\Core\Controller\ControllerBase;

class FuelCalculatorPageController extends ControllerBase {

  public function content() {
    $block = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view('fuel_calculator_block'); // Replace with the actual block ID

    $results_block = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view('fuel_calculator_results_block'); // Replace with the actual results block ID

    return [
      'fuel_calculator_block' => $block,
      'fuel_calculator_results_block' => $results_block,
    ];
  }
}
