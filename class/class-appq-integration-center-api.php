<?php

class IntegrationCenterRestApi
{

	protected $cp_id;
	protected $configuration;
	protected $content_type;


	public function __construct($cp_id,$slug,$name)
	{
		$this->cp_id = $cp_id;
		$this->integration = array(
			'slug' => $slug,
			'name' =>  $name,
		);

		$this->configuration = $this->get_configuration($this->cp_id);
		$this->custom_fields = AppQ_Integration_Center_Admin::get_custom_fields($this->cp_id);
		$this->basic_configuration = array();
		$this->content_type = 'html';
		
		$this->mappings = array(
			'{Bug.message}' => array(
				'prop' => 'message',
				'description' => 'Titolo del bug',
				'default' => '[Phase/Section] - Brief Issue description'
			),
			'{Bug.steps}' => array(
				'prop' => 'description',
				'description' => 'Step by step description del bug',
				'default' => '{Description}'
			),
			'{Bug.expected}' => array(
				'prop' => 'expected_result',
				'description' => 'Expected result del bug',
				'default' => '{Expected Result}'
			),
			'{Bug.actual}' => array(
				'prop' => 'current_result',
				'description' => 'Actual result del bug',
				'default' => '{Actual Result}'
			),
			'{Bug.note}' => array(
				'prop' => 'note',
				'description' => 'Note del bug',
				'default' => '{Note}'
			),
			'{Bug.id}' => array(
				'prop' => 'id',
				'description' => 'ID del bug',
				'default' => '0'
			),
			'{Bug.internal_id}' => array(
				'prop' => 'internal_id',
				'description' => 'Internal id del bug',
				'default' => 'AQ0'
			),
			'{Bug.application_section_id}' => array(
				'prop' => 'application_section_id',
				'description' => 'Usecase / step id del bug',
				'default' => '0'
			),
			'{Bug.status_id}' => array(
				'prop' => 'status_id',
				'description' => 'Status id del bug',
				'default' => '1'
			),
			'{Bug.status}' => array(
				'prop' => 'status',
				'description' => 'Status name del bug',
				'default' => 'Refused'
			),
			'{Bug.severity_id}' => array(
				'prop' => 'severity_id',
				'description' => 'Severity id del bug',
				'default' => '1'
			),
			'{Bug.severity}' => array(
				'prop' => 'severity',
				'description' => 'Severity name del bug',
				'default' => 'LOW'
			),
			'{Bug.replicability_id}' => array(
				'prop' => 'bug_replicability_id',
				'description' => 'Replicability id del bug',
				'default' => '1'
			),
			'{Bug.replicability}' => array(
				'prop' => 'replicability',
				'description' => 'Replicability name del bug',
				'default' => 'Always'
			),
			'{Bug.type_id}' => array(
				'prop' => 'bug_type_id',
				'description' => 'Bug Type id id del bug',
				'default' => '1'
			),
			'{Bug.type}' => array(
				'prop' => 'type',
				'description' => 'Bug Type name id del bug',
				'default' => 'Crash'
			),
			'{Bug.manufacturer}' => array(
				'prop' => 'manufacturer',
				'description' => 'Manufacturer del device del bug',
				'default' => '{Device Manufacturer}'
			),
			'{Bug.model}' => array(
				'prop' => 'model',
				'description' => 'Modello del device del bug',
				'default' => '{Device Model}'
			),
			'{Bug.os}' => array(
				'prop' => 'os',
				'description' => 'OS del device del bug',
				'default' => '{Device OS}'
			),
			'{Bug.os_version}' => array(
				'prop' => 'os_version',
				'description' => 'OS version del device del bug',
				'default' => '{Device OS version}'
			),
			'{Bug.tags}' => array(
				'prop' => 'tags',
				'complex' => true,
				'description' => 'Tags del bug, verranno mostrati separati da punto e virgola (e.g. "tag1 ; tag2")',
				'default' => 'tag1 ; tag2'
			),
			'{Bug.tags_list}' => array(
				'prop' => 'tags_list',
				'complex' => true,
				'description' => 'Tags del bug, verranno mostrati come un array json (e.g. "["tag1" , "tag2"]")',
				'default' => '["tag1" , "tag2"]'
			),
			'{Bug.media}' => array(
				'prop' => 'media',
				'complex' => true,
				'description' => 'Media del bug, le immagini verranno mostrate nel contenuto',
				'default' => ['https://placehold.it/200','https://placehold.it/200']
			),
			'{Bug.media_links}' => array(
				'prop' => 'media_links',
				'complex' => true,
				'description' => 'Link ai media del bug'
			)
		);
		
		$additional_fields = appq_get_campaign_additional_fields($cp_id);
		
		foreach ($additional_fields as $field) {
			$this->mappings['{Bug.field.'.$field->slug.'}'] = array(
				'prop' => $field->slug,
				'complex' => true,
				'type' => 'additional',
				'description' => 'Additional field ' .$field->title
			);
		}
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
	 * Send put request
	 * @method http_put
	 * @date             2020-11-25T10:53:50+010
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to POST. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @param  mixed                  $data  The data to post    
	 * @return Requests_Response                           https://developer.wordpress.org/reference/classes/requests_response/
	 */
	public function http_put($url, $headers, $data)
	{
		return Requests::put($url, $headers, $data);
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
	 * Send delete request
	 * @method http_delete
	 * @date    2020-05-28T12:22:22+020
	 * @author: Davide Bizzi <clochard>
	 * @param  string                  $url     The url to GET. If you need basic authentication (with USER and PASS) use http(s)?://{USER}:{PASS}@{HOST}/{PATH}
	 * @param  array                  $headers An associative array with the headers. E.g. array('Content-type' => 'application/json')
	 * @return Requests_Response                           https://developer.wordpress.org/reference/classes/requests_response/
	 */
	public function http_delete($url, $headers)
	{
		return Requests::delete($url, $headers);
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


	public function apply_appq_data_manipulation_map($value,$args) {
		$map = json_decode($args,true);
		
		foreach($map as $k => $v) {
			$value = str_replace($k,$v,$value);
		}
		
		return $value;
	}


	public function apply_appq_data_manipulation($value,$mappings,$function,$args) {
		foreach($mappings as $key => $item) {
			if ($function == 'map') {
				$item = $this->apply_appq_data_manipulation_map($item,$args);
			}
			$value = str_replace($key,$item,$value);
		}
		
		return $value;
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
		$value_function = false;
		$value_function_args = false;
		if (strpos($value, '::appq::') !== false) {
			preg_match('/{Bug.\S+::appq::([\S ]+)}/', $value, $matches);
			if (sizeof($matches) > 1) {
				$value_data = $matches[1];
				$value_function = $value_data;
				if (strpos($value, '|||') !== false) {
					preg_match('/(\S+)\|\|\|([\S ]+)/', $value_data, $matches);
					if (sizeof($matches) > 2) {
						$value_function = $matches[1];
						$value_function_args = $matches[2];
					}
				}
			}
			$value = str_replace('::appq::' . $value_data,'',$value);
		}
		
		if (!property_exists($bug,'type'))
			$bug->type = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_type WHERE id = %d', $bug->bug_type_id));
		if (!property_exists($bug,'severity'))
			$bug->severity = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_severity WHERE id = %d', $bug->severity_id));
		if (!property_exists($bug,'status'))
			$bug->status = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_status WHERE id = %d', $bug->status_id));
		if (!property_exists($bug,'replicability'))
			$bug->replicability = $wpdb->get_var($wpdb->prepare('SELECT name FROM ' . $wpdb->prefix . 'appq_evd_bug_replicability WHERE id = %d', $bug->bug_replicability_id));

		$mappings = [];
		foreach ($this->mappings as $map_name => $map_data) {
			$prop = $map_data['prop'];
			if ($prop && (!array_key_exists('complex',$map_data) || !$map_data['complex'])) {
				$mappings[$map_name] = $bug->$prop;
			}
		}
		
		// Only if {Bug.tags} or {Bug.tags_list} exists
		if (strpos($value,'{Bug.tags}') !== false || strpos($value,'{Bug.tags_list}') !== false )
		{
			if (!property_exists($bug,'tags') || !property_exists($bug,'tags_list')) {
				$tags =  $wpdb->get_col($wpdb->prepare('SELECT display_name FROM wp_appq_bug_taxonomy WHERE bug_id = %d', $bug->id));
				$mappings['{Bug.tags}'] = implode(' ; ',$tags);
				$tags_list = '["' . implode('","',$tags) . '"]';
				$mappings['{Bug.tags_list}'] = $tags_list;
			}
			
			if (property_exists($bug,'tags')) {
				$mappings['{Bug.tags}'] = $bug->tags;
			}
			if (property_exists($bug,'tags_list')) {
				$mappings['{Bug.tags_list}'] = $bug->tags_list;
			}
		}
		// Only if {Bug.media} exists
		if (strpos($value,'{Bug.media}') !== false || strpos($value,'{Bug.media_links}') !== false )
		{
			if (!property_exists($bug,'media')) {
				$media =  $wpdb->get_col($wpdb->prepare('SELECT location FROM ' . $wpdb->prefix . 'appq_evd_bug_media WHERE bug_id = %d', $bug->id));
			} else {
				$media = $bug->media;
			}
			$mappings['{Bug.media}'] = implode(' , ',$media);
			if ($this->content_type == 'markdown') {
				$media = array_map(function($m){
					return '['.$m.']('.$m.')';
				},$media);
			} elseif ($this->content_type == 'html') {
				$media = array_map(function($m){
					return '<a href="'.$m.'">'.$m.'</a>';
				},$media);
			}
			$mappings['{Bug.media_links}'] = implode(' , ',$media);
		}
		
		if (property_exists($bug, 'fields') && sizeof($bug->fields) > 0)
		{
			foreach ($bug->fields as $slug => $field_value) {
				$mappings['{Bug.field.'.$slug.'}'] = $field_value;
			}
		}
		
		
		$value = $this->apply_appq_data_manipulation($value,$mappings,$value_function,$value_function_args);
		
		
		$value = $this->apply_appq_custom_mappings($bug,$value);
		
		
		$value = nl2br($value);

		return $value;
	}
	
	private function apply_appq_custom_mappings($bug,$value) {
		foreach($this->custom_fields as $custom_field) {
			if (strpos($value,$custom_field->name) !== false) {
				$source_value = $this->bug_data_replace($bug,$custom_field->source);
				$map = json_decode($custom_field->map,true);
				foreach ($map as $search => $replace) {
					$source_value = str_replace($search,$replace,$source_value);
				}
				$value = str_replace($custom_field->name,$source_value,$value);
			}
		}
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
		$field_mapping = property_exists($this->configuration, 'field_mapping') && !empty($this->configuration->field_mapping)? json_decode($this->configuration->field_mapping, true) : array();
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
		$field_mapping = $this->get_field_mapping();

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
		if ($bug_id == 'default') {
			return $this->get_default_bug();
		}
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
	
	
	public function get_default_bug() {
		
		$bug = new stdClass();
		$bug->id = - $this->cp_id;
		foreach ($this->mappings as $map => $data) {
			if ($data['prop'] && $data['default']) {
				$prop = $data['prop'];
				$bug->$prop = $data['default'];
			}
		}
		
		return $bug;
	}
}
