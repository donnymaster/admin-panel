<?php

namespace App\Models\AdminPanel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataExchange extends Model
{
    use HasFactory;

    protected $table = 'information_data_exchange';

    protected $fillable = [
        'version_schema_import_file',
        'version_schema_offers_file',
        'data_formations_import_file',
        'data_formations_offers_file',
        'status',
        'uniique_id',
    ];
}
