<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Permission;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\View;

class PermissionsController extends Controller
{
    /**
     * @param Request $request
     * 
     * @return View
     */
    public function index(): View
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    /**
     * @param StorePermissionRequest $request
     * 
     * @return RedirectResponse
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $permission = Permission::create($request->all());

        return redirect()->route('admin.permissions.index');
    }

    /**
     * @param Permission $permission
     * 
     * @return View
     */
    public function edit(Permission $permission): View
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * @param UpdatePermissionRequest $request
     * @param Permission $permission
     * 
     * @return RedirectResponse
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index');
    }

    /**
     * @param sion $permission
     * 
     * @return View
     */
    public function show(Permission $permission): View
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * @param Permission $permission
     * 
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back();
    }

    /**
     * @param MassDestroyPermissionRequest $request
     * 
     * @return RedirectResponse
     */
    public function massDestroy(MassDestroyPermissionRequest $request): RedirectResponse
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
