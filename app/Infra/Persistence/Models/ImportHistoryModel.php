<?php

namespace App\Infra\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class ImportHistoryModel extends Model
{
    protected $table = 'import_histories';

    protected $fillable = [
        'filename',
        'total_imported',
        'started_at',
        'finished_at',
        'status',
        'error_message'
    ];
}
