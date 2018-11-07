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
        $site->site_address = $request->get('site_address');
//
        $this->url = $site->site_address;
        $site->keywords = $request->get('keywords');
        $this->keywords = $site->keywords;
//
        $url = $this->url;
        $site->site_address = $this->url_format($this->url);
        $keywords = $this->keywords;
    }

    public function url_format($url)
    {
        $url = $this->url;
        $https_pos = preg_match('/^https.+/',  $url);
        $http_pos = preg_match('/^http.+/',  $url);
        if (!$https_pos OR !$http_pos){
            $url = 'https://' . $url;
        }
        return($url);
    }


    public function parser_position($url, $keywords)
    {
//        $url = $this->url;
//        $keywords = $this->keywords;
//        //розібратися з пошуковими запитами або знайти API
//        $homepage = file_get_contents('https://www.google.com.ua/search?num=50&as_qdr=all&biw=1224&bih=938&ei=H1vhW-HkNdHLsAH9qrCADQ&q=iactivate&oq=iactivate&gs_l=psy-ab.3..35i39k1l2j0i203k1l8.1471682.1471970.0.1473113.2.2.0.0.0.0.127.248.0j2.2.0....0...1c.1.64.psy-ab..0.2.247...0.0.StEV4MsU2TU');
//
//        $str = str_get_html($homepage);
//        $site_urls = $str->find('.s .hJND5c');
//
//        foreach ($site_urls as $site){
//            echo $site;
//            echo "<br>";
//            echo "<br>";
//        }
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
