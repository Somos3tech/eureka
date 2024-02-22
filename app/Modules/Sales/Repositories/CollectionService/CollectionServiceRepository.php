<?php

namespace App\Modules\Sales\Repositories\CollectionService;

use App\Modules\Sales\Repositories\CollectionInterface;

class CollectionServiceRepository implements CollectionServiceInterface
{
    protected $collection;

    public function __construct(CollectionInterface $collection)
    {
        $this->model = $collection;
    }

    /************************Registrar Detalle Cobro*************************/
    public function create($request)
    {
        $result = $this->model->create($request);
        if ($result) {
            return true;
        }

        return false;
    }

    /************************************************************************/
    public function findId($request, $id)
    {
        return $this->model->findId($request, $id);
    }

    /************************Actualizar Detalle Cobro************************/
    public function update($request, $id)
    {
    }

    /************************Eliminar Detalle Cobro**************************/
    public function delete($request)
    {
        $sum = 0;
        for ($i = 0; $i < count($request['collection_id']); $i++) {
            if ($collection = $this->model->delete((int) $request['collection_id'][$i])) {
                $sum++;
            }
        }
        if ($sum > 0) {
            return $collection;
        }

        return false;
    }
}
