<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Member;
use JavaScript;
//use App\Enquiry;
//use App\Invoice;
//use App\Service;
//use App\Setting;
use Carbon\Carbon;
//use App\SmsTrigger;
//use App\ChequeDetail;
//use App\Subscription;
//use App\InvoiceDetail;
//use App\PaymentDetail;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
{
    $members = Member::indexQuery($request->sort_field, $request->sort_direction, $request->drp_start, $request->drp_end)->search('"'.$request->input('search').'"')->paginate(10);
    $count = $members->total();

    $drp_placeholder = $this->drpPlaceholder($request);

    $request->flash();

    $old_sort = $request->sort_field;

    return view('members.index', compact('members', 'count', 'drp_placeholder', 'old_sort'));
}

public function active(Request $request)
{
    $members = Member::active($request->sort_field, $request->sort_direction, $request->drp_start, $request->drp_end)->search('"'.$request->input('search').'"')->paginate(10);
    $count = $members->total();

    $drp_placeholder = $this->drpPlaceholder($request);

    $request->flash();

    $old_sort = $request->sort_field;

    return view('members.active', compact('members', 'count', 'drp_placeholder', 'old_sort'));
}

public function inactive(Request $request)
{
    $members = Member::inactive($request->sort_field, $request->sort_direction, $request->drp_start, $request->drp_end)->search('"'.$request->input('search').'"')->paginate(10);
    $count = $members->total();

    $drp_placeholder = $this->drpPlaceholder($request);

    $request->flash();

    $old_sort = $request->sort_field;

    return view('members.inactive', compact('members', 'count', 'drp_placeholder', 'old_sort'));
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);

        return view('members.show', compact('member'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // For Tax calculation
        JavaScript::put([
            'taxes' => \Utilities::getSetting('taxes'),
            'gymieToday' => Carbon::today()->format('Y-m-d'),
            'servicesCount' => Service::count(),
        ]);

        //Get Numbering mode
        $invoice_number_mode = \Utilities::getSetting('invoice_number_mode');
        $member_number_mode = \Utilities::getSetting('member_number_mode');

        //Generating Invoice number
        if ($invoice_number_mode == \constNumberingMode::Auto) {
            $invoiceCounter = \Utilities::getSetting('invoice_last_number') + 1;
            $invoicePrefix = \Utilities::getSetting('invoice_prefix');
            $invoice_number = $invoicePrefix.$invoiceCounter;
        } else {
            $invoice_number = '';
            $invoiceCounter = '';
        }

        //Generating Member Counter
        if ($member_number_mode == \constNumberingMode::Auto) {
            $memberCounter = \Utilities::getSetting('member_last_number') + 1;
            $memberPrefix = \Utilities::getSetting('member_prefix');
            $member_code = $memberPrefix.$memberCounter;
        } else {
            $member_code = '';
            $memberCounter = '';
        }

        return view('members.create', compact('invoice_number', 'invoiceCounter', 'member_code', 'memberCounter', 'member_number_mode', 'invoice_number_mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Member Model Validation
        $this->validate($request, ['email' => 'unique:members,email',
                                   'contact' => 'unique:members,contact',
                                   'member_code' => 'unique:members,member_code', ]);

        // Start Transaction
        DB::beginTransaction();

        try {
            // Store member's personal details
            $memberData = ['name'=>$request->name,
                                    'DOB'=> $request->DOB,
                                    'gender'=> $request->gender,
                                    'contact'=> $request->contact,
                                    'emergency_contact'=> $request->emergency_contact,
                                    'health_issues'=> $request->health_issues,
                                    'email'=> $request->email,
                                    'address'=> $request->address,
                                    'member_id'=> $request->member_id,
                                    'proof_name'=> $request->proof_name,
                                    'member_code'=> $request->member_code,
                                    'status'=> $request->status,
                                    'pin_code'=> $request->pin_code,
                                    'occupation'=> $request->occupation,
                                    'aim'=> $request->aim,
                                    'source'=> $request->source, ];

            $member = new Member($memberData);
            $member->createdBy()->associate(Auth::user());
            $member->updatedBy()->associate(Auth::user());
            $member->save();

            DB::commit();
            flash()->success('Member was successfully created');

            return redirect(action('MembersController@show', ['id' => $member->id]));
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('Error while creating the member');

            return redirect(action('MembersController@index'));
        }
    }

    //End of new Member

    // End of store method

    /**
     * Edit a created resource in storage.
     *
     * @return Response
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $member_number_mode = \Utilities::getSetting('member_number_mode');
        $member_code = $member->member_code;

        return view('members.edit', compact('member', 'member_number_mode', 'member_code'));
    }

    /**
     * Update an edited resource in storage.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());

        
        $member->updatedBy()->associate(Auth::user());
        $member->save();

        flash()->success('Member details were successfully updated');

        return redirect(action('MembersController@show', ['id' => $member->id]));
    }

    /**
     * Archive a resource in storage.
     *
     * @return Response
     */
    public function archive($id, Request $request)
    {
        Subscription::where('member_id', $id)->delete();

        $invoices = Invoice::where('member_id', $id)->get();

        foreach ($invoices as $invoice) {
            InvoiceDetail::where('invoice_id', $invoice->id)->delete();
            $paymentDetails = PaymentDetail::where('invoice_id', $invoice->id)->get();

            foreach ($paymentDetails as $paymentDetail) {
                ChequeDetail::where('payment_id', $paymentDetail->id)->delete();
                $paymentDetail->delete();
            }

            $invoice->delete();
        }

        $member = Member::findOrFail($id);
        $member->clearMediaCollection('profile');
        $member->clearMediaCollection('proof');

        $member->delete();

        return back();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    private function drpPlaceholder(Request $request)
    {
        if ($request->has('drp_start') and $request->has('drp_end')) {
            return $request->drp_start.' - '.$request->drp_end;
        }

        return 'Select daterange filter';
    }
}