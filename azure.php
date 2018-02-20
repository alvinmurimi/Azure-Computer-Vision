<?php
class Computer_Vision{
	/**
	 * Azure image recognition URL
	 * @var string $azure_imageRecognition
	 */
	private $azure_imageRecognition;
	/**
	 * Azure celebrity image recognition URL
	 * @var string $azure_celebRecognition
	 */
	private $azure_celebRecognition;
	/**
	 * Azure landmarks image recognition URL
	 * @var string $azure_landmarks
	 */
	private $azure_landmarks;
	/**
	 * Azure optical character recognition URL
	 * @var string $azure_ocr
	 */
	private $azure_ocr;
	/**
	 * Azure API key
	 * @var string $subscription_key
	 */
	private $subscription_key;

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

	/*
	*This method is used to recognize images from specific URLs
	*/
	public function image($image_url){

        $data = array("url" => $image_url);
        $azure_url=$this->azure_imageRecognition;
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
    $json_object = json_decode($response, true);
    $description=$json_object['description']['captions'][0]['text'];
    $confidence=$json_object['description']['captions'][0]['confidence'];
    $confidence=$confidence*100;
    $confidence=round($confidence,1);
    $resp="The image is ".$description." . Confidence: ".$confidence."%";
    }
    curl_close($curl);
    	return $resp;
	}
	/*
	*This method is used to recognize images of celebrities
	*/
	public function celeb($imageurl){

        $data = array("url" => $imageurl);
        $key=$this->subscription_key;
        $azure_url=$this->azure_celebRecognition;
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
    $json_object = json_decode($response,true);
    $name=$json_object['result']['celebrities'][0]['name'];
    $confidence=$json_object['result']['celebrities'][0]['confidence'];
    $confidence=$confidence*100;
    $confidence=round($confidence,1);
    $resp="".$name." Confidence: ".$confidence."%";
    }
    curl_close($curl);
        return $resp;
    }

    public function ocr($imageurl){
    	$data = array("url" => $imageurl);
    	$azure_url=$this->azure_ocr;
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
    $data = json_decode($response);
    $sentence = "";
    foreach($data->regions as $region){
       foreach ($region->lines as $line){
          foreach($line->words as $word){
          $sentence = $sentence.' '.$word->text;
      }
  }
}}
    curl_close($curl);
return $sentence;
    }
	/*
	*This method is used to recognize landmarks from images
	*/
    public function landmarks($image_url){
    	$key=$this->subscription_key;
    	$azure_url=$this->azure_landmarks;
    	$data = array("url" => $image_url);
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
   $json_object = json_decode($response);
    $name=$json_object['result']['landmarks'][0]['name'];
    $confidence=$json_object['result']['landmarks'][0]['confidence'];
    $confidence=$confidence*100;
    $confidence=round($confidence,1);
    $resp="Place: ".$name." Confidence: ".$confidence;
    }
    curl_close($curl);
    return $resp;
    }
}
?>