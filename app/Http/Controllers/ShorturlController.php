<?php

namespace App\Http\Controllers;

use App\Shorturl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShorturlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('short');
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
        $longurl = request('longurl');

        //check if url exists
        $headers = @get_headers($longurl);
        if(!$headers || strpos($headers[0], '404')) {
            $error = 'URL does not exist. Make sure that it has the leading http:// or https://';
            return view('short',['error'=>$error]);
        }

        //check if url is already in database
        if(DB::table('shorturls')->where('longurl', $longurl)->exists()){
            $randomString = DB::table('shorturls')->where('longurl', $longurl)->value('shorturl');
        }
        else{
            //get random string for the short url and check if already in database
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charslength = strlen($chars);
            $length = 10;
            $randomString = '';
            do{
                for($i = 0; $i < $length; $i++){
                    $randomCharacter = $chars[mt_rand(0,$charslength - 1)];
                    $randomString .= $randomCharacter;
                }
            }while (DB::table('shorturls')->where('shorturl', $randomString)->exists());

            $short = new Shorturl();
            $short->longurl = $longurl;
            $short->shorturl = $randomString;

            $short->save();
        }
        $shorturl = url("/{$randomString}");

        return view('short',['shorturl'=>$shorturl]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shorturl  $shorturl
     * @return \Illuminate\Http\Response
     */
    public function show($shorturl)
    {

        $longurl = DB::table('shorturls')->where('shorturl', $shorturl)->value('longurl');
        
        return redirect($longurl);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shorturl  $shorturl
     * @return \Illuminate\Http\Response
     */
    public function edit(Shorturl $shorturl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shorturl  $shorturl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shorturl $shorturl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shorturl  $shorturl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shorturl $shorturl)
    {
        //
    }
}
