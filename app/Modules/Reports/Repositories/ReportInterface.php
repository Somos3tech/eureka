<?php

namespace App\Modules\Reports\Repositories;

interface ReportInterface
{
    public function preafiliation($request);

    public function sales($request);

    public function businesssale($request);

    public function customer($request);

    public function terminal($request);

    public function simcard($request);

    public function office($request);

    public function programmer($request);

    public function currencyvalue($request);

    public function operation($request);

    public function atc($request);
}
