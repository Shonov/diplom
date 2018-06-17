<?php

namespace  ProfPlatforma\Users\Models;

use App\Category;
use App\Module;
use Illuminate\Support\Facades\Storage;
use ProfPlatforma\Orders\Models\Order;
use ProfPlatforma\Orders\Models\OrderRequest;
use ProfPlatforma\Roles\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'login',
        'phone',
        'email',
        'first_name',
        'last_name',
        'middle_name',
        'password',
        'gender',
        'city',
        'birthday',
        'photo',
        'description',
        'confirmed',
        'public_offer',
//        'identity_confirmation',
//        'experience',
//        'car_availability',
//        'guarantee',
//        'works_under_contract',
//        'work',
//        'min_order_amount',
//        'criminal_record',
//        'tarif',
//        'rating',
    ];

    protected $hidden = [
        'roles', 'password',
    ];

    public function getModulesAttribute()
    {
        $modules = \DB::select("select * ,
            (select title from modules where id = module_id) as module_titles,
            (select title from rights where id = right_id) as right_titles
            from (
                select distinct module_id, right_id from role_rights where role_id 
                in(select role_id from user_roles as ur where ur.user_id = '$this->id' )
            ) as modules");
        $results = [];
        foreach ($modules as $module) {
            $results[$module->module_id]['id'] = $module->module_id;
            $results[$module->module_id]['title'] = $module->module_titles;
            $results[$module->module_id]['rights'][$module->right_id]['id'] = $module->right_id;
            $results[$module->module_id]['rights'][$module->right_id]['title'] = $module->right_titles;
        }
        return $results;
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles','user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id')->with('budget');
    }

    public function requests()
    {
        return $this->hasMany(OrderRequest::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'users_work_categories','user_id');
    }

    public function createCategories($list) {
        $categories = [];
        foreach ($list as $category) {
            $categories[] = Category::find(intval($category['id']));

        }
        $this->categories()->saveMany($categories);
    }

    public function  getPhotoAttribute($photo)
    {
        if (!$photo) return; else {
            return 'http://127.0.0.1:8000' . Storage::url($photo);
        }
    }
}