<?php
class Computer_Vision{

    public function __construct(){
  /**
   * Replace the addresses with the one given to you after signing up.
   * Replace the subscription_key with your API key
   */
    $this->azure_celebRecognition="https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/models/celebrities/analyze";
    $this->azure_imageRecognition="https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/describe";
    $this->azure_landmarks="https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/models/landmarks/analyze";
    $this->azure_ocr="https://westcentralus.api.cognitive.microsoft.com/vision/v1.0/ocr";
    $this->subscription_key="";

  }
    public function recognize($image_url,$recognition_type){

        $data = array("url" => $image_url);
        if($recognition_type == "image"){
            $azure_url = $this->azure_imageRecognition;
        }elseif($recognition_type == "landmark"){
            $azure_url = $this->landmarks;
        }elseif($recognition_type == "celebrity"){
            $azure_url = $this->azure_celebRecognition;
        }elseif($recognition_type == "ocr"){
            $azure_url = $this->azure_url;
        }else{
            echo "invalid recognition type";
        }
        $key=$this->subscription_key;
        $data_string = json_encode($data);
        $curl = curl_init($azure_url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_POST,           1 );
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
      'Ocp-Apim-Subscription-Key:'.$key
        ));
        $response = curl_exec($curl);
        if(curl_error($curl)) {
        echo 'error:' . curl_error($curl);
    }
    else {
        if($recognition_type == "image"){
            $json_object = json_decode($response, true);
            $description=$json_object['description']['captions'][0]['text'];
            $confidence=$json_object['description']['captions'][0]['confidence'];
            $confidence=$confidence*100;
            $confidence=round($confidence,1);
          }
            $resp="The image is ".$description." . Confidence: ".$confidence."%";
            if($recognition_type == "landmark"){
                $json_object = json_decode($response);
                $name=$json_object['result']['landmarks'][0]['name'];
                $confidence=$json_object['result']['landmarks'][0]['confidence'];
                $confidence=$confidence*100;
                $confidence=round($confidence,1);
                $resp="Place: ".$name." Confidence: ".$confidence;
        }
        if($recognition_type == "celebrity"){
             $json_object = json_decode($response,true);
             $name=$json_object['result']['celebrities'][0]['name'];
             $confidence=$json_object['result']['celebrities'][0]['confidence'];
             $confidence=$confidence*100;
             $confidence=round($confidence,1);
             $resp="".$name." Confidence: ".$confidence."%"; 
        }
        if($recognition_type == "ocr"){
            $data = json_decode($response);
            $sentence = "";
            foreach($data->regions as $region){
               foreach ($region->lines as $line){
                    foreach($line->words as $word){
                 $resp = $sentence.' '.$word->text;
             }
         }
     }
 }
}
          curl_close($curl);
        return $resp; 
    }
}
?>