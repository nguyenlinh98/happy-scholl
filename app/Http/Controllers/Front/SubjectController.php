<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    public function index()
    {
        die('subject');
    }
    public function create()
    {
         Log::info('[SubjectController.index] Start');
        return view('front/subjects.create');
    }
}
