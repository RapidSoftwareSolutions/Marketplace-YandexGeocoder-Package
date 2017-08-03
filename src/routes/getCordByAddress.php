<?php
    $app->post('/api/YandexGeocoder/getCordByAddress', function ($request, $response) {

    echo 2;
        exit();
    $settings = $this->settings;

    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['address']);


    //optional params
    $option = array('key','ll','spn','bbox','rspn','results','skip','lang','apikey','callback');
    $alias = array('lengthDisplayArea' => 'spn','hardLimitation' => 'rspn');

    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $client = $this->httpClient;

    $address = $post_data['args']['address'] ;
    $queryParam = array('geocode' => $address,'format' => 'json');
    foreach($option as $key => $value)
    {
        if(!empty($post_data['args'][$value]))
        {
            if(in_array($value,$alias))
            {
                $keyArr = $alias[$value];
            } else {
                $keyArr = $value;
            }
            $queryParam[$keyArr] = $post_data['args'][$value];
        }
    }


   $client = $this->httpClient;

   try {

     $resp =  $client->request('GET',  $settings['api_url'], ['query' => $queryParam]);

       $responseBody = $resp->getBody()->getContents();
       if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
           $result['callback'] = 'success';
           $result['contextWrites']['to'] =  $responseBody;
    
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
