<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\View\View;

class ServicesController extends Controller
{
    /**
     * @param Request $request
     * 
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->ajax()) {
            $query = Service::query()->select(sprintf('%s.*', (new Service)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.services.index');
    }

    /**
     * @return View
     */
    public function create():View
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.services.create');
    }

    /**
     * @param StoreServiceRequest $request
     * 
     * @return RedirectResponse
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = Service::create($request->all());

        return redirect()->route('admin.services.index');
    }

    /**
     * @param Service $service
     * 
     * @return View
     */
    public function edit(Service $service): View
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.services.edit', compact('service'));
    }

    /**
     * @param UpdateServiceRequest $request
     * @param Service $service
     * 
     * @return RedirectResponse
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->all());

        return redirect()->route('admin.services.index');
    }

    /**
     * @param Service $service
     * 
     * @return View
     */
    public function show(Service $service): View
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.services.show', compact('service'));
    }

    /**
     * @param Service $service
     * 
     * @return RedirectResponse
     */
    public function destroy(Service $service): RedirectResponse
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->delete();

        return back();
    }

    /**
     * @param MassDestroyPermissionRequest $request
     * 
     * @return RedirectResponse
     */
    public function massDestroy(MassDestroyServiceRequest $request): RedirectResponse
    {
        Service::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
