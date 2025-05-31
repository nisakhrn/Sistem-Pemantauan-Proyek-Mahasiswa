<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Scope a query to only include projects with the given status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOverdue($query)
    {
        return $query->where('end_date', '<', now())
                    ->where('status', '!=', 'selesai');
    }


    /**
     * Get valid statuses for the project.
     *
     * @return array
     */
    public static function getValidStatuses()
    {
        return [
            'progress' => 'Progress',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai'
        ];
    }

    /**
     * Get formatted start date.
     *
     * @return string
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? Carbon::parse($this->start_date)->format('d/m/Y') : '-';
    }

    /**
     * Get formatted end date.
     *
     * @return string
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? Carbon::parse($this->end_date)->format('d/m/Y') : '-';
    }

    /**
     * Get status badge class.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'progress':
                return 'bg-warning';
            case 'aktif':
                return 'bg-success';
            case 'selesai':
                return 'bg-primary';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Get status label.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $statuses = self::getValidStatuses();
        return $statuses[$this->status] ?? ucfirst($this->status);
    }
}
