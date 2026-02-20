<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientSource;
use App\Contact;
use App\Country;
use App\Http\Requests\ContactRequest;
use App\Industry;
use App\Meeting;
use App\Note;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::all();

            return datatables()->of($contacts)
                ->addIndexColumn()
                ->editColumn('full_name', function ($row) {
                    return ucwords($row->full_name());
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->editColumn('job_title', function ($row) {
                    return $row->job_title ?? 'N/A';
                })
                ->editColumn('number', function ($row) {
                    return $row->number ?? 'N/A';
                })
                ->editColumn('client', function ($row) {
                    return $row->client->name ?? 'N/A';
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionColumn($row);
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('contacts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $clients = Client::select('id', 'name')->get();
        $clientSources = ClientSource::select('id', 'name')->get();
        $countries = Country::select('id', 'name')->get();
        $compact = compact('clients', 'clientSources', 'countries');
        return view('contacts.create', $compact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse|Response
     */
    public function store(ContactRequest $request, Contact $contact)
    {
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->client_id = $request->client_id;
        $contact->email = $request->email;
        $contact->fax = $request->fax;
        $contact->number = $request->number;
        $contact->job_title = $request->job_title;
        $contact->twitter_profile_url = $request->twitter_profile_url;
        $contact->linkedin_profile_url = $request->linkedin_profile_url;
        $contact->billing_street = $request->billing_street;
        $contact->billing_city = $request->billing_city;
        $contact->billing_state = $request->billing_state;
        $contact->billing_code = $request->billing_code;
        $contact->billing_country_id = $request->billing_country_id;
        $contact->shipping_street = $request->shipping_street;
        $contact->shipping_city = $request->shipping_city;
        $contact->shipping_state = $request->shipping_state;
        $contact->shipping_code = $request->shipping_code;
        $contact->shipping_country_id = $request->shipping_country_id;
        $contact->client_source_id = $request->client_source_id;
        $contact->created_by = auth()->user()->id;

        //attached_others
        if ( $request->hasFile('attached_others') && $request->file('attached_others')->isValid()){
            $contact->attached_others = $request->file('attached_others')->store('contact_others');
        }

        $contact->save();
        toastr()->success(__('Contact Added Successfully!'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return Application|Factory|View
     */
    public function show(Contact $contact)
    {
        $industries = Industry::select('id', 'name')->get();
        $clientSources = ClientSource::select('id', 'name')->get();
        $countries = Country::select('id', 'code', 'name')->get();
        $notes = Note::where('related_module', 2)
            ->where('related_module_id', $contact->id)
            ->get(['id', 'title', 'note_type_id', 'updated_at']);
        $meetings = $contact->attendMeetings->merge($contact->collaborateMeeting);

        $compact = compact('contact', 'industries', 'clientSources', 'countries', 'notes', 'meetings');
        return view('contacts.show', $compact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @return Application|Factory|View
     */
    public function edit(Contact $contact)
    {
        $clients = Client::select('id', 'name')->get();
        $clientSources = ClientSource::select('id', 'name')->get();
        $countries = Country::select('id', 'name')->get();
        $compact = compact('contact', 'clients', 'clientSources', 'countries');
        return view('contacts.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->client_id = $request->client_id;
        $contact->email = $request->email;
        $contact->number = $request->number;
        $contact->fax = $request->fax;
        $contact->job_title = $request->job_title;
        $contact->twitter_profile_url = $request->twitter_profile_url;
        $contact->linkedin_profile_url = $request->linkedin_profile_url;
        $contact->billing_street = $request->billing_street;
        $contact->billing_city = $request->billing_city;
        $contact->billing_state = $request->billing_state;
        $contact->billing_code = $request->billing_code;
        $contact->billing_country_id = $request->billing_country_id;
        $contact->shipping_street = $request->shipping_street;
        $contact->shipping_city = $request->shipping_city;
        $contact->shipping_state = $request->shipping_state;
        $contact->shipping_code = $request->shipping_code;
        $contact->shipping_country_id = $request->shipping_country_id;
        $contact->client_source_id = $request->client_source_id;
        $contact->created_by = auth()->user()->id;

        //attached_others
        if ( $request->hasFile('attached_others') && $request->file('attached_others')->isValid()){
            Storage::delete($contact->attached_others);
            $contact->attached_others = $request->file('attached_others')->store('contact_others');
        }

        $contact->save();
        toastr()->success(__('Contact Added Successfully!'));
        return redirect()->back()->with(['contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return JsonResponse
     */
    public function destroy(Contact $contact)
    {
        if (Storage::exists($contact->attached_others)) {
            Storage::delete($contact->attached_others);
        }
        $contact->delete();
        return response()->json([
            'message' => __('Contact Deleted Successfully !'),
        ]);
    }


    /**
     * Download Attached Other Documents
     * @param Contact $contact
     * @return JsonResponse
     */
    public function downloadOtherDoc(Contact $contact)
    {
        if (!Storage::exists($contact->attached_others)) {
            return response()->json([
                'message' => __('No Other Document Found!'),
            ]);
        }
        $filename = $contact->full_name(). "_OthersDocument.pdf";
        return Storage::download($contact->attached_others, $filename);
    }


    /**
     * Get DataTable Action Buttons
     * @param $data
     * @return string
     */
    private function getActionColumn($data): string
    {
        $showUrl = route('contacts.show', $data);
        $editUrl = route('contacts.edit', $data);
        $deleteUrl = route('contacts.destroy', $data);
        $deleteMessage = __('Contacts') . " " . __('Will be Deleted Permanently');
        $dataId = $data->id;

        return getDataTableActionColumn($showUrl, $editUrl, $deleteUrl, $deleteMessage, $dataId);
    }
}
