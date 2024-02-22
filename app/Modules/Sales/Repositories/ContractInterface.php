<?php

namespace App\Modules\Sales\Repositories;

interface ContractInterface extends RepositoryInterface
{
    /*Datatable de Consulta Contrat*/
    public function datatable();

    public function datatableUser($id);

    public function select($request);

    public function validRif($rif);

    public function documentContract($id);

    public function reportInvoice($request, $type);

    public function restoreManagement($request, $id);

    public function findTerminal($terminal_id);

    public function findChange($id);

    public function contractSupport($id, $status);

    public function getContractActive($request);

    public function findContract($request);

    public function totalContract();

    public function getAffiliateActive($request);

    public function getAffiliatePending($request);
}
