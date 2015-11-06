<?php

/**
 * Created by PhpStorm
 * Project: eleganterrors
 * User: gman
 * Date: 11/1/15
 * Time: 12:38 PM
 */
class ElegantTools extends ElegantErrors {

	private $yaml_ext = false;

	private $config_file;

	function __construct(
//		ElegantErrors $elegantErrors
	) {}

	/**
	 * Loads Config File using YAML extension
	 */
	public function loadConfig() {
		// Check if yaml.so is present and use it if possible...
		if ( extension_loaded ( 'yaml' )) {
			$this->yaml_ext = true;
			$this->config_file = _LIB."config.yaml";
			$yaml = file_get_contents( $this->config_file );
			$data = yaml_parse( $yaml, 0 );
			// Load the config.xml file since yaml.so is not available...
		} else {
			$this->yaml_ext = false;
			$this->config_file = _LIB."config.json";
			$contents = file_get_contents( $this->config_file );
			$data = self::jsonToArray($contents);
		}
		// Convert the $data array to a $config object...
		$config = self::arrayToObject($data);
		$this->setConfig($config);
		// Update and save the config.xml with latest config.yaml settings from development...
		if ($config->global->saveJSON === 1) {
			self::arrayToJSON($data, _LIB.'config.json');
		}
	}

	/**
	 * Recursive Array to Object converter to make arrays OOPS friendly
	 * @param $array
	 *
	 * @return stdClass
	 */
	public function arrayToObject($array) {
		$obj = new stdClass;
		foreach($array as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
					$obj->{$k} = self::arrayToObject($v); //RECURSION
				} else {
					$obj->{$k} = $v;
				}
			}
		}
		return $obj;
	}

	public function arrayToXML($data = null, $newfile = '', $root = 'root') {
		if (empty($data)) {
			return false;
		}
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?>'."<{$root}/>");
		array_walk_recursive($data , array ($xml, 'addChild'));
		$string = dom_import_simplexml($xml);
		$domxml = new DOMDocument('1.0');
		$domxml->preserveWhiteSpace = true;
		$domxml->formatOutput = true;
		$string = $domxml->importNode($string, true);
		$string = $domxml->appendChild($string);
		return $domxml->save($newfile);
//		return $xml->saveXML($newfile);
	}


	public function arrayToJSON ($data = null, $newfile = null) {
		if (empty($data)) return false;
		$json = json_encode($data);
		if (!empty($newfile)) {
			file_put_contents($newfile, $json);
		}
		return $json;
	}

	public function jsonToArray ($contents) {
		return json_decode($contents);
	}

	public function redCarpet($contents,$action) {
		switch ($action) {
			case 'decode':
				$data = unserialize(base64_decode($contents));
				break;
			case 'encode':
				$data = base64_encode(serialize($contents));
				break;
			default:
				$data = false;
		}
		return $data;
	}

	public function objectToArray($data = null) {

		if (is_array($data) || is_object($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = self::objectToArray($value);
			}
			return $result;
		}
		return $data;
	}

	public function xmlToArray ( $xmlObject, $out = array () ) {
		foreach ( (array) $xmlObject as $index => $node )
			$out[$index] = ( is_object ( $node ) ) ? self::xmlToArray( $node ) : $node;

		return $out;
	}

}