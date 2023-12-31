<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index(Request $request)
    {
        $plans = Plan::excludeArchive()->search('"'.$request->input('search').'"')->paginate(10);
        $count = $plans->total();

        return view('plans.index', compact('plans', 'count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $plan = Plan::findOrFail($id);

        return view('plans.show', compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * 
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     */
    public function store(Request $request)
    {
        //Model Validation
        $this->validate($request, ['plan_code' => 'unique:plans,plan_code',
                                   'plan_name' => 'unique:plans,plan_name', ]);

        $plan = new Plan($request->all());

        $plan->createdBy()->associate(Auth::user());
        $plan->updatedBy()->associate(Auth::user());

        $plan->save();

        flash()->success('Plan fue creado exitosamente');

        return redirect('plans');
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);

        return view('plans.edit', compact('plan'));
    }

    public function update($id, Request $request)
    {
        $plan = Plan::findOrFail($id);

        $plan->update($request->all());
        $plan->updatedBy()->associate(Auth::user());
        $plan->save();
        flash()->success('Detalles del plan fueron actualizados exitosamente');

        return redirect('plans/all');
    }

    public function archive($id)
    {
        Plan::destroy($id);

        return redirect('plans/all');
    }
}