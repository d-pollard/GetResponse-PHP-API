<?php
	class GetResponse {

		private $url = 'https://api.getresponse.com/v3';
		
		private $auth;

		private $jsonDecode = false;

		function __construct($auth = false) {
			if($auth) {
				$this->auth = $auth;
			} else {
				throw new Exception('{ No auth key specified. Please provide an auth key. }');
			}
		}

		public function getCampaign($campaign = false) {
			if(!$campaign) {
				return $this->getResponse($this->url . '/campaigns', ['page' => 1, 'perPage' => 100]);
			} else {
				return $this->getResponse($this->url . '/campaigns/' . $campaign, []);
			}
		}

		public function createCampaign($name = false) {
			// Campaign name must be between 3-64 characters, only a-z (lower case), numbers and "_".
			$campaignDetails = [
				'name' => $name
			];

			if(!$name) {
				return false;
			} else {
				return $this->getResponse($this->url . '/campaigns', $campaignDetails, 'POST');
			}
		}

		public function getContacts($id = false, $email = false, $page = 1, $perPage = 30) {
			if($id) {
				$page = (!is_numeric($page)) ? 1 : $page;
				$perPage = (!is_numeric($page)) ? 30 : $perPage;
				if(!$email) {
					return $this->getResponse($this->url . '/campaigns/' . $id . '/contacts', ['page' => $page, 'perPage' => $perPage]);
				} else {
					return $this->getResponse($this->url . '/campaigns/' . $id . '/contacts', ['query' => ['email' => $email]]);
				}
			} else {
				return false;
			}
		}

		public function subscribe($list = false, $name = false, $email = false, $ip = false) {
			if($list && $name && $email && $ip) {
				$postData = [
					'name' => $name,
					'email' => $email,
					'campaign' => [
						'campaignId' => $list
					]
				];
				return $this->getResponse($this->url . '/contacts', $postData, 'POST');
			} else {
				return false;
			}
		}

		public function unsubscribe($list = false, $email = false) {
			if($email && $list) {
				$user = $this->getContacts($list, $email);
				$user = (is_object($user)) ? $user : json_decode($user);
				if(count($user) > 1) {
					return false;
				} else {
					$contactId = @$user[0]->contactId;
					$this->getResponse($this->url . '/contacts/' . $contactId, [], 'DELETE');
					return true;
				}
			} else {
				return false;
			}
		}

		public function getResponse($url, $data, $method = 'GET') {

			$apiKey = $this->auth;

			if($method === 'POST') {
				$sp = json_encode($data);
				$ux = $url;
			} elseif($method == 'GET') {
				$sp = http_build_query($data);
				$ux = $url . '?' . $sp;
			} else {
				$ux = $url;
			}
			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $ux);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				if($method === 'POST'){
				  curl_setopt($ch, CURLOPT_POST, count($data));
				  curl_setopt($ch, CURLOPT_POSTFIELDS, $sp);
				}
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				if($method == 'POST') {
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
						'X-Auth-Token: api-key ' . $apiKey,
						'Content-Type: application/json',
						'Content-Length: ' . strlen($sp)
					]);
				} else {
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
						'X-Auth-Token: api-key ' . $apiKey
					]);
				}

				if($method == 'DELETE') {
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				}
				

				  //debugging
				  curl_setopt($ch, CURLINFO_HEADER_OUT, FALSE);
				  curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
			$rt = curl_exec($ch);
				  curl_close($ch);
			return $rt;
		}
	}
?>