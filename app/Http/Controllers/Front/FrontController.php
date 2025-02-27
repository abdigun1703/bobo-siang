<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelBookingRequest;
use App\Http\Requests\StoreSearchHotelRequest;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Models\HotelRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;


class FrontController extends Controller
{
    public function index() {
        return view('front.index');
    }

    public function hotels() {
        return view('front.hotels');
    }

    public function search_hotels(StoreSearchHotelRequest $request){
        $request->session()->put('checkin_at', $request->input('checkin_at'));
        $request->session()->put('checkout_at', $request->input('checkout_at'));
        $request->session()->put('keyword', $request->input('keyword'));

        $keyword = $request->session()->get('keyword');

        return redirect()->route('front.hotels.list', ['keyword' => $keyword]);
    }

    public function list_hotels($keyword) {//parameter keyword didapat dari function diatas nya
        $hotels = Hotel::with(['rooms', 'city', 'country'])

        ->whereHas('country', function($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })

        ->orWhereHas('city', function($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })

        ->orWhere('name', 'like', '%' . $keyword . '%')

        ->get();

        return view('front.list_hotels', compact('hotels', 'keyword'));
    }

    public function hotel_details(Hotel $hotel) {
        $latestPhotos = $hotel->photos()->orderByDesc('id')->take(3)->get();

        return view('front.details', compact('hotel', 'latestPhotos'));
    }

    public function hotel_rooms(Hotel $hotel) {

        return view('front.list_hotel_rooms', compact('hotel'));
    }

    public function hotel_room_book(StoreHotelBookingRequest $request, Hotel $hotel, HotelRoom $hotel_room) {
        $user = Auth::user();

        $checkin_at  = $request->session()->get('checkin_at');
        $checkout_at = $request->session()->get('checkout_at');

        $hotelBookingId = null;


        // $permission = Permission::findOrFail(1);
        // $groupsWithPerms = $permission->getRoleNames();

        // $permissions = $user->getAllPermissions();

        // dd($permissions);

        DB::transaction(function() use ($request, $user, $hotel, $hotel_room, $checkin_at, $checkout_at, &$hotelBookingId) {
            $validated = $request->validated();

            $validated['user_id'] = $user->id;
            $validated['hotel_id'] = $hotel->id;

            $validated['checkin_at'] = $checkin_at;
            $validated['checkout_at'] = $checkout_at;

            $validated['hotel_room_id'] = $hotel_room->id;
            $validated['is_paid'] = false;
            $validated['proof'] = 'dummytrx.png';

            //Calculate total days
            $checkinDate = \Carbon\Carbon::parse($checkin_at);
            $checkoutDate = \Carbon\Carbon::parse($checkout_at);
            $totalDays = $checkinDate->diffInDays($checkoutDate); // untuk mengetahui berapa hari dia sudah check in

            $validated['total_days'] = $totalDays;

            //Calculate todal amount
            $validated['total_amount'] = $hotel_room->price * $totalDays;

            $newBooking = HotelBooking::create($validated);

            $hotelBookingId = $newBooking->id;

        });

        return redirect()->route('front.hotel.book.payment', $hotelBookingId);

    }

    public function hotel_payment(HotelBooking $hotel_booking) {

        return view('front.book_payment', compact('hotel_booking'));
    }

}
