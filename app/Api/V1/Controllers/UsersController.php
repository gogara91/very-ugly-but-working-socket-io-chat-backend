<?php

namespace App\Api\V1\Controllers;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return User::where('id', '<>', auth()->user()->id)->get();
    }
}
