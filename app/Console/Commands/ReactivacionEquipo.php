<?php

namespace App\Console\Commands;

use App\Modules\Sales\Models\Operterminal;
use App\Modules\Sales\Repositories\ContractRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReactivacionEquipo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactivar:equipo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reactivar equipos que están suspendidos temporalmente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Operterminal $operterminal, ContractRepository $contract)
    {
        $this->operterminal = $operterminal;
        $this->contract = $contract;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoy = date('Y-m-d');
        $data = [];

        $operterminal = $this->operterminal->select('operterminals.*')
            ->where('operterminals.type_service', 'temporal')->whereBetween('operterminals.date_reactive', [\DB::raw("('select date_reactive from operterminals
            where date_reactive is not null order by date_reactive asc limit 1')"), $hoy])->where('operterminals.status', 'Pendiente');

        $data = array_merge($data, $operterminal->get()->toArray());
        foreach ($data as $row) {
            Log::info($row);
            $contract = $this->contract->model->select('contracts.*', 't.serial', 'terms.abrev as term_name')
                ->leftjoin('terminals as t', 't.id', '=', 'contracts.terminal_id')
                ->leftjoin('terms', 'terms.id', '=', 'contracts.term_id')
                ->where('contracts.id', $row['contract_id'])->first();

            if (isset($contract)) {
                $status = 'Finalizado';
                $contract->status = 'Activo';

                $contract->user_updated_id = $row['user_created_id'];
                $result = $contract->update();

                if ($result) {
                    $registro = $this->operterminal->create([
                        'contract_id' => $row['contract_id'],
                        'fechpro' => date('y-m-d'),
                        'type_operation' => 'activacion',
                        'type_service' => null,
                        'term_id' => null,
                        'date_inactive' => null,
                        'date_reactive' => null,
                        'term_name' => $row['term_name'],
                        'serial_terminal' => $row['serial_terminal'],
                        'observations' => 'Equipo reactivado por el sistema. Servicio:'.$row['type_service'].' Fecha Reactivación: '.$row['date_reactive'],
                        'status' => 'Finalizado',
                        'user_created_id' => $row['user_created_id'],
                    ]);
                    Log::info($registro);
                    $result = $this->operterminal->select('operterminals.*')
                        ->where('operterminals.id', $row['id'])->first();
                    $result->status = $status;
                    $result->user_updated_id = $row['user_created_id'];
                    $result->update();
                }
            }
        }
        Log::info('Equipos reactivados');

        return Command::SUCCESS;
    }
}
