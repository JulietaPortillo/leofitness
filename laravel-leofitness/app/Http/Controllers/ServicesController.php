<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $services = Service::with('plans')->search('"'.$request->input('search').'"')->paginate(10);

        \Log::info(\DB::getQueryLog());
        $count = $services->count();

        //dd($services);
        return view('services.index', compact('services', 'count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     */
    public function store(Request $request)
    {
        //Model Validation
        $this->validate($request, ['name' => 'unique:services,name']);

        $service = new Service($request->all());

        $service->createdBy()->associate(Auth::user());
        $service->updatedBy()->associate(Auth::user());

        $service->save();

        flash()->success('Service was successfully created');

        return redirect(route('services.all'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('services.edit', compact('service'));
    }

    public function update($id, Request $request)
    {
        $service = Service::findOrFail($id);

        $service->update($request->all());
        $service->updatedBy()->associate(Auth::user());
        $service->save();
        flash()->success('Service details were successfully updated');

        return redirect('plans/services/all');
    }

    public function delete($id)
    {
        Service::destroy($id);

        return redirect('plans/services/all');
    }
}