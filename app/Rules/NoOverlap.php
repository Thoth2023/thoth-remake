<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NoOverlap implements Rule
{
    protected $table;
    protected $columnStart;
    protected $columnEnd;
    protected $whereColumn;
    protected $whereValue;

    public function __construct(string $table, string $columnStart, string $columnEnd, string $whereColumn = null, $whereValue = null)
    {
        $this->table = $table;
        $this->columnStart = $columnStart;
        $this->columnEnd = $columnEnd;
        $this->whereColumn = $whereColumn;
        $this->whereValue = $whereValue;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where(function ($query) use ($value) {
                $query->whereBetween($this->columnStart, [$value['start'], $value['end']])
                    ->orWhereBetween($this->columnEnd, [$value['start'], $value['end']])
                    ->orWhere(function ($query) use ($value) {
                        $query->where($this->columnStart, '>=', $value['start'])
                            ->where($this->columnEnd, '<=', $value['end']);
                    });
            });

        if ($this->whereColumn && $this->whereValue !== null) {
            $query->where($this->whereColumn, '!=', $this->whereValue);
        }

        // If updating a record, exclude the current record from the check
        if (isset($value['id'])) {
            $query->where('id', '!=', $value['id']);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'The score range overlaps with an existing record.';
    }
}
