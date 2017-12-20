<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkRequest;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $works = Work::all();

        return view('admin.works.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.works.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WorkRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(WorkRequest $request)
    {
        $this->saveWork($request->all());

        return redirect()->route('admin.works.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $work = Work::findOrFail($id);

        return view('admin.works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $work = Work::findOrFail($id);

        return view('admin.works.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WorkRequest $request
     * @param int         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(WorkRequest $request, $id)
    {
        $this->saveWork($request->all(), $id);

        return redirect()->route('admin.works.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Work::delete($id);

        return redirect()->route('admin.works.index');
    }

    /**
     * We create or update the Work.
     *
     * @param array    $data
     * @param int|null $id
     *
     * @return Work
     */
    protected function saveWork(array $data = [], $id = null)
    {
        // Image Handling
        if (isset($data['image'])) {
            $data['image'] = $this->buildImage($data['slug'], $data['image']);
        }

        // We create the Work
        if (null === $id) {
            $data['author_id'] = Auth::id();

            $work = Work::create($data);
        } else {
            $work = Work::update($data, $id);
        }

        $this->saveTags($data, $work);
    }

    /**
     * Build the image.
     *
     * @param string       $slug
     * @param UploadedFile $image
     *
     * @return string
     */
    protected function buildImage($slug, $image)
    {
        $filePath = 'uploads/works/'.$slug.'.'.$image->getClientOriginalExtension();
        Image::make($image)->save(public_path($filePath));

        return $filePath;
    }

    /**
     * Save the tags for the Post.
     *
     * @param array $data
     * @param       $post
     */
    protected function saveTags(array $data, $post)
    {
        $tags = explode(',', $data['tags']);
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag, 'slug' => str_slug($tag)]);
        }
        $post->tags()->sync(Tag::whereIn('name', $tags)->pluck('id')->toArray());
    }
}
