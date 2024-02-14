<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\Page;
use App\Models\Information;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

    public function category(Category $category)
    {
        $categoryIds = Category::with('childrenRecursive')->where('id', $category->id)->get();
        $documents = Document::whereIn('category_id', $categoryIds->pluck('id'))
            ->whereNotNull('publish_at')
            ->where('publish_at', '<', now())
            ->paginate(5);
        return view('history-category', ['category' => $category, 'documents' => $documents]);
    }

    public function document(Document $document)
    {
        return $document->pages;
    }

    public function download(Document $document)
    {
        if ($document->downloadable) {
            $data = ['pages' => $document->mediaPages];
            $pdf = PDF::loadView('document', $data);

            return $pdf->download($document->slug . '.pdf');
        }
    }
}
