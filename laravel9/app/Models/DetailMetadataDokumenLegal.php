<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailMetadataDokumenLegal extends Model
{
    protected $table = 'detail_metadata_dokumen_legal';

    protected $fillable = [
        'metadata_dokumen_legal_id',
        'file',
        'keterangan'
    ];

    public function metadata()
    {
        return $this->belongsTo(MetadataDokumenLegal::class);
    }
}
