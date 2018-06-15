<?php

namespace Drupal\credly\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CredlyBadgeDisplayBlock' block.
 *
 * @Block(
 *  id = "credly_badge_display_block",
 *  admin_label = @Translation("Credly Badge Display Block"),
 * )
 */
class CredlyBadgeDisplayBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['credly_badge_display_block']['#markup'] = '<p>' . $this->credly_badges_content() . '</p>';
    return $build;
  }
  public function credly_badges_content() {
  	$BlockBody = 'Credly body of the Block';
  	return $BlockBody;
  }

}
