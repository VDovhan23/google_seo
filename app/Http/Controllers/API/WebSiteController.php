<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Part;
use Auth;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use App\User;
use Illuminate\Support\Facades\Hash;

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


        // $info = $this->site_info($request['url'], $request['keywords'], $request['depth']);

        $site = new Site;
        $site->user_id = $request['user_id'];
        $site->domain = $request['url'];
        $site->keywords = $request['keywords'];
        $site->depth = $request['depth'];
        $site->frequency = $request['frequency'];
        // $site->position = $info; //буде перероблено на  останню позицію
        $site->position = 2; //буде перероблено на  останню позицію
        $site->date = date("d:m:Y"); // буде дата останнього оновелння
        if (!empty(Site::all()->last()->id)) {
            $partId = Site::all()->last()->id+1;
        }else{
            $partId = 1;
        }
        $parts = $this->createParts($partId, $request['url'], $request['keywords'], $request['depth'], $request['frequency']);

        $site->save();
        return $site;
    }

    public function createParts($id, $domain, $keywords, $depth, $frequency){
        $keywords_arr = explode(',',$keywords);
        foreach ($keywords_arr as $keyword) {
            $part = new Part;
            $part->site_id = $id;
            $part->domain = $domain;
            $part->keyword = $keyword;
            $part->site_id = $id;
            $part->date = date("d:m:Y h:i");
            $part->position = $this->site_info($domain, $keyword, $depth);
            $part->save();
        }
    }

    public function site_info($url, $keyword, $depth)
    {
        $search_results= array();

        $google = new LaravelGoogleCustomSearchEngine();
        $info = array();
        $i = 1;
        while ($i <= $depth) {
            $parameters = array(
                'start' =>$i, // start from the 10th results,
                'num' => 10 // number of results to get, 10 is maximum and also default value
            );
            $results = $google->getResults($keyword, $parameters);
            foreach ($results as $result){
                array_push($search_results, $result);
            }
            $i= $i+10;
        }
//        pre($search_results);

        foreach ($search_results as $k=>$v){
            if (preg_match('|'.$url.'|', $v->link)) { // зробити гарну регулярку для всіх випадків (http://, https://, http://www., https://www. ... )
                $info['position'] = $k+1;
            }
        }
//        pre($info);
//        exit;
        return $info['position'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Part::all()->where('site_id', $id);
        return $site;
    }


    public function profile(Request $request)
    {
        $user = User::find($request->id);
        return $user;
    }

    public function updateProfile(Request $request)

    {
       $user = User::find($request->id);
       $user->name = $request['name'];
       $user->email = $request['email'];

       if ($request['photo'] ){
        $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
        \Image::make($request->photo)->save(public_path('img/profile/').$name);
        $request->merge(['photo' => $name]);
        $user->avatar = $request['photo'];
       }
       $user->type = $request['type'];
       if ($request['password']){
           $user->password = Hash::make($request['password']);
       }
       $user->save();

       return $user;
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

        $info = $this->site_info($request['url'], $request['keywords'], $request['depth']);
        $site->position = $info;
        $site->date = date("d:m:Y h:i");
        $request['competitor'] ? $site->competitor = $request['competitor'] : $site->competitor = "-";

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
        $parts = Part::where('site_id', $id)->get()->each->delete(); // delete each part who have connection with this site
        return ['message' => 'Site was deleted'];
    }
}
