<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use Auth;

class WebSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Site::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'url' => ['required', 'regex:/^(http\:\/\/|https\:\/\/)([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-].*$/m'],
            'keywords' => 'required'
        ]);

       return Site::create([
            'user_id' => $request['user_id'],
            'domain' => $request['url'],
            'keywords' => $request['keywords'],
            'depth' => $request['depth'],
            'frequency' => $request['frequency'],
            'position' => 2,
            'date' => date("d:m:Y"),
       ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        $site = Site::find($id);
        $site->user_id = $request['user_id'];
        $site->domain = $request['url'];
        $site->keywords = $request['keywords'];
        $site->depth = $request['depth'];
        $site->frequency = $request['frequency'];
        $site->position = 2;
        $site->date = date("d:m:Y");
        $site->save();

        return ['message' => 'Site was updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::find($id);
        $site->delete();
        return ['message' => 'Site was deleted'];
    }
}
