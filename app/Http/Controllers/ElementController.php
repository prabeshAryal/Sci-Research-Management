<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
{
    public function index()
    {
        return response()->json(Element::all());
    }
}
