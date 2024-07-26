<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {   
        $query = City::with('state.country');
        
        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';
            
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhereHas('state', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm)
                            ->orWhereHas('country', function ($query) use ($searchTerm) {
                                $query->where('name', 'like', $searchTerm);
                            });
                    });
            });
        }

        $countries = $query->orderBy('created_at', 'DESC')->paginate(8);
        return Inertia::render('Admin/Country/Index', compact('countries'));
    }

    public function create()
    {
        $countries = Country::paginate();
        return Inertia::render('Admin/Country/Create');
    }

    public function store(Request $request)
    {
        $country = Country::updateOrCreate(
            ['name' => $request->country],
            ['name' => $request->country]
        );
        
        $state = State::updateOrCreate(
            ['name' => $request->state],
            [
                'name' => $request->state,
                'country_id' => $country->id
            ]
        );

        City::updateOrCreate(
            ['name' => $request->city],
            [
                'name' => $request->city,
                'state_id' => $state->id
            ]
        );

        return redirect()->route('admin.country.index');
    }

    public function delete($country_id, $state_id, $city_id)
    {
        $city = City::where('id', $city_id)->first();

        $city->delete();

        // if ($city_id != 0) {
        //     $city = City::where('id', $city_id)->first();
        //     $city->delete();
        // }

        // if ($country_id != 0) {
        //     $country = Country::where('id', $country_id)->first();
        //     $country->delete();
        // }

        // if ($state_id != 0) {
        //     $state = State::where('id', $state_id)->first();
        //     $state->delete();
        // }

        $countries = Country::with('state.city')->paginate();

        return response()->json($countries);
    }
}
