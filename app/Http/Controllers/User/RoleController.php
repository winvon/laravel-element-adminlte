<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class RoleController extends Controller
{

    public function getModel()
    {
        return new Role();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getModel()->with([])->paginate($request->input('page_size'));
        }
        return view('user.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', Rule::unique('roles')],
            'guard_name' => ['required'],
            'permissions' => ['nullable', 'array']
        ]);
        $role = Role::create($data);

        $this->syncPermissions($role, $data['permissions']);


        return $role;
    }

    /**
     * @param $role
     * @param $permissions
     */
    public function syncPermissions(Role $role, $permissions)
    {
        if (empty($permissions)) {
            return;
        }
        if (!is_array($permissions)) {
            return;
        }
        $permissions = Menu::query()->whereIn('id', $permissions)->get()
            ->map(function ($menu) {
                return Permission::updateOrCreate(['menu_id' => data_get($menu, 'id')],
                    [
                        'name' => data_get($menu, 'id'),
                        'guard_name' => data_get($menu, 'guard_name'),
                        'desc' => data_get($menu, 'name'),
                    ]
                );
            });

        $role->syncPermissions($permissions);
        return $role;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\View\View|null
     */
    public function show( Request $request,$id)
    {
        if ($request->ajax()){
            return $this->getModel()->with(['permissions'])->findOrFail($id);
        }
        return view('user.role.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => ['required', Rule::unique('roles')->ignore($id)],
            'guard_name' => ['required'],
            'permissions' => ['nullable', 'array']
        ]);
        $role =$this->getModel()->query()->findOrFail($id);
        $role->update($data);
        $this->syncPermissions($role, $data['permissions']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model= $this->getModel()->query()->findOrFail($id);
        $model->permissions()->detach();
        $model->delete();
        return $id;
    }
}
