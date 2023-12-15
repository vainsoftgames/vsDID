<?php

	class vsDID {
		private $api_host = 'https://api.d-id.com/';
		public $timeout = 120;

		public function __construct(){
		}

		/*
			@para
				$request	STRING
				$payload	ARRAY
				$method		STRING	(GET / POST)
		
			@return
				$resonse	ARRAY | STRING
		*/
		private function callAPI($request, $payload=false, $method='POST'){
			$headers = [];
			if($payload && array_key_exists('file', $payload)) $headers[] = 'Content-Type: multipart/form-data';
            else $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Basic '. API_KEY;
		
			$ch = curl_init($this->api_host . $request);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

			if($payload){
				if(array_key_exists('file', $payload)) curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				else curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
			}
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			$response = curl_exec($ch);
			if(curl_errno($ch) == CURLE_OPERATION_TIMEDOUT) {
				$response = json_encode(['status'=>'error', 'msg'=>'timeout', 'full_msg'=>curl_error($ch)]);
			}
			curl_close($ch);

			return json_decode($response, true);
		}
		
		public function createProvider($type='', $voice_id='', $voice_config=false){
			$para = [];
			$para['type'] = $type;
			$para['voice_id'] = $voice_id;
			if($voice_config) $para['voice_config'] = $voice_config;
			
			return $para;
		}
		public function createTalk($srcIMG, $script, $config, $user_data, $name=false, $webhook=false, $result_url=false, $face=false, $persist=false){
			$para = [];
			$para['source_url'] = $srcIMG;
			$para['script'] = $script;
			if($config) $para['config'] = $config;
			if($user_data) $para['user_data'] = $user_data;
			if($name) $para['name'] = $name;
			if($webhook) $para['webhook'] = $webhook;
			if($result_url) $para['result_url'] = $result_url;
			if($face) $para['face'] = $face;
			if($persist) $para['presist'] = $persist;
			
			return $this->callAPI('talks', $para);
		}
		private function createScript($input, $subTitles=false, $ssml=false, $reduce_noice=false, $provider=false){
			$script = [];
			$script['subtitles'] = $subTitles;
			if(filter_var($input, FILTER_VALIDATE_URL)) {
				$script['type'] = 'audio';
				$script['audio_url'] = $input;
				$script['reduce_noise'] = $reduce_noice;
			}
			else {
				$script['type'] = 'text';
				$script['input'] = $input;
				$script['ssml'] = $ssml;
				if($provider){
					$script['provider'] = $provider;
				}
			}
			
			return $script;
		}
		public function createScriptAud($srcIMG, $audURL, $subTitles=false, $reduce_noise=false){
			$script = $this->createScript($audURL, $subTitles, $ssml, false, $reduce_noise);
			return $this->createTalk($srcIMG, $audURL, $subTitles, false, $reduce_noise);
		}
		public function createScriptText($srcIMG, $prompt, $subTitles=false, $ssml=false, $provider=false){
			$script = $this->createScript($prompt, $subTitles, $ssml, $provider);
			return $this->createTalk($srcIMG, $script);
		}
		public function getTalk($id=null){
			return $this->callAPI('talks/'. $id, NULL, 'GET');
		}
	}
?>
