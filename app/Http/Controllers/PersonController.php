<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\Resources\PersonResource;
use App\http\Resources\PersonResourceCollection;
use App\Person;
class PersonController extends Controller
{
    /**PersonResourceCollection
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : PersonResourceCollection 
    {
        //return response()->json(Person::get());
        //return new PersonResourceCollection(Person::paginate());
        return new PersonResourceCollection(Person::OrderBy('id','DESC')->paginate());

        //$person = Person::orderBy('created_at', 'desc')->paginate(5);
        // return collection of articles as a resource 
       // return PersonResourceCollection::collection($person);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'city' => 'required',
        ]);
        // $person = new Person();
        // $person->firs_name = $request->input('first_name');
        // $person->last_name = $request->input('last_name');
        // $person->phone = $request->input('phone');
        // $person->email = $request->input('email');
        // $person->city = $request->input('city');

        // $person->save();

        //   return response()->json($person);

          $person  = Person::create($request->all());
         return new PersonResource($person);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person): PersonResource
    {
        return new PersonResource($person);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Person $person , Request $request): PersonResource
    {
        $person->update($request->all());
        
        return new PersonResource($person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
        
        return response()->json();
    }
}
