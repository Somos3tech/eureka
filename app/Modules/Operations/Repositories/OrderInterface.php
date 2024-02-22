<?php

namespace App\Modules\Operations\Repositories;

interface OrderInterface extends RepositoryInterface
{
    public function findContract($data);

    public function findCustomer($data);

    public function datatableUser($id);

    public function dataStatus($request);

    public function reportProgrammer();

    public function reportAdminProgrammer($request);

    public function reportCredicard();

    public function reportPlatco();

    public function selectOrderTransfer();

    public function totalStatus();

    public function getSales($customer_id);

    public function datatable($request);

    public function notificationSMS($mobile, $contract_id);

    public function pdf($id);

    public function reportOffice($request);
}
