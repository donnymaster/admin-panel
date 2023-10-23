<?php

namespace App\Models\AdminPanel;

use App\Models\User;
use App\Traits\Model\DateFormatTimeZoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataExchange extends Model
{
    use HasFactory, DateFormatTimeZoneTrait;

    protected $table = 'information_data_exchange';

    protected $fillable = [
        'version_schema_import_file',
        'version_schema_offers_file',
        'data_formations_import_file',
        'data_formations_offers_file',
        'status',
        'uniique_id',
        'user_id',
        'date_end',
        'error_message',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
