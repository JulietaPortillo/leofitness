<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Member;
use JavaScript;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\ChequeDetail;
use App\Models\Subscription;
use App\Models\InvoiceDetail;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use App\Lubus\Constants;
use App\Lubus\Utilities;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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
        DB::enableQueryLog();
        $members = Member::indexQuery($request->sort_field, $request->sort_direction)->search('"'.$request->input('search').'"')->paginate(10);
        //$queryLog = DB::getQueryLog();
        $count = $members->total();

        $drp_placeholder = $this->drpPlaceholder($request);

        $request->flash();

        return view('members.index', compact('members', 'count', 'drp_placeholder'));
    }

    public function active(Request $request)
    {
        $members = Member::active($request->sort_field, $request->sort_direction, $request->drp_start, $request->drp_end)->search('"'.$request->input('search').'"')->paginate(10);
        $count = $members->total();

        $drp_placeholder = $this->drpPlaceholder($request);

        $request->flash();

        return view('members.active', compact('members', 'count', 'drp_placeholder'));
    }

    public function inactive(Request $request)
    {
        $members = Member::inactive($request->sort_field, $request->sort_direction, $request->drp_start, $request->drp_end)->search('"'.$request->input('search').'"')->paginate(10);
        $count = $members->total();

        $drp_placeholder = $this->drpPlaceholder($request);

        $request->flash();

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
        $taxes = Utilities::getSetting('taxes');


        JavaScript::put([
        'taxes' => $taxes,
        'gymieToday' => Carbon::today()->format('Y-m-d'),
        ]);
        //Get Numbering mode
        $invoice_number_mode = Utilities::getSetting('invoice_number_mode');
        $member_number_mode = Utilities::getSetting('member_number_mode');

        //Generating Invoice number
        if ($invoice_number_mode == Constants::Auto) {
            $invoiceCounter = Utilities::getSetting('invoice_last_number') + 1;
            $invoicePrefix = Utilities::getSetting('invoice_prefix');
            $invoice_number = $invoicePrefix.$invoiceCounter;
        } else {
            $invoice_number = '';
            $invoiceCounter = '';
        }

        //Generating Member Counter
        if ($member_number_mode == Constants::Auto) {
            $memberCounter = Utilities::getSetting('member_last_number') + 1;
            $memberPrefix = Utilities::getSetting('member_prefix');
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

            
            // Helper function for calculating payment status
            $invoice_total = $request->admission_amount + $request->subscription_amount + $request->taxes_amount - $request->discount_amount;
            $paymentStatus = Constants::Unpaid;
            $pending = $invoice_total - $request->payment_amount;

            if ($request->mode == 1) {
                if ($request->payment_amount == $invoice_total) {
                    $paymentStatus = Constants::Paid;
                } elseif ($request->payment_amount > 0 && $request->payment_amount < $invoice_total) {
                    $paymentStatus = Constants::Partial;
                } elseif ($request->payment_amount == 0) {
                    $paymentStatus = Constants::Unpaid;
                } else {
                    $paymentStatus = Constants::Overpaid;
                }
            }

            // Storing Invoice
            $invoiceData = ['invoice_number'=> $request->invoice_number,
                                     'member_id'=> $member->id,
                                     'total'=> $invoice_total,
                                     'status'=> $paymentStatus,
                                     'pending_amount'=> $pending,
                                     'discount_amount'=> $request->discount_amount,
                                     'discount_percent'=> $request->discount_percent,
                                     'discount_note'=> $request->discount_note,
                                     'tax'=> $request->taxes_amount,
                                     'additional_fees'=> $request->additional_fees,
                                     'note'=>' ', ];

            $invoice = new Invoice($invoiceData);
            $invoice->createdBy()->associate(Auth::user());
            $invoice->updatedBy()->associate(Auth::user());
            $invoice->save();

            // Storing subscription
            foreach ($request->plan as $plan) {
                $subscriptionData = ['member_id'=> $member->id,
                                            'invoice_id'=> $invoice->id,
                                            'plan_id'=> $plan['id'],
                                            'start_date'=> $plan['start_date'],
                                            'end_date'=> $plan['end_date'],
                                            'status'=> Constants::onGoing,
                                            'is_renewal'=>'0', ];

                $subscription = new Subscription($subscriptionData);
                $subscription->createdBy()->associate(Auth::user());
                $subscription->updatedBy()->associate(Auth::user());
                $subscription->save();

                //Adding subscription to invoice(Invoice Details)
                $detailsData = ['invoice_id'=> $invoice->id,
                                       'plan_id'=> $plan['id'],
                                       'item_amount'=> $plan['price'], ];

                $invoiceDetails = new InvoiceDetail($detailsData);
                $invoiceDetails->createdBy()->associate(Auth::user());
                $invoiceDetails->updatedBy()->associate(Auth::user());
                $invoiceDetails->save();
            }

            // Store Payment Details
            $paymentData = ['invoice_id'=> $invoice->id,
                                     'payment_amount'=> $request->payment_amount,
                                     'mode'=> $request->mode,
                                     'note'=> ' ', ];

            $paymentDetails = new PaymentDetail($paymentData);
            $paymentDetails->createdBy()->associate(Auth::user());
            $paymentDetails->updatedBy()->associate(Auth::user());
            $paymentDetails->save();

            if ($request->mode == 0) {
                // Store Cheque Details
                $chequeData = ['payment_id'=> $paymentDetails->id,
                                      'number'=> $request->number,
                                      'date'=> $request->date,
                                      'status'=> Constants::Recieved, ];

                $cheque_details = new ChequeDetail($chequeData);
                $cheque_details->createdBy()->associate(Auth::user());
                $cheque_details->updatedBy()->associate(Auth::user());
                $cheque_details->save();
            }

            //Updating Numbering Counters
            Setting::where('key', '=', 'invoice_last_number')->update(['value' => $request->invoiceCounter]);
            Setting::where('key', '=', 'member_last_number')->update(['value' => $request->memberCounter]);

           

            if ($subscription->start_date < $member->created_at) {
                $member->created_at = $subscription->start_date;
                $member->updated_at = $subscription->start_date;
                $member->save();

                $invoice->created_at = $subscription->start_date;
                $invoice->updated_at = $subscription->start_date;
                $invoice->save();

                foreach ($invoice->invoiceDetails as $invoiceDetail) {
                    $invoiceDetail->created_at = $subscription->start_date;
                    $invoiceDetail->updated_at = $subscription->start_date;
                    $invoiceDetail->save();
                }

                $paymentDetails->created_at = $subscription->start_date;
                $paymentDetails->updated_at = $subscription->start_date;
                $paymentDetails->save();

                $subscription->created_at = $subscription->start_date;
                $subscription->updated_at = $subscription->start_date;
                $subscription->save();
            }
            

            DB::commit();
            flash()->success('Member was successfully created');
            
            return redirect(route('members.show', ['id' => $member->id]));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            dd("reached here");
            
            flash()->error('Error while creating the member');

            return redirect(route('members.index'));
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
        $member_number_mode = Utilities::getSetting('member_number_mode');
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

    public function transfer($id, Request $request)
    {
        // For Tax calculation
        JavaScript::put([
            'taxes' => Utilities::getSetting('taxes'),
            'gymieToday' => Carbon::today()->format('Y-m-d'),
            'servicesCount' => Service::count(),
        ]);

        //Get Numbering mode
        $invoice_number_mode = Utilities::getSetting('invoice_number_mode');
        $member_number_mode = Utilities::getSetting('member_number_mode');

        //Generating Invoice number
        if ($invoice_number_mode == Constants::Auto) {
            $invoiceCounter = Utilities::getSetting('invoice_last_number') + 1;
            $invoicePrefix = Utilities::getSetting('invoice_prefix');
            $invoice_number = $invoicePrefix.$invoiceCounter;
        } else {
            $invoice_number = '';
            $invoiceCounter = '';
        }

        //Generating Member Counter
        if ($member_number_mode == Constants::Auto) {
            $memberCounter = Utilities::getSetting('member_last_number') + 1;
            $memberPrefix = Utilities::getSetting('member_prefix');
            $member_code = $memberPrefix.$memberCounter;
        } else {
            $member_code = '';
            $memberCounter = '';
        }


        return view('members.transfer', compact('invoice_number', 'invoiceCounter', 'member_code', 'memberCounter', 'member_number_mode', 'invoice_number_mode'));
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

    /*
    private function generateQRCodeImage($text, $path)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($text);

        // Save the QR code as an image file
        file_put_contents(public_path($path), $qrCode);
    }
    */
}