<?php

namespace App\Validation;

class CustomRules
{
	public function less_than_today(string $str, string &$error = null): bool
	{
		if (date('Y-m-d', strtotime($str)) <= date('Y-m-d')) {
			return true;
		}

		$error = lang('Validation.less_than_today');

		return false;
	}

	public function greater_than_now(string $str, string &$error = null): bool
	{
		if (date('Y-m-d H:i:s', strtotime($str)) > date('Y-m-d H:i:s')) {
			return true;
		}

		$error = lang('Validation.greater_than_now');

		return false;
	}
}
