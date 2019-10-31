<?php

class IntegrationCenterRestApi
{

	protected $cp_id;
	protected $configuration;


	public function __construct($cp_id,$slug,$name)
	{
		$this->cp_id = $cp_id;
		$this->integration = array(
			'slug' => $slug,
			'name' =>  $name,
		);

		$this->configuration = $this->get_configuration($this->cp_id);
		$this->basic_configuration = array();
	}

	/**
	 * Send post request
	 * @method http_post
	 * @date   2019-10-30T14:43:49+010
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to POST. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @param  mixed                  $data  The data to post    
	 * @return Requests_Response                           https://developer.wordpress.org/reference/classes/requests_response/
	 */
	public function http_post($url, $headers, $data)
	{
		return Requests::post($url, $headers, $data);
	}

	/**
	 * Send patch request
	 * @method http_patch
	 * @date   2019-10-30T14:47:18+010
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to PATCH. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @param  mixed                  $data  The data to patch    
	 * @return Requests_Response                           https://developer.wordpress.org/reference/classes/requests_response/
	 */
	public function http_patch($url, $headers, $data)
	{
		return Requests::patch($url, $headers, $data);
	}

	/**
	 * Send get request
	 * @method http_get
	 * @date   2019-10-30T14:47:54+010
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to GET. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @return Requests_Response                           https://developer.wordpress.org/reference/classes/requests_response/
	 */
	public function http_get($url, $headers)
	{
		return Requests::get($url, $headers);
	}

	/**
	 * Send post request as sent from a form
	 * @method http_multipart_post
	 * @date   2019-10-30T14:48:17+010
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to POST. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @param  mixed                  $data  The data to post  
	 * @return object                           An object {status: bool, body: string, info: array, error: mixed}
	 * 												status - if the request was successfully completed 
	 * 												body - the body of the response 
	 * 												info - an array of data as returned from curl_getinfo 
	 * 												error - false if no error or the string describing the error 
	 */
	public function http_multipart_post($url, $headers, $data)
	{
		$url = parse_url($url);
		$user = $url['user'];
		$pass = $url['pass'];
		$url = $url['scheme'] . '://' . $url['host'] . $url['path'];
		
		$curl_headers = array();
		foreach ($headers as $key => $value) {
			$curl_headers[] = $key . ': '. $value;
		}
		
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_USERPWD => $user . ':' . $pass,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => $curl_headers,
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $options);
		$req = curl_exec($ch);
		
		$res = new stdClass();
		$res->status = !curl_errno($ch);
		$res->body = $req;
		$res->info = curl_getinfo($ch);
		$res->error = $res->status ? false : curl_error($ch);
		
		curl_close($ch);
		return $res;
	}

	/**
	 * Get the apiurl
	 * @method get_apiurl
	 * @date   2019-10-30T14:52:24+010
	 * @author: Davide Bizzi <clochard>
	 * @return string                  The api URL
	 */
	public function get_apiurl()
	{
		return $this->configuration->endpoint;
	}
	
	/**
	 * Get the token
	 * @method get_token
	 * @date   2019-10-30T14:53:08+010
	 * @author: Davide Bizzi <clochard>
	 * @return string                  The api token/key
	 */
	public function get_token()
	{
		return $this->configuration->apikey;
	}
	
	/**
	 * Get the data for authorization
	 * @method get_authorization
	 * @date   2019-10-30T14:53:28+010
	 * @author: Davide Bizzi <clochard>
	 * @return string	The data for the authorization. Overwrite in the subclass if you need manipulation of the token (base64 encoding,...)
	 */
	public function get_authorization()
	{
		return $this->get_token();
	}

	/**
	 * Get the configuration data for a campaign
	 * @method get_configuration
	 * @date   2019-10-30T15:00:15+010
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $cp_id The id of the campaign
	 * @return object                       {
	 * 											integration: string,   	The slug of the integration type
	 * 											endpoint: string,		The apiurl
	 * 											apikey: string,			The token/apikey
	 * 											field_mapping:string,	A json representing the field mapping
	 * 											is_active: bool,		true if is the current active integration for the cp 
	 * 											upload_media:bool		true if an issue should be sent with attachments
	 * 										}
	 */
	public function get_configuration($cp_id)
	{
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare('SELECT * FROM ' . $wpdb->prefix .'appq_integration_center_config WHERE campaign_id = %d AND integration = %s', $cp_id, $this->integration['slug'])
		);
	}

	/**
	 * Return the issue type
	 * @method get_issue_type
	 * @date   2019-10-30T15:05:06+010
	 * @author: Davide Bizzi <clochard>
	 * @return string			The issue type
	 */
	public function get_issue_type()
	{
		return 'Issue';
	}

	/**
	 * Replace {placeholders} in a field mapping value with data from a bug
	 * @method bug_data_replace
	 * @date   2019-10-30T15:06:02+010
	 * @author: Davide Bizzi <clochard>
	 * @param  MvcObject                  $bug   The bug (MvcObject with additional fields on field property)
	 * @param  string                  $value The string with {placeholders} to fill
	 * @return string                         
	 */
	public function bug_data_replace($bug, $value)
	{
		global $wpdb;
		$value = str_replace('{Bug.message}', $bug->message, $value);
		$value = str_replace('{Bug.steps}', $bug->description, $value);
		$value = str_replace('{Bug.expected}', $bug->expected_result, $value);
		$value = str_replace('{Bug.actual}', $bug->current_result, $value);
		$value = str_replace('{Bug.note}', $bug->note, $value);
		$value = str_replace('{Bug.id}', $bug->id, $value);
		$value = str_replace('{Bug.internal_id}', $bug->internal_id, $value);

		$value = str_replace('{Bug.status_id}', $bug->status_id, $value);
		$value = str_replace('{Bug.severity_id}', $bug->severity_id, $value);
		$value = str_replace('{Bug.replicability_id}', $bug->bug_replicability_id, $value);
		$value = str_replace('{Bug.type_id}', $bug->bug_type_id, $value);

		$type = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_type WHERE id = %d', $bug->bug_type_id));
		$severity = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_severity WHERE id = %d', $bug->severity_id));
		$status = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_status WHERE id = %d', $bug->status_id));
		$replicability = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_replicability WHERE id = %d', $bug->bug_replicability_id));

		$value = str_replace('{Bug.severity}', $severity, $value);
		$value = str_replace('{Bug.replicability}', $replicability, $value);
		$value = str_replace('{Bug.type}', $type, $value);
		$value = str_replace('{Bug.status}', $status, $value);

		$value = str_replace('{Bug.manufacturer}', $bug->manufacturer, $value);
		$value = str_replace('{Bug.model}', $bug->model, $value);
		$value = str_replace('{Bug.os}', $bug->os, $value);
		$value = str_replace('{Bug.os_version}', $bug->os_version, $value);
		
		// Only if {Bug.media} exists
		if (strpos($value,'{Bug.media}') !== false)
		{
			$media =  $wpdb->get_col($wpdb->prepare('SELECT location FROM ' . $wpdb->prefix . 'appq_evd_bug_media WHERE bug_id = %d', $bug->id)); 
			$value = str_replace('{Bug.media}', implode(', ',$media), $value);
		}
		
		if (property_exists($bug, 'fields') && sizeof($bug->fields) > 0)
		{
			foreach ($bug->fields as $slug => $field_value) {
				$value = str_replace('{Bug.field.'.$slug.'}', $field_value, $value);
			}
		}
		$value = nl2br($value);

		return $value;
	}

	/**
	 * Get the field mapping
	 * @method get_field_mapping
	 * @date   2019-10-30T15:18:22+010
	 * @author: Davide Bizzi <clochard>
	 * @return array                  An associative array with bugtracker field as key and a string with {placeholders} as value
	 */
	public function get_field_mapping()
	{
		$data = array();
		$field_mapping = property_exists($this->configuration, 'field_mapping') ? json_decode($this->configuration->field_mapping, true) : array();
		$field_mapping = array_merge($this->basic_configuration, $field_mapping);
		return $field_mapping;
	}

	/**
	 * Get mapped field data
	 * @method map_fields
	 * @date   2019-10-30T15:20:13+010
	 * @author: Davide Bizzi <clochard>
	 * @param  MvcObject                  $bug The bug to map (MvcObject with additional fields on field property)
	 * @return array                       An associative array with bugtracker field as key and the data to send as value
	 */
	public function map_fields($bug)
	{
		$data = array();
		$field_mapping = property_exists($this->configuration, 'field_mapping') ? json_decode($this->configuration->field_mapping, true) : array();
		$field_mapping = array_merge($this->basic_configuration, $field_mapping);

		foreach ($field_mapping as $key => $value) {
			$key = $this->bug_data_replace($bug, $key);
			$value = $this->bug_data_replace($bug, $value);
			$data[$key] = $value;
		}

		return $data;
	}

	/** 
	 * Send the issue
	 * @method send_issue
	 * @date   2019-10-30T15:21:44+010
	 * @author: Davide Bizzi <clochard>
	 * @param  MvcObject                  $bug The bug to upload (MvcObject with additional fields on field property)
	 * @return array 					An associative array {
	 * 										status: bool,		If uploaded successfully
	 * 										message: string		The response of the upload or an error message on error 
	 * 									}
	 */
	public function send_issue($bug)
	{
		return array(
			'status' => false,
			'message' => 'Not implemented yet'
		);
	}

	/**
	 * Get an issue associated with a bug
	 * @method get_issue_by_id
	 * @date   2019-10-30T15:24:54+010
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $id The bug id
	 * @return mixed                      false on error, an object on success
	 */
	public function get_issue_by_id($id)
	{
		return false;
	}



	/**
	 * Get a bug by id
	 * @method get_bug
	 * @date   2019-10-30T15:26:14+010
	 * @author: Davide Bizzi <clochard>
	 * @param  int                  $bug_id The bug id 
	 * @return MvcObject                           (MvcObject with additional fields on field property)
	 */
	public function get_bug($bug_id)
	{
		$bug_model = mvc_model('Bug');
		$bug = $bug_model->find_by_id($bug_id);
		$additional_fields = appq_get_campaign_additional_fields_data($bug_id);

		if (sizeof($additional_fields) > 0)
		{
			$bug->fields = array();
		}

		foreach ($additional_fields as $additional_field)
		{
			$bug->fields[$additional_field->slug] = $additional_field->value;
		}

		return $bug;
	}
}
