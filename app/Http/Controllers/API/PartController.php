<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Part;
use Auth;
use App\User;
class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $part = Part::find($id);
        $currentSite = Site::get()->where('id', $request['site_id']);
        $part->position = $part->position . ','. rand(1, 50). ','. rand(1, 50); // for graph test
        $part->date = $part->date . ','. date("d:m:Y"). ','. date("d:m:Y"); // for graph test
        // $part->position = $part->position . $this->site_info($domain, $keyword, $depth);
        $part->save();
        return $part;
    }


//     public function site_info($url, $keyword, $depth)
//     {
//         $search_results= array();

//         $google = new LaravelGoogleCustomSearchEngine();
//         $info = array();
//         $i = 1;
//         while ($i <= $depth) {
//             $parameters = array(
//                 'start' =>$i,
//                 'num' => 10
//             );
//             $results = $google->getResults($keyword, $parameters);
//             foreach ($results as $result){
//                 array_push($search_results, $result);
//             }
//             $i= $i+10;
//         }
// //        pre($search_results);

//         foreach ($search_results as $k=>$v){
//             if (preg_match('|'.$url.'|', $v->link)) { // зробити гарну регулярку для всіх випадків (http://, https://, http://www., https://www. ... )
//                 $info['position'] = $k+1;
//             }
//         }
// //        pre($info);
// //        exit;
//         return $info['position'];
//     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $part = Part::find($id);
        $allParts = Part::get()->where("site_id", $part->site_id);
        if (count($allParts) > 1){
            $part->delete();
            return ['message' => 'This Part has been deleted'];
        }
        else{
            $site = Site::get()->where("id", $part->site_id);
            $part->delete();
            $site[0]->delete();
            return ['message' => 'This Part and Site has been deleted'];
        }



        // $part->delete();


        // return ['message' => 'Part was deleted'];
    }
}
