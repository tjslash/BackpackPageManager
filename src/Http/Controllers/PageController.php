<?php

namespace Tjslash\CtoPageManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Tjslash\CtoPageManager\Models\Page;
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
            $page->view ?? 'tjslash.cto-page-manager::page.common',
            compact('page')
        );
    }
}