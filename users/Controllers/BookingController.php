<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Shipper;
use App\Models\Consignee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\ExclusiveFieldsRule;

class BookingController extends Controller
{
    public function index( ) {
        return view( 'booking.index');
    }

    public function master( ) {
        $bookings = Booking::paginate(5);

        if ($bookings->isEmpty()) {
            return redirect('booking/single')->with('success', 'No bookings found. Please create a booking.');
        }

        return view('booking.master', compact('bookings'));
    }

    public function view(Booking $booking) {
        return view('booking.view', [
            'booking' => $booking
        ]);
    }

    public function createSingle()
    {
        $validatedData = $this->validateBooking();

        $booking = Booking::create($validatedData);

        return redirect('booking/'.$booking->id.'/view')->with('success', 'Booking created successfully.');
    }

    public function getShipperAddress(Request $request ){
        $shipper_id = $request->input('shipper_id');
        $shipper = Shipper::findOrFail($shipper_id);

        $address = [
            'address_1' => $shipper->shipper_address_1,
            'address_2' => $shipper->shipper_address_2,
            'latitude' => $shipper->shipper_latitude,
            'longitude' => $shipper->shipper_longitude,
            'phone' => $shipper->phone,
        ];
    
        return response()->json($address);
    } 

    public function getConsigneeAddress(Request $request ){
        $consignee_id = $request->input('consignee_id');
        $consignee = Consignee::findOrFail($consignee_id);

        $address = [
            'address_1' => $consignee->consignee_address_1,
            'address_2' => $consignee->consignee_address_2,
            'latitude' => $consignee->consignee_latitude,
            'longitude' => $consignee->consignee_longitude,
            'phone' => $consignee->phone,
        ];
    
        return response()->json($address);
    } 
    public function getDistancePrice(Request $request ){
        $shipperLat = $request->input('shipperLat');
        $shipperLong = $request->input('shipperLong');
        $consigneeLat = $request->input('consigneeLat');
        $consigneeLong = $request->input('consigneeLong');

        $pickup = [
            'lat' => $shipperLat,
            'lon' => $shipperLong
        ];
         $delivery = [
            'lat' => $consigneeLat,
            'lon' => $consigneeLong
        ];
        $zones = [
            'A' => ['base_price' => 5, 'base_distance' => 50, 'rate' => 1.3],
            'B' => ['base_price' => 5, 'base_distance' => 50, 'rate' => 2],
            'C' => ['base_price' => 5, 'base_distance' => 50, 'rate' => 4],
        ];

        // Calculate distance using Haversine formula
        $distance = self::calculateDistance($pickup, $delivery);

        if ($distance <= 200) {
            $zone = 'A';
        } elseif ($distance <= 500) {
            $zone = 'B';
        } else {
            $zone = 'C';
        }

        // Apply pricing logic
        $basePrice = $zones[$zone]['base_price'];
        $ratePerKm = $zones[$zone]['rate'];

        // Calculate the number of additional 5 km increments beyond the base distance
        $additionalKms = max(0, ceil(($distance - $zones[$zone]['base_distance']) / 5));

        // Calculate the additional cost for the extra distance
        $additionalCost = $additionalKms *  $ratePerKm;

        // Calculate the total price
        $totalPrice = $basePrice + $additionalCost;

        // $price = $zones[$zone]['base_price'] + ($distance - $zones[$zone]['base_distance']) * $zones[$zone]['rate'];

        // Round up to two decimal places
        $price = round($totalPrice, 2);

         return response()->json($price);
    
    }

    private function calculateDistance($point1, $point2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDiff = deg2rad($point2['lat'] - $point1['lat']);
        $lonDiff = deg2rad($point2['lon'] - $point1['lon']);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($point1['lat'])) * cos(deg2rad($point2['lat'])) *
             sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // Distance in kilometers
        return $distance;
    }
        

    public function delete(Booking $booking) {

       
        $booking->delete();

        return back()->with('success', 'Booking  Deleted!');
    }
    
    protected function validateBooking(?Booking $booking = null): array {
        $booking ??= new Booking();
        return request()->validate([
            'cn_no'                 => 'required',
            'date'                  => 'required',
            'category'              => 'required',
            'payment_mode'          => 'required',
            'shipper_id'            => ['required_without:one_time_shipper', new ExclusiveFieldsRule('one_time_shipper')],
            'one_time_shipper'      => ['required_without:shipper_id', new ExclusiveFieldsRule('shipper_id')],
            'shipper_number'        => 'required',
            'shipper_address1'      => 'required',
            'shipper_address2'      => 'required',
            'shipper_longitude'     => 'required',
            'shipper_latitude'      => 'required',
            'consignee_id'          => ['required_without:one_time_consignee', new ExclusiveFieldsRule('one_time_consignee')],
            'one_time_consignee'    => ['required_without:consignee_id', new ExclusiveFieldsRule('consignee_id')],
            'consignee_number'      => 'required',
            'consignee_address1'    => 'required',
            'consignee_address2'    => 'required',
            'consignee_longitude'   => 'required',
            'consignee_latitude'    => 'required',
            'content_type'          => 'required',
            'merchandise_code'      => 'required',
            'mode'                  => 'required',
            'quantity'              => 'required',
            'weight'                => 'required',
            'individual_price'      => 'required',
            'price_before_discount' => 'required',
            'discount'              => 'required',
            'price_after_discount'  => 'required',
            'biller'                => 'required',
            'description'           => 'nullable',
        ]);
    }
}
