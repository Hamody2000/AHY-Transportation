<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndividualTransaction;
use App\Models\CompanyTransaction;
use App\Models\Transaction;
use App\Models\Client;
use \TCPDF;

class TransactionController extends Controller
{
    public function search(Request $request)
    {
        $date = $request->input('date');
        $searchDate = \Carbon\Carbon::parse($date);

        // Fetch individual and company transactions for the given date
        $individualTransactions = IndividualTransaction::whereDate('date', $searchDate)->get();
        $companyTransactions = CompanyTransaction::whereDate('date', $searchDate)->get();

        // Merge individual and company transactions
        $transactions = $individualTransactions->merge($companyTransactions);

        return view('transactions.search', [
            'transactions' => $transactions,
            'searchDate' => $searchDate
        ]);
    }

    public function addTransaction(Request $request, $clientId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'type' => 'required|in:credit,debit',
        ]);

        // Find the client
        $client = Client::findOrFail($clientId);

        // Create a new transaction
        $transaction = new Transaction();
        $transaction->client_id = $clientId;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->save();

        // Update total received or spent based on the type
        $this->updateClientTotals($clientId);

        return redirect()->route('clients.index')->with('success', 'تمت إضافة المعاملة بنجاح');
    }

    public function viewClientTransactions($clientId)
    {
        $client = Client::findOrFail($clientId);
        $transactions = $client->transactions()->orderBy('created_at', 'desc')->get();

        return view('transactions.client', [
            'client' => $client,
            'transactions' => $transactions
        ]);
    }

    // Method to select transactions for generating an invoice
    public function selectTransactionsForInvoice($clientId)
    {
        $client = Client::findOrFail($clientId);
        $individualTransactions = $client->individualTransactions()->paginate(10);
        $companyTransactions = $client->companyTransactions()->paginate(10);


        return view('transactions.select', compact('client', 'individualTransactions', 'companyTransactions'));
    }

    // Method to generate an invoice PDF for selected transactions
    public function generateInvoice(Request $request, $clientId)
    {
        $transactionIds = $request->input('transaction_ids');
        $client = Client::findOrFail($clientId);

        // Check if any transactions were selected
        if (empty($transactionIds)) {
            return redirect()->back()->with('error', 'Please select at least one transaction.');
        }

        // Determine client type and fetch corresponding transactions
        if ($client->type === 'individual') {
            $transactions = $client->individualTransactions()->whereIn('id', $transactionIds)->get();
        } else {
            $transactions = $client->companyTransactions()->whereIn('id', $transactionIds)->get();
        }

        // Calculate total amount for the invoice
        $totalAmount = $transactions->sum('TotalSpent');

        // Create new TCPDF instance
        $pdf = new \TCPDF();
        $pdf->setRTL(true);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('TCPDF, PDF, invoice');

        // Set margins and other properties
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('dejavusans', '', 12);

        // Add a page
        $pdf->AddPage();

        // Generate HTML for the PDF
        $html = view('transactions.invoice_pdf', compact('client', 'transactions', 'totalAmount'))->render();

        // Write the HTML to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF (Force Download)
        return $pdf->Output('invoice.pdf', 'D');
    }




    private function updateClientTotals($clientId)
    {
        $client = Client::findOrFail($clientId);

        // Calculate total received and spent for the client
        $totalReceivedIndividual = $client->individualTransactions->sum('amount');
        $totalReceivedCompany = $client->companyTransactions->sum('amount');
        $totalReceivedGeneral = Transaction::where('client_id', $clientId)->where('type', 'credit')->sum('amount');
        $totalSpent = Transaction::where('client_id', $clientId)->where('type', 'debit')->sum('amount');

        $totalReceived = $totalReceivedIndividual + $totalReceivedCompany + $totalReceivedGeneral;

        // Update client totals
        $client->total_received = $totalReceived;
        $client->total_spent = $totalSpent;
        $client->save();
    }
}
