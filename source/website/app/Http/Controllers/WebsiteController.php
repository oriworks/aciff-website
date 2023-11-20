<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Page;
use App\Models\Information;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function show(Page $page)
    {
        if($page->view === 'contact-form') {
            return view($page->view, ['page' => $page, 'departments' => Department::all()]);
        }
        return view($page->view, ['page' => $page]);
    }

    public function news()
    {
        $data = Information::orderByDesc('publish_at')->paginate(10);
        return view('information-list', ['list' => $data]);
    }

    public function information(Information $information)
    {
        return view('information', ['information' => $information]);
    }
}
