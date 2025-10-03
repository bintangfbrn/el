<?php

namespace App\Traits;

use App\Models\Pegawai;
use App\Models\Sppd;
use App\Models\Sppp;
use App\Models\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait GeneralFunction
{
    //
    public static function swal($icon, $title, $text)
    {
        Session::flash('swal', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
        ]);
    }

    public static function toastr($icon, $title, $text)
    {
        Session::flash('toastr', [
            'title' => $title,
            'text' => $text,
            'icon' => $icon,
        ]);
    }

    public static function generate_slug()
    {
        $uniq = self::generate_uniq(6);
        return strtoupper($uniq);
    }

    public static function generate_uniq($limit)
    {
        $uniq = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
        return $uniq;
    }

    public static function customId()
    {
        $uniq = now()->format('Ymd') . substr(crc32(uniqid(mt_rand(), true)), -5);

        return $uniq;
    }

    public static function handleRepeater(null|array $data): null|Collection
    {
        if (!$data) {
            return null;
        }

        $data = collect($data)->map(function ($item) {
            return (object) $item;
        });

        return $data;
    }

    public static function handleId($data): null|string
    {
        try {
            $decryptedId = decrypt($data->id);

            return $decryptedId;
        } catch (\Exception $e) {
            return null;
        }
    }
}
