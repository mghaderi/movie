<?php

namespace App\Http\Controllers\Frontend;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        return response()->streamDownload(function () {
//            readfile('https://dl3.cdnhost.sbs/Series/Under.the.Dome/S03/720p/Under.the.Dome.S03E13.720p.Pahe.SoftSub.MovieCottage.mkv');
//        }, 'nice-name.mkv');
        return view('frontend.index');
    }
}
