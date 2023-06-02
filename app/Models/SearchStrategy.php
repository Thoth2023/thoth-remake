<?php
/**
 * File: SearchStrategy.php
 * Author: Auri Gabriel
 *
 * Description: This is the model class for the project search strategy
 *
 * Date: 2023-06-02
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Project;

class SearchStrategy extends Model
{
    protected $table = 'search_strategy';
    // we have to set the primary key because we're dealing with a legacy
    // databasee with a defined key, in the future we could adapt the to be the
    // laravel way
    // TODO change the primary key to follow the best practices
    protected $primaryKey = 'id_search_strategy';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = ['description'];

    /**
     * This is the function that defines the relation of
     * the SearchStrategy with the project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Returns the relationship between SearchStrategy and Project.
     * @see Project
     * @example
     * ```
     * // Example usage
     * $searchStrategy->project();
     * ```
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
