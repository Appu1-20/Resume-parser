<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Menifest;
use App\Models\Consignee;
use App\Models\Merchandise;
// use PharIo\Manifest\Manifest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenifestController extends Controller
{
    public function index( ) {
        $address = Booking::pluck('consignee_address2');

        if ($address->isEmpty()) {
            return redirect('booking/single')->with('success', 'No bookings found. Please create a booking.');
        }

        // return view('booking.master', compact('bookings'));
        
        return view( 'menifest.create', compact('address'));
    }
    public function create( Request $request  ) {
       // Create a new manifest
        $manifest = Menifest::create([
            'date' => $request['date'],
            'location' => $request['location'],
            'mode' => $request['mode'],
        ]);

        // Associate existing bookings with the newly created manifest
        foreach ($request['cn_no'] as $bookingCn) {
            $booking = Booking::where('cn_no', $bookingCn)->first();
            if ($booking) {
                $booking->update([
                    'menifests_code' => $manifest->menifests_code,
                    'status' => 'shipped'
                ]);
            }
        }
        return redirect('manifest/master')->with('success', 'Menifest created successfully.');

    }
    public function getRequiredmanifest( Request $request  ) {
        $cn = $request->input('cn_no');
        // $location = $request->input('location');
        $menifest = Booking::where('cn_no', $cn)
                  ->first();

         if ($menifest['menifest_code'] == null) {
            $consignee = $menifest['consignee_id'];
            $consignee_name = Consignee::where('id', $menifest['consignee_id'])
                ->pluck('name')
                ->first();

            $menifest['consignee_name'] = $consignee_name;

            return response()->json($menifest);
        } else {
            return response()->json(['message' => 'Manifest not found.']);
        }
    }

    public function master( ) {
        $menifests = Menifest::paginate(5);

        if ($menifests->isEmpty()) {
            return redirect('menifest/create')->with('success', 'No menifests found. Please create a menifest.');
        }

        return view('menifest.master', compact('menifests'));
    }

    public function view($menifest) {
        $manifest = Menifest::where('id', $menifest)->first();

        if (!$manifest) {
            // Handle error, manifest not found
            // ...
        }

        $bookings = $manifest->bookings()->select(
            'cn_no',
            'consignee_id',
            'one_time_consignee',
            'consignee_address1',
            'merchandise_code',
            'weight',
            'quantity'
        )->get();

        foreach ($bookings as $booking) {
            if ($booking->one_time_consignee) {
                // One-time consignee, add it to return value
                $booking->consignee_name = $booking->one_time_consignee;
            } else {
                // Get consignee name from consignee_id
                $consignee = Consignee::find($booking->consignee_id);
                $booking->consignee_name = $consignee ? $consignee->name : null;
            }

            // Get merchandise name from merchandise_code
            $merchandise = Merchandise::where('id', $booking->merchandise_code)->first();
            // dd($merchandise);
            $booking->merchandise_name = $merchandise ? $merchandise->name : null;
        }

        return view('menifest.view', ['menifest' => $manifest, 'bookings' => $bookings]);
    }

    public function delete(Menifest $menifest) {
        // Update related bookings when deleting a menifest
        $menifest->bookings()->update([
            'status' => 'booked',
            'menifests_code' => null
        ]);
    
        $menifest->delete();
    
        return back()->with('success', 'Menifest Deleted!');
    }

    public function getMenifestCode(Request $request)
    {

        $imageName = time().'.'.$request->cn_img->extension();  
     
        $request->cn_img->move('c:\\images\\', $imageName);
        $path = 'c:\\images\\' . $imageName;
        $command = 'C:\\"Program Files (x86)"\\ZBar\\bin\\zbarimg -q ' . $path ;
        exec( $command , $result);
        unlink($path);
        // print_r($result);
        return response()->json($result);
    }
    
}
