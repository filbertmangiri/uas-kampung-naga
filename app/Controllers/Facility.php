<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FacilityModel;

class Facility extends BaseController
{
    protected $facilityModel;

    public function __construct()
    {
        $this->facilityModel = new FacilityModel();
    }
}
