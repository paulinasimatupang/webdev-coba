<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class DataCalonNasabah extends Model
{
    protected $connection = 'pgsql_billiton';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'no_identitas',
        'nama_lengkap',
        'nama_alias',
        'ibu_kandung',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'status_nikah',
        'alamat',
        'rt',
        'rw',
        'kecamatan',
        'kelurahan',
        'kab_kota',
        'provinsi',
        'kode_pos',
        'status_penduduk',
        'kewarganegaraan',
        'no_telp',
        'no_hp',
        'npwp',
        'jenis_identitas',
        'golongan_darah',
        'expired_identitas',
        'pendidikan_terakhir',
        'email',
        'no_registrasi',
        'branchid',
        'no_cif',
        'no_rekening',
        'status',
        'request_time',
        'reply_time'
    ];

    protected $table = 'public.data_calon_nasabah';
}
