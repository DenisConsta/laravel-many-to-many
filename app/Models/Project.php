<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['name', 'slug', 'client_name', 'summary', 'cover_image', 'type_id', 'technology_id', 'user_id'];

    public $sortable = ['id', 'name', 'client_name'];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateSlug($string)
    {
        $slug = Str::slug($string, '-');
        $original_slug = $slug;
        $c = 1;
        $exist = Project::where('slug', $slug)->first();
        while ($exist) {
            $slug = $original_slug . '-' . $c;
            $exist = Project::where('slug', $slug)->first();
            $c++;
        }
        return $slug;
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        if ($filters['search'] ?? false) {
            return $query->where('name', 'like', '%' . request('search') . '%')->orWhere('summary', 'like', '%' . request('search') . '%')->orWhere('client_name', 'like', '%' . request('search') . '%');
        }

        if ($filters['type'] ?? false) {
            return $query->where('type_id', request('type'));
        }

        if ($filters['technology'] ?? false) {
            /*
            SELECT *
            FROM `projects`
            LEFT JOIN `project_technology`
            ON `projects`.`id` = `project_technology`.`project_id`
            WHERE `project_technology`.`technology_id` = x;
            */

            return $query->where("project_technology.technology_id", "=", request('technology'))
                ->leftJoin("project_technology", function ($join) {
                    $join->on("projects.id", "=", "project_technology.project_id");
                });
        }
    }


}
