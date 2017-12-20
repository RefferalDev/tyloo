<?php

namespace App\Http\Controllers;

use App\Repositories\Criterias\LastFive;
use App\Tag;
use App\Work;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $works = Work::with('tags')->all();
        $tags = Tag::has('works')->all();

        return view('works.index', compact('works', 'tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $work = Work::whereSlug($slug)->first();
        $works = Work::latest()->take(5);

        return view('works.show', compact('work', 'works'));
    }
}
