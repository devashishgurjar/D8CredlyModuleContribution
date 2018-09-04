<?php

/**
 * @file
 * Contains \Drupal\siteinformation_form_alter\Controller\NodeAccessController.
 */

namespace Drupal\siteinformation_form_alter\controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NodeAccessController Controller.
 */

class NodeAccessController extends ControllerBase {

     /**
     * @param $api_key - the site API key parameter
     * @param NodeInterface $node_id - the node built from the node_id parameter
     * @return JsonResponse
     */

     public function page_node_access($api_key, $node_id) {
        // Loading the Node using the Node id from the request URL.
        $node_detail = \Drupal::entityTypeManager()->getStorage('node')->load($node_id);
        // Site API Key configuration value.
        $siteinfo_apikey = \Drupal::config('system.site')->get('siteapikey');
        if (isset($node_detail)) {
          // Getting node type if its not empty.
          $node_type = $node_detail->getType();
        }
        // Given api key matches the saved system saved api key and node is not empty and of type page.
        if ((isset($node_detail)) && ($siteinfo_apikey == $api_key) && ($node_type == 'page')) {
          // Serializing page node type data in the form of JSON representation.
          $serialize_service = \Drupal::service('serializer');
          $node_json = $serialize_service->serialize($node_detail, 'json', ['plugin_id' => 'entity']);
          // Creating new reponse to load JSON content inside it.
          $resulted_json = new Response();
          $resulted_json->setContent($node_json);
          // Setting header for JSON response.
          $resulted_json->headers->set('Content-Type', 'application/json');
          // Returns correct JSON response.
          return $resulted_json;
        }
        else{
          // JSON response for not valid values.
          return new JsonResponse(["error" => "access denied"], 401, ['Content-Type' => 'application/json']);
        }
     }

}