<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyClientRequest;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClientsController extends Controller
{
    /**
     * @param Request $request
     * 
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->ajax()) {
            $query = Client::query()->select(sprintf('%s.*', (new Client)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.clients.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        abort_if(Gate::denies('client_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.create');
    }

    /**
     * @param StoreClientRequest $request
     * 
     * @return RedirectResponse
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        $client = Client::create($request->all());

        return redirect()->route('admin.clients.index');
    }

    /**
     * @param Client $client
     * 
     * @return View
     */
    public function edit(Client $client): View
    {
        abort_if(Gate::denies('client_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.edit', compact('client'));
    }

    /**
     * @param UpdateClientRequest $request
     * @param Client $client
     * 
     * @return RedirectResponse
     */
    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->all());

        return redirect()->route('admin.clients.index');
    }

    /**
     * @param Client $client
     * 
     * @return View
     */    
    public function show(Client $client): View
    {
        abort_if(Gate::denies('client_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.clients.show', compact('client'));
    }

    /**
     * @param Client $client
     * 
     * @return RedirectResponse
     */
    public function destroy(Client $client): RedirectResponse
    {
        abort_if(Gate::denies('client_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $client->delete();

        return back();
    }

    /**
     * @param MassDestroyClientRequest $request
     * 
     * @return RedirectResponse
     */
    public function massDestroy(MassDestroyClientRequest $request): RedirectResponse
    {
        Client::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
