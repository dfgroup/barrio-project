<?php

/**
 * @file
 * Contains \DFGroup\Barrio\ScriptHandler.
 */

namespace DFGroup\Barrio;

use Composer\Script\Event;
use Composer\Util\ProcessExecutor;

class ScriptHandler {

  /**
   * Moves front-end libraries to Barrio's installed directory.
   *
   * @param \Composer\Script\Event $event
   *   The script event.
   */
  public static function deployLibraries(Event $event) {
    $extra = $event->getComposer()->getPackage()->getExtra();

    if (isset($extra['installer-paths'])) {
      foreach ($extra['installer-paths'] as $path => $criteria) {
        if (array_intersect(['drupal/barrio', 'type:drupal-profile'], $criteria)) {
          $barrio = $path;
        }
      }
      if (isset($barrio)) {
        $barrio = str_replace('{$name}', 'barrio', $barrio);

        $executor = new ProcessExecutor($event->getIO());
        $output = NULL;
        $executor->execute('npm run install-libraries', $output, $barrio);
      }
    }
  }

}
