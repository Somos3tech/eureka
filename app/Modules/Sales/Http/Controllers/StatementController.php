<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Repositories\StatementInterface;
//Repository Sale dentro de Modulo
use Illuminate\Http\Request;

class StatementController extends Controller
{
    protected $statement;

    public function __construct(StatementInterface $statement)
    {
        $this->model = $statement;
    }

    /****************************************************************************/
    public function index()
    {
        return View('sales::statements.index')->with('identity', 'Dashboard Estado de Cuenta');
    }

    /****************************************************************************/
    public function getBankCustomer()
    {
        return View('sales::statements.bank_customer', ['identity' => 'Estado cuenta x Banco - Cliente Total']);
    }

    /****************************************************************************/
    public function detailCustomer(Request $request)
    {
        return View('sales::statements.detail')->with(['identity' => 'Información Estado de Cuenta Cliente', 'request' => $request->all()]);
    }

    /****************************************************************************/
    public function getBankContractCustomer()
    {
        return View('sales::statements.bank_contract', ['identity' => 'Estado cuenta x Banco - Contrato(Cliente) Detallado']);
    }

    /****************************************************************************/
    public function getCustomer(Request $request)
    {
        return $this->model->getCustomer($request);
    }

    /****************************************************************************/
    public function getInformationCustomer(Request $request)
    {
        return $this->model->getInformationCustomer($request);
    }

    /****************************************************************************/
    /****************************************************************************/
    public function getTotalServiceCustomer(Request $request)
    {
        return $this->model->getTotalServiceCustomer($request);
    }

    /****************************************************************************/
    public function getTotalServicePending()
    {
        return $this->model->getTotalServicePending();
    }

    /****************************************************************************/
    /****************************************************************************/
    public function datatableBankCustomer(Request $request)
    {
        return $this->model->datatableBankCustomer($request);
    }

    /****************************************************************************/
    public function datatableBankContractCustomer(Request $request)
    {
        return $this->model->datatableBankContractCustomer($request);
    }

    /****************************************************************************/
    /****************************************************************************/
    public function getHistorialManagement(Request $request)
    {
        return $this->model->getHistorialManagement($request);
    }

    /****************************************************************************/
    public function getHistorialManagementTest(Request $request)
    {
        return $this->model->getHistorialManagementTest($request);
    }

    /****************************************************************************/
    public function getHistorialDomiciliationOperation(Request $request)
    {
        return $this->model->getHistorialDomiciliationOperation($request);
    }

    /****************************************************************************/
    public function getHistorialDomiciliationBank(Request $request)
    {
        return $this->model->getHistorialDomiciliationBank($request);
    }

    /****************************************************************************/
    public function getHistorialOperterminal(Request $request)
    {
        return $this->model->getHistorialOperterminal($request);
    }

    /****************************************************************************/
    public function export(Request $request)
    {
        return $this->model->statementExportPDF($request);
    }

    /****************************************************************************/
    public function exportExcel(Request $request)
    {
        return $this->model->statementExportExcel($request);
    }
}
