<?php

namespace Tjslash\BackpackPageManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Tjslash\BackpackPageManager\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show page
     * 
     * @param Page $page
     * @param Request $request
     * 
     * @return View
     */
    public function index(Page $page, Request $request) : View
    {
        abort_if(!$page->active, 404);
        return view(
            $page->view ?? 'tjslash.backpack-page-manager::page.common',
            compact('page')
        );
    }
}