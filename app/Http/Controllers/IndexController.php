<?php

namespace App\Http\Controllers;

use App\Events\UserDataAdded;
use App\Models\App;
use App\Services\CardCodeService;
use App\Services\ECService;
use App\Services\OTPService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use phpseclib3\Crypt\EC;

class IndexController extends Controller
{
    function index(CardCodeService $service): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('welcome');
    }
}
