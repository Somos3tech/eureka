<?php

namespace App\Modules\Parameters\Repositories;

interface TerminalValueInterface extends RepositoryInterface
{
    public function getAmount($request);

    public function getLast();

    public function select();
}
