<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;

class SiteController extends Controller
{
    public $url;
    public $keywords;
    public $position;
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
        $site = new \App\Models\Site;
        $site->user_id = Auth::id();
        $site->name = $request->get('site_name');
        $site->address = $request->get('site_address');
        $site->keywords = $request->get('keywords');
        $this->keywords = $site->keywords;

        $this->url=$site->address;
        $site->address = $this->url_format($this->url);
        $this->url= $this->url_format($this->url);
        $site->address =$this->url;
        $keywords = $this->keywords;
//        $site->position = 1; /// для перевірки
//        pre($site->address);
//        pre($site->keywords);
//////        $site->save();
        $info = $this->site_info($site->address, $site->keywords);
//        pre($info);
    }

    public function url_format($url)
    {
        $url = $this->url;
        $https_pos = preg_match('/^https.+/',  $url);
        $http_pos = preg_match('/^http.+/',  $url);

        if (!$https_pos AND !$http_pos){
            $url = 'https://' . $url;
        }
        return($url);
    }


    public function site_info($url, $keywords)
    {
        $keywords = $this->keywords;
        $url = $this->url;
        $google = new LaravelGoogleCustomSearchEngine();
        $parameters = array(
            'start' => 1, // start from the 10th results,
            'num' => 10 // number of results to get, 10 is maximum and also default value
        );
        pre($keywords);
        $info = array();
        pre($url);
        $results = $google->getResults($keywords, $parameters);

        foreach ($results as $k=>$v){
            pre($v->link);

            if ($url == $v->link OR $url.'/' == $v->link){
                $info['position'] = $k+1;
            }
        }
        pre($info);
//        $results = $google->getResults("iactavate");
        pre ($results);
//        return($info);
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
        //
    }
}
