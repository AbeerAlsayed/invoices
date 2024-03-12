<?php

namespace App\Http\Controllers;

use App\Models\InoviceAttachment;
use App\Models\Invoice;
use App\Models\InvoicesDetail;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    public function index(){
        $invoices=Invoice::all();
        return view('invoices.invoices',compact('invoices'));
    }

    public function create(){
        $sections=Section::all();
        return view('invoices.add_invoices',compact('sections'));
    }

    public function store(Request $request){
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        // latest(): get the last thing add in table invoices
        $invoice_id = Invoice::latest()->first()->id;

        InvoicesDetail::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            // get img name with path name.jpg
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new InoviceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // store image in this path
//            $request->file('pic')->storeAs('users',$imageName,'public1');
            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::first();
        // Notification::send($user, new AddInvoice($invoice_id));
//
//        $user = User::get();
//        $invoices = invoices::latest()->first();
//        Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));







//        event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    public function get_product($id){
        $product=Product::where('section_id',$id)->pluck('Product_name','id');
        return json_encode($product);
    }
}
