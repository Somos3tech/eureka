<?php

namespace App\Traits;

use App\Modules\Cunpqr\Imports\FileImport;
use App\Modules\Parameters\Models\Payer;
use Illuminate\Http\Request;

trait TaskTrait
{
    /**
     * @param  Request  $request
     * @return $this|false|string
     */
    public function buttonActionS($edit, $destroy, $modal, $id)
    {
        if (auth()->user()->can($modal . '.edit', $modal . '.destroy')) {
            $data = '<center><button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
                   </button><div class="dropdown-menu" x-placement="bottom-start"></center';
        } else {
            $data = '<div><center>---</center>';
        }

        if ($edit) {
            if (auth()->user()->can($modal . '.edit')) {
                $data .= '<center><button class="dropdown-item" href="#" data-toggle="modal" value="' . $id . '"  OnClick="' . $modal . '(this);" data-target="#' . $modal . 'Update" title="Actualizar">Actualizar</button></center';
            }
        }

        if ($destroy) {
            if (auth()->user()->can($modal . '.destroy')) {
                $data .= '<center><button class="dropdown-item" href="#" data-toggle="modal" value="' . $id . '"  OnClick="' . $modal . 'Delete(this);" data-target="#' . $modal . 'Delete" title="Eliminar">Eliminar</button></center>';
            }
        }
        $data .= '</div>';

        return $data;
    }

    /**************************************************************************/
    public function buttonAction($edit, $destroy, $modal, $id)
    {
        if (auth()->user()->can($modal . '.edit', $modal . '.destroy')) {
            $data = '<button class="btn bg-transparent _r_btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span><span class="_dot _r_block-dot bg-dark"></span>
               </button><div class="dropdown-menu" x-placement="bottom-start">';
        } else {
            $data = '<div><center>---</center>';
        }

        if ($edit) {
            if (auth()->user()->can($modal . '.edit')) {
                $data .= '<a class="btn dropdown-item" href="' . $modal . '/' . $id . '/edit" title="Actualizar">Actualizar</a>';
            }
        }

        if ($destroy) {
            if (auth()->user()->can($modal . '.destroy')) {
                $data .= '<button class="dropdown-item" href="#" data-toggle="modal" value="' . $id . '"  OnClick="' . $modal . 'Delete(this);" data-target="#' . $modal . 'Delete" title="Eliminar">Eliminar</button>';
            }
        }
        $data .= '</div>';

        return $data;
    }

    /**************************************************************************/
    public function buttonBadge($status, $title)
    {
        if ($status == 1 || $status == 2) {
            $type = 'warning';
        } elseif ($status == 6 || $status == 7) {
            $type = 'primary';
        } elseif ($status == 4 || $status == 5 || $status == 8 || $status == 9) {
            $type = 'black';
        } elseif ($status == 3) {
            $type = 'success';
        } else {
            $type = 'black';
        }
        $data = '<span class="badge badge-pill badge-' . $type . '">' . $title . '</span>';

        return $data;
    }

    /**************************************************************************/
    public function buttonResponse($day_default, $days)
    {
        $day_range = intval(round($day_default / 3));
        if ($days > ($day_range * 2)) {
            return '<center><span class="badge  badge-round-success m-1">' . $days . '</span></center>';
        } elseif (($days > $day_range) && ($days <= ($day_range * 2))) {
            return '<center><span class="badge  badge-round-warning m-1">' . $days . '</span></center>';
        } elseif ($days > 0 && $days < $day_range) {
            return '<center><span class="badge  badge-round-danger m-1">' . $days . '</span></center>';
        } elseif ($days == 0) {
            return '<center><span class="badge  badge-round-dark m-1">U</span></center>';
        }

        return '<center><span class="badge  badge-round-dark m-1">V</span></center>';
    }

    /******************************Convertir en Array**************************/
    public function fileArray($request, $filename)
    {
        if (!is_object($request)) {
            return false;
        }
        if (!$request->hasFile('file')) {
            return false;
        }

        $arr = (new FileImport)->toArray(request()->file($filename));

        return reset($arr);
    }

    /**************************************************************************/
    public function contentTypes($ext)
    {
        if ($ext == 'pdf') {
            $content_types = 'application/pdf';
        } elseif ($ext == 'doc') {
            $content_types = 'application/msword';
        } elseif ($ext == 'docx') {
            $content_types = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        } elseif ($ext == 'xls') {
            $content_types = 'application/vnd.ms-excel';
        } elseif ($ext == 'xlsx') {
            $content_types = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } elseif ($ext == 'txt') {
            $content_types = 'application/octet-stream';
        }

        return $content_types;
    }

    /************Validar Archivo - Cargar en Customers en  storage*************/
    public function hasFileCustomer($request, $input, $storage, $data)
    {
        //verificamos arhivo si existe para cargarlo al sistema
        if ($request->hasFile($input)) {
            $file = $request->file($input);
            // generar un nombre con la extension
            $path = $data . '.' . $file->getClientOriginalExtension();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            if (file_exists(storage_path() . '/' . $storage . '/' . $path)) {
                $result = \Storage::disk($storage)->delete($path);
            }
            $result = \Storage::disk($storage)->put($path, \File::get($file));
        } else {
            $path = null;
        }

        return $path;
    }

    /******************************Get Input***********************************/
    public function getInput($request, $input)
    {
        if ($request->has($input)) {
            return $request[$input];
        }

        return null;
    }

    /******************************Send Mail***********************************/
    public function getInputBoolean($request, $input)
    {
        if ($request->has($input)) {
            return 1;
        }

        return 0;
    }

    /**************************************************************************/
    public function acconceptId($bank_id)
    {
        switch ($bank_id) {
            case 1:
                return 35;
                break;

            case 2:
                return 39;
                break;

            case 3:
                return 22;
                break;

            case 4:
                return 58;
                break;

            case 5:
                return 47;
                break;

            case 6:
                return 51;
                break;

            case 7:
                return 56;
                break;

            case 8:
                return 37;
                break;

            case 9:
                return 31;
                break;

            case 10:
                return 36;
                break;

            case 11:
                return 23;
                break;

            case 12:
                return 55;
                break;

            case 13:
                return 63;
                break;

            case 14:
                return 72;
                break;

            case 15:
                return 77;
                break;


            default:
                return false;
                break;
        }
    }

    /**************************************************************************/
    public function bankValidConsecutive($bank_id, $type_file)
    {
        $valid_bank = Payer::where('payers.bank_id', $bank_id)->where('payers.type_file', $type_file)->first();
        if (isset($valid_bank)) {
            return true;
        }

        return false;
    }

    /**************************************************************************/
    public function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT)
    {
        $str_len = mb_strlen($str);
        $pad_str_len = mb_strlen($pad_str);
        if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
            $str_len = 1; // @debug
        }
        if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
            return $str;
        }

        $result = null;
        $repeat = ceil($str_len - $pad_str_len + $pad_len);
        if ($dir == STR_PAD_RIGHT) {
            $result = $str . str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0, $pad_len);
        } elseif ($dir == STR_PAD_LEFT) {
            $result = str_repeat($pad_str, $repeat) . $str;
            $result = mb_substr($result, -$pad_len);
        } elseif ($dir == STR_PAD_BOTH) {
            $length = ($pad_len - $str_len) / 2;
            $repeat = ceil($length / $pad_str_len);
            $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
                . $str
                . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
        }

        return $result;
    }

    public function statusBadge($value)
    {
        $type = 'dark';
        $title = '';
        if ($value == 'Activo') {
            $title = 'Activo';
            $type = 'success';
        } elseif ($value == 'Pendiente') {
            $title = 'En Gestión';
            $type = 'warning';
        } elseif ($value == 'Cancelado') {
            $title = 'Cancelado';
            $type = 'dark';
        } elseif ($value == 'Anulado') {
            $title = 'Servicio Anulado';
            $type = 'dark';
        } elseif ($value == 'Suspendido') {
            $title = 'Suspendido';
            $type = 'dark';
        } else {
            $title = $value;
        }

        return '<span class="badge badge-pill badge-' . $type . ' p-2 m-1" title=' . $title . ' style="color:white;">' . $title . '</span>';
    }

    /****************************************************************************/
    public function cmp($a, $b)
    {
        return strcmp($a['contract_id'], $b['contract_id']);
    }
}
