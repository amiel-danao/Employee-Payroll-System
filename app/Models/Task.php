<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use LogsActivity;
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => match ($value) {
                0 => 'Available',
                1 => 'Ongoing',
                2 => 'Done',
                3 => 'Approved',
                4 => 'Rejected',
            },
        );
    }
}
