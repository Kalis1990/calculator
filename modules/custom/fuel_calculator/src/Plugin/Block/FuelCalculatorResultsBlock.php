<?php

namespace Drupal\fuel_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;


namespace Drupal\fuel_calculator\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Fuel Calculator Results' block.
 *
 * @Block(
 *   id = "fuel_calculator_results_block",
 *   admin_label = @Translation("Fuel Calculator Results Block"),
 * )
 */


class FuelCalculatorResultsBlock extends BlockBase {

  public function build() {
    // Retrieve fuel consumption and spend values from state.
    $fuel_consumption = \Drupal::state()->get('fuel_calculator.fuel_consumption');
    $fuel_spend = \Drupal::state()->get('fuel_calculator.fuel_spend');
  
  
    // Build a render array for the results.
    $build = [
      '#markup' => $this->t('Fuel spent: @consumption L/100km<br>Total fuel cost: @spend eu', [
        '@consumption' => $fuel_consumption,
        '@spend' => $fuel_spend,
      ]),
    ];
  
    return $build;
  }
}
  

