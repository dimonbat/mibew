<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Import namespaces and classes of the core
use Mibew\Settings;

// Initialize libraries
require_once(MIBEW_FS_ROOT.'/libs/common/locale.php');

/* ajax server actions use utf-8 */
function getrawparam($name)
{
	if (isset($_POST[$name])) {
		$value = myiconv("utf-8", MIBEW_ENCODING, $_POST[$name]);
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		return $value;
	}
	die("no " . $name . " parameter");
}

/* form processors use current Output encoding */
function getparam($name)
{
	if (isset($_POST[$name])) {
		$value = myiconv(getoutputenc(), MIBEW_ENCODING, $_POST[$name]);
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		return $value;
	}
	die("no " . $name . " parameter");
}

function getgetparam($name, $default = '')
{
	if (!isset($_GET[$name]) || !$_GET[$name]) {
		return $default;
	}
	$value = myiconv("utf-8", MIBEW_ENCODING, unicode_urldecode($_GET[$name]));
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	return $value;
}

function get_app_location($showhost, $issecure)
{
	if ($showhost) {
		return ($issecure ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . MIBEW_WEB_ROOT;
	} else {
		return MIBEW_WEB_ROOT;
	}
}

function is_secure_request()
{
	return
			isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443'
			|| isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on"
			|| isset($_SERVER["HTTP_HTTPS"]) && $_SERVER["HTTP_HTTPS"] == "on";
}

/**
 * Returns name of the current operator pages style
 *
 * @return string
 */
function get_page_style() {
	return Settings::get('page_style');
}

?>