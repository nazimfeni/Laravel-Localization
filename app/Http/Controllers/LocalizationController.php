<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;



class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($locale)
    {
        if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    App::setLocale($locale, config('localization.locales'));
     session(['localization' =>$locale]);

     return redirect()->back();
    }


}
