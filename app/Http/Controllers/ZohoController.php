<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZohoService;
use App\Http\Middleware\ZohoTokenMiddleware;

class ZohoController extends Controller
{
    protected $zohoService;

    public function __construct(ZohoService $zohoService)
    {
        $this->zohoService = $zohoService;
    }

    public function showForm()
    {
        return view('zoho');
    }

    public function createDeal(Request $request)
    {
        // Валідація введених даних
        $validatedData = $request->validate([
            'deal_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'account_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
        ]);

        // Створення сутності Deal в Zoho
        $dealData = [
            'Deal_Name' => $validatedData['deal_name'],
            'Contact_Name' => $validatedData['contact_name'],
            'Amount' => $validatedData['amount']
        ];
        $dealCreated = $this->zohoService->createDeal($dealData);

        // Створення сутності Account в Zoho
        $accountData = [
            'Account_Name' => $validatedData['account_name'],
            'Industry' => $validatedData['industry']
        ];
        $accountCreated = $this->zohoService->createAccount($accountData);

        // Повернення повідомлення про успішність або невдачу
        if ($dealCreated && $accountCreated) {
            return redirect()->route('zoho.form')->with('success', 'Deal and Account created successfully.');
        } else {
            return redirect()->route('zoho.form')->with('error', 'Failed to create Deal and Account.');
        }
    }
}


?>


