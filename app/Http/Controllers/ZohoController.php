<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZohoService;
use Illuminate\Support\Facades\Http;


class ZohoController extends Controller
{
    protected $zohoService;

    public function __construct(ZohoService $zohoService)
    {
        $this->zohoService = $zohoService;
    }

	public function createAccessToken()
{
    
$response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', [
    'code' => '1000.4ba1837d33cfb3b3bdef25e56cc9ac63.f18a854e7b868dcd9abebac07406997d',
    'client_id' => env('ZOHO_CLIENT_ID'),
    'client_secret' => env('ZOHO_CLIENT_SECRET'),
    'redirect_uri' => env('ZOHO_REDIRECT_URI'),
    'grant_type' => 'authorization_code',
]);

dd($response->json());




    $this->accessToken = $response->json()['access_token'];
}


    public function showForm()
    {
        return view('zoho');
    }

    public function createDeal(Request $request)
{
    $this->createAccessToken();

    $validatedData = $request->validate([
        'deal_name' => 'required|string|max:255',
        'contact_name' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'account_name' => 'required|string|max:255',
        'industry' => 'required|string|max:255',
    ]);

    $dealData = [
        'Deal_Name' => $validatedData['deal_name'],
        'Contact_Name' => $validatedData['contact_name'],
        'Amount' => $validatedData['amount']
    ];

    $accountData = [
        'Account_Name' => $validatedData['account_name'],
        'Industry' => $validatedData['industry']
    ];

    $this->createAccessToken();

    $dealCreated = $this->zohoService->createDeal($dealData, $this->accessToken);
    $accountCreated = $this->zohoService->createAccount($accountData, $this->accessToken);

    if ($dealCreated && $accountCreated) {
        return redirect()->route('zoho.form')->with('success', 'Deal and Account created successfully.');
    } else {
        return redirect()->route('zoho.form')->with('error', 'Failed to create Deal and Account.');
    }
}
}

?>
