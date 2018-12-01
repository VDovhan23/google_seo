<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = \App\Models\Site::all();
        return view('site\index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site\create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //ВАЛІДАЦІЯ
        $site = new \App\Models\Site;
        $site->user_id = Auth::id();
        $site->name = $request->get('site_name'); //unique
        $site->address = $request->get('site_address');
        $site->keywords = $request->get('keywords');
        $site->depth = $request->get('depth');
        $site->frequency = $request->get('frequency');
        $info = $this->site_info($site->address, $site->keywords, $site->depth); // +2 params
        $site->position = $info; /// для перевірки
        pre($site);

//        $record=\App\Site::where();

        $site->save();
        return redirect('sites')->with('success', 'Information has been added');
    }

//    public function url_format($url)
//    {
//        $https_pos = preg_match('/^https.+/',  $url);
//        $http_pos = preg_match('/^http.+/',  $url);
//        if (!$https_pos AND !$http_pos){
//            $url = 'https://' . $url;
//        }
//        return($url);
//    }


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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = \App\Models\Site::find($id);
        $site->delete();
        return redirect('sites')->with('success','Information has been  deleted');
    }
}
