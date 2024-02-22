<?php

namespace App\Modules\Customers\Repositories;

interface CustomerInterface extends RepositoryInterface
{
    //public function documentPdf($id);
    public function documentPdf($path_file);

    public function hasFileCustomer(array $array);

    public function totalCustomer();

    public function report($request);

    public function find($request);

    public function upload($request);

    public function checklist($request);

    public function datatableCheckList();

    public function datatableCheckContract();
}
