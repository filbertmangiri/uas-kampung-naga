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
}
