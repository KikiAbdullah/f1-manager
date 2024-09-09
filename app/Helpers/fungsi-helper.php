<?php

use App\Models\master\Gudang;
use App\Models\trans\InventoriSum;
use App\Models\trans\Mutasi;
use App\Models\trans\MutasiLine;
use App\Models\trans\PemuatanBarang;
use App\Models\trans\TransIn;
use App\Models\trans\TransOut;
use App\Models\trans\TransOutLine;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

function st_aktif($var)
{
    if (empty($var)) {
        return "<center><span class=\"badge bg-primary\">Enabled</span></center>";
    } else {
        return "<center><span class=\"badge bg-light text-body\">Disabled</span></center>";
    }
}

function is_closed($var)
{
    if ($var == 1) {
        return "<center><span class=\"badge bg-light text-body\">Closed</span></center>";
    } else {
        return "<center><span class=\"badge bg-primary\">Enable</span></center>";
    }
}


function cleanNumber($val)
{
    return  str_replace('.00', '', number_format($val, 2, '.', ','));
}

if (!function_exists('responseSuccess')) {

    function responseSuccess($data = [], $message = 'Data saved.')
    {
        return [
            'status'            => true,
            'msg'               => $message,
            'data'              => $data,
        ];
    }
}

if (!function_exists('responseFailed')) {

    function responseFailed($message = 'Gagal')
    {
        return [
            'status'            => false,
            'msg'               => $message,
            'data'              => [],
        ];
    }
}

if (!function_exists('formatDate')) {

    function formatDate($from, $to, $date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat($from, $date)->format($to);
        }
    }
}

if (!function_exists('roleName')) {

    function roleName()
    {
        return auth()->user()->roles->first()->name ?? null;
    }
}
