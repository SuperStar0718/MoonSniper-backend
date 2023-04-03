<?php
// echo date_default_timezone_get();
date_default_timezone_set("UTC");
$baseURL = 'https://moonsniper.co';
$servername = "127.0.0.1";
$username = "root";
$password = "Sn!per0123";
$dbname = "moon_sniper_v2";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$NotificationsTable = "notifications";
$coinsDataTable = "coin_data";

$sql = "SELECT * FROM " . $NotificationsTable . " WHERE note IS NULL";
$result = mysqli_query($conn, $sql);
$dataArray = array();
$coinsData = array();
// Loop through the results and print the values
if (mysqli_num_rows($result) > 0) {
    $coinid_string = '';
    $coinid_string2 = '';

    while ($row = mysqli_fetch_assoc($result)) {
        foreach ($row as $key => $value) {
            // Perform operations on each key-value pair
            if ($value != null && $key == 'data') {
                // $coinid_string[] = json_decode($row['data']);
                $data = json_decode($row['data'], true);
                $row['data'] = $data;
                $dataArray[] = $row;
                if ($row['type'] == 'App\Notifications\NotifyCoinAlert') {
                    if(!strpos($coinid_string, $data['coin_id'])){
                     $coinid_string .= $data['coin_id'] . ',';
                    $coinid_string2 .= $data['coin_id'] . ',';

                    }

                }
            }

        }
       
    }
    if($coinid_string != ''){
        $ids_array = array_unique(explode(',', $coinid_string)); // Convert the string to an array
         $coinid_string = "'" . implode("', '", $ids_array) . "'"; 
          $coinDatasql = "SELECT coin_id,symbol,price_change_percentage_24h,current_price,roi_percentage,market_cap,next_unlock_percent_of_tokens,average_sentiment_change FROM " . $coinsDataTable . " WHERE  `coin_id` IN ($coinid_string) ";
        // echo $coinid_string .'</br>';
        // echo $coinDatasql;
        $coinsData = mysqli_query($conn, $coinDatasql);
    }
    // print_r(json_encode($coinsData));die();  

    mysqli_close($conn);
    // Print the resulting JSON string
    $url = "https://api.coingecko.com/api/v3/simple/price?ids=".$coinid_string2."&vs_currencies=USD"; 

// Create a new cURL resource
    $curl = curl_init($url);

// Set the cURL options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// Make the API call
    $response = curl_exec($curl);
// Check for errors
    if (curl_errno($curl)) {
        echo "Error: " . curl_error($curl);
    }

// Close the cURL resource
    curl_close($curl);

// Process the response data
    $Pricedata = $response;
 
    $arrayData = [];

    $notify =  false;
    $notifyPrice =  false;
    $notifyMCap =  false;
    $notifyUnlock =  false;
    $notifySentiment =  false;
    $notifyROI =  false;
    $notifyVolume =  false;

    function getcoinById($id,$coinsData){
        while ($row = mysqli_fetch_assoc($coinsData)) {
            if ($row['coin_id'] === $id) {
              // Found a row with the matching ID
              return $row;
              break; // exit the loop once you find the row
            }
    }
}
    foreach ($dataArray as $key => $value) {
        $notify =  false;
        $notifyPrice =  false;
        $notifyMCap =  false;
        $notifyUnlock =  false;
        $notifySentiment =  false;
        $notifyROI =  false;
        $notifyVolume =  false;
        $Message = '';
        if ($value['type'] == 'App\Notifications\NotifyCoinAlert') {
            $priceData = json_decode($Pricedata);
            $activeCoin = getcoinById($value['data']['coin_id'],$coinsData);
            //price data checking
            if (isset($value['data']['min_price']) || isset($value['data']['max_price'])) {
                if(!isset($priceData->status->error_code)){
                    if (isset($value['data']['min_price']) && floatval($value['data']['min_price']) > floatval($priceData->{$value['data']['coin_id']}->usd)) {
                        $Message = 'Price is: ' . formatNumber($priceData->{$value['data']['coin_id']}->usd) . '$';
                        $notify = true;
                        $notifyPrice = true;
                    } else if (isset($value['data']['max_price']) && floatval($value['data']['max_price']) < floatval($priceData->{$value['data']['coin_id']}->usd)) {
                        $Message = 'Price is: ' . formatNumber($priceData->{$value['data']['coin_id']}->usd) . '$';
                        
                        $notify = true;
                        $notifyPrice = true;
                    }
                }else{
                print_r($Pricedata);
                    $notifyPrice = false;
                }
               

            }else{
                $notifyPrice = true;
            }
            //trading in last 24 hours checking
            if($activeCoin){
                if (isset($value['data']['min_tradingper24h']) || isset($value['data']['max_tradingper24h'])) {
                    if ($notify) {
                        $Message .= ',';
                        $notify = false;
                      }
                    if (isset($value['data']['min_tradingper24h'])) {
                        if($activeCoin['price_change_percentage_24h'] != null && floatval($value['data']['min_tradingper24h']) > $activeCoin['price_change_percentage_24h']){
                         $Message .= '24h trading %: ' . formatNumber($activeCoin['price_change_percentage_24h']);
                            $notify = true;
                            $notifyVolume = true;
                        }
                       

                    }  if (isset($value['data']['max_tradingper24h'])) {

                        if($activeCoin['price_change_percentage_24h'] != null && floatval($value['data']['max_tradingper24h']) < $activeCoin['price_change_percentage_24h']){
                      
                         
                            $result = floatval($value['data']['max_tradingper24h']) < $activeCoin['price_change_percentage_24h'];
                            $Message .= '24h trading %: ' . formatNumber($activeCoin['price_change_percentage_24h']);
                          
                            $notify = true;
                            $notifyVolume = true;
                        }
                    }
    
                }else{
                    $notifyVolume = true;
                }
                if (isset($value['data']['min_roipercentage']) || isset($value['data']['max_roipercentage'])) {
                    if ($notify) {
                        $Message .= ',';
                        $notify = false;
                      }
                    if (isset($value['data']['min_roipercentage']) ) {
                        if( $activeCoin['roi_percentage']!= null && floatval($value['data']['min_roipercentage']) > $activeCoin['roi_percentage']){
                            $Message .= 'ROI% is: ' . formatNumber($activeCoin['roi_percentage']);
                            $notify = true;
                            $notifyROI = true;
                        }       

                    }  if (isset($value['data']['max_roipercentage'])) {
                        if($activeCoin['roi_percentage']!= null && floatval($value['data']['max_roipercentage']) < $activeCoin['roi_percentage']){
                            $Message .= 'ROI% is: ' . formatNumber($activeCoin['roi_percentage']) ;
                            $notify = true;
                            $notifyROI = true;
                        }   
                    }
    
                }else{
                    $notifyROI = true;
                }
                if (isset($value['data']['min_marketcap']) || isset($value['data']['max_marketcap'])) {
                    if ($notify) {
                        $Message .= ',';
                        $notify = false;
                      }
                    if (isset($value['data']['min_marketcap'])) {
                        if($activeCoin['market_cap'] != null&& floatval($value['data']['min_marketcap']) > $activeCoin['market_cap']){
                            $Message .= 'Market cap is: ' . formatNumber($activeCoin['market_cap']);
                            $notify = true;
                            $notifyMCap = true;
                        }
                       
                    }  if (isset($value['data']['max_marketcap'])) {
                        if( $activeCoin['market_cap']!= null && floatval($value['data']['max_marketcap']) < $activeCoin['market_cap']){
                            $result = floatval($value['data']['max_marketcap']) < $activeCoin['market_cap'];
                            $Message .= 'Market cap is: ' . formatNumber($activeCoin['market_cap']) ;
                            $notify = true;
                            $notifyMCap = true;
                        }   
                       

                    }
    
                }else{
                    $notifyMCap = true;
                }
                if (isset($value['data']['min_nextunlock']) || isset($value['data']['max_nextunlock'])) {
                    if ($notify) {
                        $Message .= ',';
                        $notify = false;
                      }
                    if (isset($value['data']['min_nextunlock'])) {
                        if( $activeCoin['next_unlock_percent_of_tokens']!= null && floatval($value['data']['min_nextunlock']) > $activeCoin['next_unlock_percent_of_tokens']){
                            $Message .= 'Next unlock % is: ' . formatNumber($activeCoin['next_unlock_percent_of_tokens']);
                            $notify = true;
                            $notifyUnlock = true;
                        }
                       

                    } else if (isset($value['data']['max_nextunlock'])) {
                        if( $activeCoin['next_unlock_percent_of_tokens'] != null&& floatval($value['data']['max_nextunlock']) < $activeCoin['next_unlock_percent_of_tokens']){
                            $Message .= 'Next unlock % is: ' . formatNumber($activeCoin['next_unlock_percent_of_tokens']) ;
                            $notify = true;
                            $notifyUnlock = true;
                        }
                       

                    }
    
                }else{
                    $notifyUnlock = true;
                }
                if (isset($value['data']['min_socialsentiments']) || isset($value['data']['max_socialsentiments'])) {
                    if ($notify) {
                        $Message .= ',';
                        $notify = false;
                      }
                    if (isset($value['data']['min_socialsentiments'])) {
                        if($activeCoin['average_sentiment_change'] != null && floatval($value['data']['min_socialsentiments']) > floatval($activeCoin['average_sentiment_change'])){
                            $Message .= 'Social sentiment change is: ' . formatNumber($activeCoin['average_sentiment_change']);
                            $notify = true;
                            $notifySentiment = true;
                        }
                   

                    } else if (isset($value['data']['max_socialsentiments']) ) {
                        if($activeCoin['average_sentiment_change']!= null && floatval($value['data']['max_socialsentiments']) < floatval($activeCoin['average_sentiment_change'])){
                            $Message .= 'Social sentiment change is: ' . formatNumber($activeCoin['average_sentiment_change']) ;
                            $notify = true;
                            $notifySentiment = true;
                        }
                       

                    }
    
                }else{
                    $notifySentiment = true;
                }

            }
            if ($notifySentiment && $notifyPrice && $notifyVolume && $notifyROI && $notifyMCap && $notifyUnlock && $notifySentiment) {
                $arrayData[] = array(
                'id' => $value['id'],
                'note' => $Message,
            );
            }
            
        } else {
            if (isset($value['data']['type']) && isset($value['data']['next_unlock_date'])) {
                 $today =date('Y-m-d h:i:s') ;
                $today_timeSTR = strtotime($today);

                $expire_time = strtotime($value['data']['next_unlock_date']);
                switch ($value['data']['type']) {
                    case '1-month-before':
                        $before_time = date('Y-m-d H:i:s', (strtotime('-30 day', strtotime($value['data']['next_unlock_date']))));
                        $before_timeSTR = strtotime($before_time);
                        if ($before_timeSTR <= $today_timeSTR) {
                            $arrayData[] = array(
                                'id' => $value['id'],
                                'note' => $value['data']['name'] . ' will be unlocked next month',
                            );
                        }

                        break;
                         case '2-weeks-before':
                        $before_time = date('Y-m-d H:i:s', (strtotime('-14 day', strtotime($value['data']['next_unlock_date']))));
                        $before_timeSTR = strtotime($before_time);
                      
                        if ($before_timeSTR <= $today_timeSTR) {
                            $arrayData[] = array(
                                'id' => $value['id'],
                                'note' => $value['data']['name'] . ' will be unlocked after 2 weeks',
                            );
                        }

                        break;
                        case '1-week-before':
                            $before_time = date('Y-m-d H:i:s', (strtotime('-7 day', strtotime($value['data']['next_unlock_date']))));
                            $before_timeSTR = strtotime($before_time);
                           
                            if ($before_timeSTR <= $today_timeSTR) {
                                $arrayData[] = array(
                                    'id' => $value['id'],
                                    'note' => $value['data']['name'] . ' will be unlocked after 1 week',
                                );
                            }
    
                            break;
                    case '2-days-before':
                        $future_date =$value['data']['next_unlock_date'];
                        $future_timestamp = strtotime($future_date);
                        $current_timestamp = time();
                        $time_difference = $future_timestamp - $current_timestamp;
                        $time_difference_in_hours = $time_difference / 3600;
                        if ($time_difference_in_hours <= 48) {
                            $arrayData[] = array(
                                            'id' => $value['id'],
                                            'note' => $value['data']['name'] . '  will be unlocked after 2 days',
                                        );
                            } else {
                            
                            }
                       
                        break;
                    case '12-hours-before':
                      
                        $future_date =$value['data']['next_unlock_date'];
                        $future_timestamp = strtotime($future_date);
                        $current_timestamp = time();
                        $time_difference = $future_timestamp - $current_timestamp;
                        $time_difference_in_hours = $time_difference / 3600;
                        if ($time_difference_in_hours <= 12) {
                            $arrayData[] = array(
                                            'id' => $value['id'],
                                            'note' => $value['data']['name'] . ' will be unlocked after 12 hours',
                                        );
                            } else {
                            
                            }

                        break;
                    case '10-min-before':
                        $future_date =$value['data']['next_unlock_date'];
                        $future_timestamp = strtotime($future_date);
                        $current_timestamp = time();
                        $time_difference = $future_timestamp - $current_timestamp;
                         $time_difference_in_hours = $time_difference / 60;
                        if ($time_difference_in_hours <= 10) {
                            $arrayData[] = array(
                                            'id' => $value['id'],
                                            'note' => $value['data']['name'] . ' will be unlocked after 10 minutes',
                                        );
                            } else {
                            
                            }
                       
                        break;
                    case 'on-time':
                        $future_date =$value['data']['next_unlock_date'];
                        $future_timestamp = strtotime($future_date);
                        $current_timestamp = time();
                        $time_difference = $future_timestamp - $current_timestamp;
                         $time_difference_in_hours = $time_difference / 60;
                        if ($time_difference_in_hours <= 0) {
                            $arrayData[] = array(
                                            'id' => $value['id'],
                                            'note' => $value['data']['name'] . ' is now unlocked.',
                                        );
                            } else {
                            
                            }
                       
                        break;
                   
                }
                // echo $value['data']['type'];
            }
        }
    }
        
        // echo '<pre>';
// die();
    if (isset($arrayData) && count($arrayData) > 0) {
        $url = $baseURL . "/api/trigger-notification";

        // Create a new cURL resource
        $curl = curl_init($url);

        // Set the cURL options
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arrayData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Make the API call
        $response = curl_exec($curl);
        // Check for errors
        if (curl_errno($curl)) {
            echo "Error: " . curl_error($curl);
        }
        // Close the cURL resource
        curl_close($curl);
        // Process the response data
    
        echo 'alerts added successfully';
    } else {
        // echo "no data available";
    }

    // Close the connection
}
function formatNumber($value) {
    $formatted_number = number_format($value, 2);
    return $formatted_number; // Output: 10.26
}

// Print the results as a JSON object
