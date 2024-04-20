<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeesController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * 
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->ajax()) {
            $query = Employee::with(['services'])->select(sprintf('%s.*', (new Employee)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->rawColumns(['actions', 'placeholder', 'photo', 'services']);

            return $table->make(true);
        }

        return view('admin.employees.index');
    }

    /**
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::all()->pluck('name', 'id');

        return view('admin.employees.create', compact('services'));
    }

    /**
     * @param StoreEmployeeRequest $request
     * 
     * @return RedirectResponse
     */
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $employee = Employee::create($request->all());
        $employee->services()->sync($request->input('services', []));

        if ($request->input('photo', false)) {
            $employee->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return redirect()->route('admin.employees.index');
    }

    /**
     * @param Employee $employee
     * 
     * @return View
     */
    public function edit(Employee $employee): View
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::all()->pluck('name', 'id');

        $employee->load('services');

        return view('admin.employees.edit', compact('services', 'employee'));
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param Employee $employee
     * 
     * @return RedirectResponse
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->all());
        $employee->services()->sync($request->input('services', []));

        if ($request->input('photo', false)) {
            if (!$employee->photo || $request->input('photo') !== $employee->photo->file_name) {
                $employee->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($employee->photo) {
            $employee->photo->delete();
        }

        return redirect()->route('admin.employees.index');
    }

    /**
     * @param Employee $employee
     * 
     * @return View
     */
    public function show(Employee $employee): View
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('services');

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * @param Employee $employee
     * 
     * @return RedirectResponse
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    /**
     * @param MassDestroyEmployeeRequest $request
     * 
     * @return RedirectResponse
     */
    public function massDestroy(MassDestroyEmployeeRequest $request): RedirectResponse
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
