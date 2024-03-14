<?php

namespace App\Http\Controllers;

use App\Models\InoviceAttachment;
use App\Models\Invoice;
use App\Models\InvoicesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailController extends Controller
{
    public function edit($id){
            $invoices = Invoice::where('id',$id)->first();
            $details  = InvoicesDetail::where('id_Invoice',$id)->get();
            $attachments  = InoviceAttachment::where('invoice_id',$id)->get();
            return view('invoices.invoices_details',compact('invoices','details','attachments'));
    }

    public function destroy(Request $request)
    {
        $invoices = InoviceAttachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function open_file($invoices_number , $file_name)
    {
//        $files = Storage::disk('public_uploads')->get($invoices_number .'/'. $file_name);
        $files = public_path('Attachments/'.$invoices_number.'/'.$file_name);
        return response()->file($files);
    }

    public function get_file($invoices_number , $file_name)
    {
//        dd($file_name);
//        $files = Storage::disk('public_uploads')->get($invoices_number.'/'.$file_name);
        $files = public_path('Attachments/'.$invoices_number.'/'.$file_name);

        return response()->download($files);
    }


}
