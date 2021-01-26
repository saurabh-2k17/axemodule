<?php

namespace Drupal\axelerant\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * {@inheritdoc}
 */
class CommonController extends ControllerBase {

  /**
   * Returns JSON response with basic page title value.
   */
  public function getApi($auth, $nid) {
    $apiKey = \Drupal::config('system.site')->get('siteapikey');
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    $contentType = $node->get('type')->getValue()[0]['target_id'];
    if ($auth == $apiKey && $contentType === 'page') {
      $title = ["Title" => $node->get('title')->getValue()[0]['value']];
      return new JsonResponse($title);
    }
    else {
      throw new AccessDeniedHttpException();
    }

  }

}
