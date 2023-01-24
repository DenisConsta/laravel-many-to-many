<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['name', 'slug', 'client_name', 'summary', 'cover_image', 'type_id', 'technology_id', 'user_id'];

    public $sortable = ['id', 'name', 'client_name'];
    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function technologies(){
        return $this->belongsToMany(Technology::class);
    }

    public function user(){
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
    }


}
