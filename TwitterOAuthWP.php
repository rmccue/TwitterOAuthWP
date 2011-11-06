<?php

class TwitterOAuthWP extends TwitterOAuth {
	function http($url, $method, $postfields = NULL) {
		$this->http_info = null; // this is never used
		$options = array(
			'method' => $method,
			'timeout' => $this->timeout,
			'user-agent' => $this->useragent,
			'sslverify' => $this->ssl_verifypeer
		);

		switch ($method) {
			case 'POST':
				if (!empty($postfields)) {
					$options['body'] = $postfields;
				}
				break;
			case 'DELETE':
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}

		$response = wp_remote_request($url, $options);

		if (is_wp_error($response)) {
			$this->http_code = null;
			$this->http_header = array();
			return false;
		}

		$this->http_code = $response['response']['code'];
		$this->http_header = $response['headers'];

		return $response['body'];
	}
}