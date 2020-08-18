<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Menus;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function getModel()
    {
        return new Menu();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $rows=  $this->getModel()->with([])
              ->where('guard_name', 'user')
              ->get();
          return $rows;
        }

        return view("user.menu.index");
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
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,
            [
                'uri' => ['nullable', 'string'],
                'name' => ['nullable', 'string'],
                'pid' => ['required', 'int'],
                'icon' => ['max:200'],
                'is_ajax' => ['nullable', 'boolean']
            ]);
        $data['guard_name'] = 'user';
        $data['status'] = 1;
        $model = (new Menu())->addMenu(array_filter($data));
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
