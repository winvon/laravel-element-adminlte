<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getModel()
    {
        return new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getModel()
                ->with(['roles'])
                ->paginate($request->input('page_size'));
        }
        return view('user.user.index');
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
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required', Rule::unique('users'), 'max:200'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['nullable', 'min:6', 'max:20'],
            'roles'=>['nullable','array']
        ]);
        if (data_get($data, 'password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $model = User::create($data);

        $roles=(new Role())->query()->whereIn('id',data_get($data,'roles',[]))->get();
        $model->syncRoles($roles);

        return $model;
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\View\View|null
     */
    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            return $this->getModel()->with([])->findOrFail($id);
        }
        return view('user.user.index');
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
            'name' => ['required', Rule::unique('users')->ignore($id), 'max:200'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => ['nullable', 'min:6', 'max:20'],
            'roles'=>['nullable','array']
        ]);
        $model = $this->getModel()->with([])->findOrFail($id);
        if (data_get($data, 'password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $model->update($data);

        $roles=(new Role())->query()->whereIn('id',data_get($data,'roles',[]))->get();
        $model->syncRoles($roles);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
