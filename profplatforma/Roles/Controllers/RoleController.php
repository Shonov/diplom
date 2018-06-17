<?php

namespace ProfPlatforma\Roles\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Module;
use ProfPlatforma\Roles\Models\Right;
use ProfPlatforma\Roles\Models\Role;
use ProfPlatforma\Roles\Models\RoleRight;

/**
 * @resource Роли (roles)
 */
class RoleController extends Controller
{
    /**
     * Получить все роли (Get all roles)
     */
    public function index()
    {
        return [
            'roles' => Role::all(),
            'modules' => Module::all(),
            'rights' => Right::all(),
        ];
    }

    /**
     * Создать роль (Create role)
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $values = $request->all();
        $values['title'] = json_encode($values['title']);
        $role = new Role($request->all());
        $role->save();
        $role->createRights($request->get('modules', []));

        return [
            'role' => $role,
        ];
    }

    /**
     * Обновить роль (Update role)
     * @param Request $request
     * @param Role $role
     * @return
     */
    public function update(Request $request, Role $role)
    {
        RoleRight::where('role_id', $role->id)->delete();

        $role->update($request->all());

        $role->createRights($request->get('modules', []));

        return Role::find($role->id);
    }

    /**
     * Удалить роль (Delete role)
     * @param Role $role
     * @return array
     */
    public function delete(Role $role)
    {
        $role->rights()->delete();
        $role->users()->detach($role->users()->allRelatedIds());

        return [
            'status' => $role->delete(),
        ];
    }
}
