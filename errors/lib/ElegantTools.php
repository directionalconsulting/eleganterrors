<?php
/**
 * @package ElegantErrors
 * @subpackage ElegantTools
 * @description  HTTP Status Codes & ErrorDocument directives with customizable templates and built in contact form
 * @author Gordon Hackett
 * @created 2015-10-02 15:03:17
 * @version 0.5.1
 * @updated 2015-11-08 13:37:39
 * @timestamp 1447018665898
 * @copyright 2015 Gordon Hackett :: Directional-Consulting.com
 *
 * This file is part of ElegantErrors.
 *
 * ElegantErrors is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ElegantErrors is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ElegantErrors.  If not, see <http://www.gnu.org/licenses/>.
 *
 **/
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