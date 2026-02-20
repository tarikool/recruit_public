<?php

namespace App\Http\Controllers;

use App\Billing;
use App\BillingJob;
use App\Client;
use App\CompanySetting;
use App\Http\Requests\BillingRequest;
use App\Job;
use App\Meeting;
use App\Notifications\BillingNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use JavaScript;
use PDF;
use function GuzzleHttp\Promise\all;

class BillingController extends Controller
{
    /**
     * Display  listing of the billings.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $billings = Billing::all();

            return datatables()->of($billings)
                ->addIndexColumn()
                ->editColumn('invoice_code', function ($row) {
                    return $row->invoice_code;
                })
                ->editColumn('issue_date', function ($row) {
                    return getFormattedReadableDate($row->issue_date);
                })
                ->editColumn('client', function ($row) {
                    return $row->client->name ?? 'N/A';
                })
                ->editColumn('creator', function ($row) {
                    return $row->creator->fullName() ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionColumn($row);
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        JavaScript::put([
            'billingRoute' => route('billings.index')
        ]);
        return view('billings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     * @throws Exception
     */
    public function create()
    {
        $invoiceCode = strtoupper($this->generateUniqueCode(8));
        $companySetting = CompanySetting::firstOrFail();
        $currentDate = Carbon::now()->format('Y-m-d');
        $clients = Client::has('jobs')->with('jobs')->get();
        $compact = compact('clients', 'companySetting', 'currentDate', 'invoiceCode');
        return view('billings.create', $compact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BillingRequest $request
     * @param Billing $billing
     * @return JsonResponse|RedirectResponse
     */
    public function store(BillingRequest $request, Billing $billing)
    {
        $client = Client::findOrFail($request->client_id);
        $billingJobs = $request->jobDetails['jobs'];
        $billingJobsCount = count($billingJobs);

        DB::beginTransaction();
        try {
            $billing->issue_date = Carbon::now()->format('Y-m-d');
            $billing->invoice_code = $request->invoice_code;
            $billing->client_id = $client->id;
            $billing->sub_total_amount = $request->sub_total_amount ?? 0;
            $billing->tax_amount = $request->tax_amount ?? 0;
            $billing->total_amount = $request->total_amount ?? 0;
            $billing->due_amount = $request->due_amount ?? 0;
            $billing->created_by = auth()->user()->id;
            $billing->save();

            for ($index = 0; $index < $billingJobsCount; $index++) {
                $billing->billing_jobs()->create(
                    [
                        'billing_id' => $billing->id,
                        'job_id' => $billingJobs[$index]['id'],
                        'bill_amount' => $billingJobs[$index]['amount'],
                        'discount_amount' => $billingJobs[$index]['discount'],
                        'remarks' => $billingJobs[$index]['remarks']
                    ]
                );
            }
            DB::commit();

            return response()->json(['billing' => $billing, 'message' => 'Billing Created Successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Billing $billing
     * @return Application|Factory|Response|View
     */
    public function show(Billing $billing)
    {
        $companySetting = CompanySetting::firstOrFail();
        $compact = compact('billing', 'companySetting');
        return view('billings.show', $compact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Billing $billing
     * @return Application|Factory|Response|View
     */
    public function edit(Billing $billing)
    {
        $companySetting = CompanySetting::firstOrFail();
        $clients = Client::has('jobs')->with('jobs')->get();
        $compact = compact('billing', 'clients', 'companySetting');
        return view('billings.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BillingRequest $request
     * @param Billing $billing
     * @return JsonResponse|RedirectResponse|Response
     */
    //public function update(BillingRequest $request, Billing $billing)
    public function update(Request $request, Billing $billing)
    {
        $client = Client::findOrFail($request->client_id);
        $billingJobs = $request->jobDetails['jobs'];
        $billingJobsCount = count($billingJobs);

        DB::beginTransaction();
        try {
            $billing->issue_date = Carbon::now()->format('Y-m-d');
            $billing->invoice_code = $request->invoice_code;
            $billing->client_id = $client->id;
            $billing->sub_total_amount = $request->sub_total_amount ?? 0;
            $billing->tax_amount = $request->tax_amount ?? 0;
            $billing->total_amount = $request->total_amount ?? 0;
            $billing->due_amount = $request->due_amount ?? 0;
            $billing->created_by = auth()->user()->id;
            $billing->save();


            $billing->billing_jobs()->delete();
            for ($index = 0; $index < $billingJobsCount; $index++) {
                $billing->billing_jobs()->create(
                    [
                        'billing_id' => $billing->id,
                        'job_id' => $billingJobs[$index]['id'],
                        'bill_amount' => $billingJobs[$index]['amount'],
                        'discount_amount' => $billingJobs[$index]['discount'],
                        'remarks' => $billingJobs[$index]['remarks']
                    ]
                );
            }
            DB::commit();

            return response()->json(['billing' => $billing, 'message' => 'Billing Updated Successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Billing $billing
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Billing $billing)
    {
        $billing->delete();
        return response()->json([
            'message' => __('Billing Deleted Successfully !'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BillingJob $billingJob
     * @return JsonResponse|RedirectResponse
     * @throws Exception
     */
    public function destroyBillingJobs(BillingJob $billingJob)
    {
        DB::beginTransaction();
        try {
            $billingJobTotalAmount = $billingJob->bill_amount - $billingJob->discount_amount;
            $billingSubTotalAmount = $billingJob->billing->sub_total_amount - $billingJobTotalAmount;
            $billingTaxAmount = $billingJob->billing->tax_amount;
            $billingDueAmount = $billingJob->billing->due_amount;
            $billingTotalAmount = ($billingSubTotalAmount + $billingTaxAmount) - $billingDueAmount;
            //        dd($billingJob->billing, $billingJob);
            $billingJob->billing->sub_total_amount = $billingSubTotalAmount;
            $billingJob->billing->total_amount = $billingTotalAmount;
            $billingJob->billing->update();

            $billingJob->delete();
            DB::commit();
            return response()->json([
                'message' => __('Billing Job Deleted Successfully !'),
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate Unique Invoice Code
     * @param $length
     * @return string
     * @throws Exception
     */
    public function generateUniqueCode($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }
        return $token;
    }

    /**
     * Download Invoice as PDF
     * @param Billing $billing
     * @param string $type
     * @return mixed
     */
    public function downloadInvoicePDF(Billing $billing, $type = 'stream')
    {
        $companySetting = CompanySetting::firstOrFail();
        $pdf = app('dompdf.wrapper')->loadView('billings.pdf', compact('billing', 'companySetting'));

        if ($type == 'stream') {
            return $pdf->stream('PDF');
        }

        if ($type == 'download') {
            return $pdf->download('billings.pdf');
        }
    }

    /**
     * Get DataTable Action Buttons
     * @param Request $request
     * @param Billing $billing
     * @return string
     */

    public function sendEmail(Request $request, Billing $billing)
    {

        DB::beginTransaction();
        try {

            $billing->is_notified = "1";
            $billing->save();
            $billing->load('client', 'billing_jobs.job.contact');

            $contacts = $billing->billing_jobs->pluck('job.contact', 'id')->unique('email')
                ->map(function ($item) use ($billing) {
                    $item->details = [
                        'subject' => __('Billing Invoice') . ' -' . 'dSpace Ltd',
                        'greeting' => __('Hi') . ' ' . $item->name . ',',
                        'body' => __('An Invoice Has Been Generated For') . ' ' . $billing->client->name,
                        'action' => route('billings.download.pdf', $billing->id),
                        'thanks' => __('Thank you for your patience!'),
                    ];
                    return $item;
                });

            if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
                Notification::send($contacts, new BillingNotification());
            } else {
                Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
            }

            DB::commit();

            return response()->json([
                'billing' => $billing,
                'message' => __('Email Sent.'),
                'contacts' => $contacts,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    private function getActionColumn($data): string
    {
        $showUrl = route('billings.show', $data);
        $editUrl = route('billings.edit', $data);
        $deleteUrl = route('billings.destroy', $data);
        $deleteMessage = __('Bill') . " " . __('Will be Deleted Permanently');
        $dataId = $data->id;

        return getDataTableActionColumn($showUrl, $editUrl, $deleteUrl, $deleteMessage, $dataId);
    }
}
