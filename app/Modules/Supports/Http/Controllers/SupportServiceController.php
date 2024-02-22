<?php

namespace App\Modules\Supports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Operations\Repositories\OrderInterface;
use App\Modules\Sales\Repositories\CollectionInterface;
use App\Modules\Sales\Repositories\ContractInterface;
use App\Modules\Sales\Repositories\InvoiceInterface;
use App\Modules\Sales\Repositories\InvoiceItemInterface;
use App\Modules\Warehouses\Repositories\Assignment\AssignmentInterface;
use App\Modules\Warehouses\Repositories\SimcardInterface;
use App\Modules\Warehouses\Repositories\TerminalInterface;
use Auth;
use Illuminate\Http\Request;

class SupportServiceController extends Controller
{
    private $terminal;

    private $simcard;

    private $assignment;

    private $order;

    private $contract;

    private $invoice;

    private $invoiceItem;

    private $collection;

    public function __construct(
        TerminalInterface $terminal,
        SimcardInterface $simcard,
        AssignmentInterface $assignment,
        OrderInterface $order,
        ContractInterface $contract,
        InvoiceInterface $invoice,
        InvoiceItemInterface $invoiceItem,
        CollectionInterface $collection
    ) {
        $this->terminal = $terminal;
        $this->simcard = $simcard;
        $this->assignment = $assignment;
        $this->order = $order;
        $this->contract = $contract;
        $this->invoice = $invoice;
        $this->invoiceItem = $invoiceItem;
        $this->collection = $collection;
    }

    /************************************************************************/
    public function contract()
    {
        return view('supports::supports.contract', ['identity' => 'Soporte Venta (Contrato)']);
    }

    /************************************************************************/
    public function invoice()
    {
        return view('supports::supports.invoice', ['identity' => 'Soporte Cobro (Conciliación)']);
    }

    /************************************************************************/
    public function store(Request $request)
    {
        if ($contract = $this->contract->find((int) $request->id)) {
            if ($this->contract->update($request, (int) $request->id)) {
                if ($request->type_service == 'TerminalChange') {
                    $query = $this->terminal->model;

                    $terminal = $query->where('terminals.id', $request->terminal_id_support)->first();

                    if ($terminal) {
                        $status_old = $terminal->status;

                        $terminal->status = 'Disponible';
                        $terminal->user_updated_id = Auth::user()->id;
                        $terminal->user_assignated_id = null;
                        $terminal->assignated_at = null;
                        $terminal->user_posted_id = null;
                        $terminal->posted_at = null;

                        $result = $terminal->update();

                        if ($result) {
                            $query = $this->terminal->model;
                            $terminal_assign = $query->where('terminals.id', $request->terminal_change_id)->first();

                            if ($terminal_assign) {
                                $terminal_assign->status = $status_old;
                                $terminal_assign->user_updated_id = Auth::user()->id;
                                $terminal_assign->user_assignated_id = Auth::user()->id;
                                $terminal_assign->assignated_at = date('Y-m-d H:i:s');
                                $terminal_assign->user_posted_id = Auth::user()->id;
                                $terminal_assign->posted_at = date('Y-m-d H:i:s');

                                $result = $terminal_assign->save();

                                if ($result) {
                                    $query = $this->assignment->model;
                                    $assign_delete = $query->where('assignments.terminal_id', $request->terminal_id_support)->first();

                                    if ($assign_delete) {
                                        $status_assign_old = $assign_delete->status;
                                        $result = $assign_delete->delete();
                                    }

                                    $query = $this->assignment->model;
                                    $assign_new = $query->where('assignments.terminal_id', $request->terminal_change_id)->first();

                                    if ($assign_new) {
                                        $assign_new->status = $status_assign_old;
                                        $assign_new->user_updated_id = Auth::user()->id;
                                        $assign_new->save();
                                    } else {
                                        $data = [
                                            'terminal_id' => $request->terminal_change_id,
                                            'user_assign_id' => Auth::user()->id,
                                            'observations' => 'Cambio Solicitado',
                                            'status' => $status_assign_old,
                                            'user_created_id' => Auth::user()->id,
                                            'created_at' => date('Y-m-d H:i:s'),
                                        ];
                                        $result = $this->assignment->createId($data);
                                    }
                                }
                            }
                        }
                    }
                }
                if ($request->type_service == 'SimcardChange') {
                    $query = $this->simcard->model;
                    $simcard = $query->where('simcards.id', $request->simcard_id_support)->first();
                    if ($simcard) {
                        $status_old = $simcard->status;

                        $simcard->status = 'Disponible';
                        $simcard->user_updated_id = Auth::user()->id;
                        $simcard->user_assignated_id = null;
                        $simcard->assignated_at = null;
                        $simcard->user_posted_id = null;
                        $simcard->posted_at = null;

                        $result = $simcard->update();

                        if ($result) {
                            $query = $this->simcard->model;
                            $simcard_assign = $query->where('simcards.id', $request->simcard_change_id)->first();

                            if ($simcard_assign) {
                                $simcard_assign->status = $status_old;
                                $simcard_assign->user_updated_id = Auth::user()->id;
                                $simcard_assign->user_assignated_id = Auth::user()->id;
                                $simcard_assign->assignated_at = date('Y-m-d H:i:s');
                                $simcard_assign->user_posted_id = Auth::user()->id;
                                $simcard_assign->posted_at = date('Y-m-d H:i:s');

                                $result = $simcard_assign->save();

                                if ($result) {
                                    $query = $this->assignment->model;
                                    $assign_delete = $query->where('assignments.simcard_id', $request->simcard_id_support)->first();

                                    if ($assign_delete) {
                                        $status_assign_old = $assign_delete->status;
                                        $result = $assign_delete->delete();
                                    }

                                    $query = $this->assignment->model;
                                    $assign_new = $query->where('assignments.simcard_id', $request->simcard_change_id)->first();

                                    if ($assign_new) {
                                        $assign_new->status = $status_assign_old;
                                        $assign_new->user_updated_id = Auth::user()->id;
                                        $assign_new->save();
                                    } else {
                                        $data = [
                                            'simcard_id' => $request->simcard_change_id,
                                            'user_assign_id' => Auth::user()->id,
                                            'observations' => 'Cambio Solicitado',
                                            'status' => $status_assign_old,
                                            'user_created_id' => Auth::user()->id,
                                            'created_at' => date('Y-m-d H:i:s'),
                                        ];
                                        $result = $this->assignment->createId($data);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if ($request->type_service == 'PostedTwo') {
                $query = $this->order->model;
                $order = $query->where('orders.contract_id', (int) $request->id)->first();

                if ($order) {
                    $order->posted_at = $request->posted_at;
                    $order->posted_user_id = Auth::user()->id;
                    $order->save();
                }
            }

            if (($request->type_service == 'Destroy') || ($request->type_service == 'Restore') || $request->type_service == 'Delete') {

                if ($contract->simcard_id != null) {
                    $this->simcard->restoreContract($contract->simcard_id);
                    $this->assignment->deleteAssignment('simcard_id', $contract->simcard_id);
                }

                if ($contract->terminal_id != null) {
                    $this->terminal->restoreContract($contract->terminal_id);
                    $this->assignment->deleteAssignment('terminal_id', $contract->terminal_id);
                }
            }

            if ($request->type_service == 'Destroy' || $request->type_service == 'Delete') {
                if ($order = $this->order->findContract((int) $request->id)) {
                    $this->order->delete($order->id);
                }

                if ($request->type_service == 'Delete') {
                    $invoices = $this->invoice->findContract((int) $request->id);
                    foreach ($invoices as $invoice) {
                        if ($invoice) {
                            $this->invoice->delete((int) $invoice->id);
                        }
                    }
                }
            }

            if ($request->type_service == 'Delete') {
                $this->contract->delete((int) $request->id);
            }

            toastr()->info('Soporte Procesado Correctamente');

            return redirect()->back();
        }
        toastr()->error('Error al procesar Soporte');

        return redirect()->back();
    }

    /****************************************************************************/
    public function invoiceStore(Request $request)
    {
        if ($result = $this->invoice->updateSupport($request, (int) $request->id)) {
            toastr()->info('Soporte Procesado Correctamente');

            return redirect()->back();
        }

        toastr()->error('Error al procesar Soporte');

        return redirect()->back();
    }
}
