<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use Auth;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

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


        $info = $this->site_info($request['url'], $request['keywords'], $request['depth']);

        pre($info);

       return Site::create([
            'user_id' => $request['user_id'],
            'domain' => $request['url'],
            'keywords' => $request['keywords'],
            'depth' => $request['depth'],
            'frequency' => $request['frequency'],
            'position' => $info,
            'date' => date("d:m:Y"),
       ]);


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
        $site = Site::find($id);

        return view('site.show', compact('site'));
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
