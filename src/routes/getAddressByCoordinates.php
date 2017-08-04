<?php

$app->post('/api/YandexGeocoder/getAddressByCoordinates', function ($request, $response) {


      $settings = $this->settings;
      $checkRequest = $this->validation;
      $validateRes = $checkRequest->validate($request, ['coordinates']);
      //optional params
      $option = array(
        'coordinates' => 'geocode',
        'orderCoordinates' => 'sco',
        'toponymType' => 'kind',
        'mapCenter' => 'll',
        'searchAreaSize' => 'spn',
        'alternativeSearch' => 'bbox',
        'searchAreaRestriction' => 'rspn',
        'results' => 'results',
        'skip' => 'skip',
        'language' => 'lang',
        'apiKey' => 'apikey'
      );
      $arrayType = array("toponymType");

      if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
          return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
      } else {
          $postData = $validateRes;
      }
      $client = $this->httpClient;



      $queryParam = array('format' => 'json');

//reverse coord
      $part = explode(',',$postData['args']['mapCenter']);
            if(!empty($part[0]) && !empty($part[1]))
            {
              $part[0] = trim($part[0]);
              $part[1] = trim($part[1]);
            }
        $postData['args']['mapCenter'] = implode(',',array_reverse($part));

//reverse coord
        $part = explode(',',$postData['args']['coordinates']);
              if(!empty($part[0]) && !empty($part[1]))
              {
                $part[0] = trim($part[0]);
                $part[1] = trim($part[1]);
              }
          $postData['args']['coordinates'] = implode(',',array_reverse($part));



      if(!empty($postData['args']['searchAreaRestriction'][0]) && $postData['args']['searchAreaRestriction'][0] == 'On')
      {
        $postData['args']['searchAreaRestriction'] = 1;
      }
    foreach($option as $alias => $value)
      {
        if(!empty($postData['args'][$alias]))
        {
            if(in_array($alias,$arrayType))
            {
              $postData['args'][$alias] = implode(',',$postData['args'][$alias]);
            }
            $queryParam[$value] = $postData['args'][$alias];
        }
      }



     $client = $this->httpClient;


     try {
       $resp =  $client->request('GET',  'https://geocode-maps.yandex.ru/1.x/', ['query' => $queryParam]);

         $responseBody = $resp->getBody()->getContents();

         if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {

             $result['callback'] = 'success';
             $result['contextWrites']['to'] =  $responseBody;
             if(empty($result['contextWrites']['to'])) {
                 $result['contextWrites']['to']['status_msg'] = "This item exist";
             }

         } else {
             $result['callback'] = 'error';
             $result['contextWrites']['to']['status_code'] = 'API_ERROR';
             $result['contextWrites']['to']['status_msg'] = "Wrong param";
         }
     } catch (\GuzzleHttp\Exception\ClientException $exception) {
         $responseBody = $exception->getResponse()->getBody()->getContents();
         if(empty(json_decode($responseBody))) {
             $out = $responseBody;
         } else {
             $out = json_decode($responseBody);
         }
         $result['callback'] = 'error';
         $result['contextWrites']['to']['status_code'] = 'API_ERROR';
         $result['contextWrites']['to']['status_msg'] = "Wrong param";
     } catch (GuzzleHttp\Exception\ServerException $exception) {
         $responseBody = $exception->getResponse()->getBody()->getContents();
         if(empty(json_decode($responseBody))) {
             $out = $responseBody;
         } else {
             $out = json_decode($responseBody);
         }
         $result['callback'] = 'error';
         $result['contextWrites']['to']['status_code'] = 'API_ERROR';
         $result['contextWrites']['to']['status_msg'] = "Wrong param";
     } catch (GuzzleHttp\Exception\ConnectException $exception) {
         $responseBody = $exception->getResponse()->getBody(true);
         $result['callback'] = 'error';
         $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
         $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';
     }
     return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
