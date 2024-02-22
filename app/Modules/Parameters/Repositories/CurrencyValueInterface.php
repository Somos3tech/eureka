<?php

namespace App\Modules\Parameters\Repositories;

interface CurrencyValueInterface extends RepositoryInterface
{
    public function valueDycon($request);

    public function last();

    public function getLast();

    public function getCurrencyValue();

    public function select();
}
