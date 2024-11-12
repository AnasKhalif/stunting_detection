<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Traits\FlashAlert;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use FlashAlert;
    use HasRolesAndPermissions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = request()->user();


        if ($user->hasRole('superadmin') || $user->isAbleTo('articles-read')) {
            $articles = Article::paginate(10);
            return view('article.index', compact('articles'));
        } else {
            return redirect()->route('dashboard')->with($this->permissionDenied());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string',],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
        $articleData = $request->all();


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('article', 'public');
            $articleData['image'] = $imagePath;
        }

        request()->user()->articles()->create($articleData);
        return redirect()->route('article.index')->with($this->alertCreated());
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $article = Article::findOrFail($id);

            if (
                request()->user()->hasRole('superadmin') ||
                request()->user()->isAbleTo('articles-update', $article) ||
                $article->user_id === request()->user()->id
            ) {
                return view('article.edit', compact('article'));
            } else {
                return redirect()->route('article.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('article.index')->with($this->alertNotFound());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            if (
                request()->user()->hasRole(['superadmin']) ||
                request()->user()->isAbleTo('articles-update', $article) ||
                $article->user_id === request()->user()->id
            ) {
                $request->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'body' => ['required', 'string'],
                    'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                ]);


                $articleData = $request->only(['title', 'body', 'published']);


                if ($request->hasFile('image')) {

                    if ($article->image) {
                        Storage::disk('public')->delete($article->image);
                    }


                    $imagePath = $request->file('image')->store('article', 'public');
                    $articleData['image'] = $imagePath;
                }

                $article->update($articleData);
                return redirect()->route('article.index')->with($this->alertUpdated());
            } else {
                return redirect()->route('article.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('article.index')->with($this->alertNotFound());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);

            if (
                request()->user()->hasRole(['superadmin']) ||
                request()->user()->isAbleTo('articles-delete', $article) ||
                $article->user_id === request()->user()->id
            ) {
                $article->delete();
                return redirect()->route('article.index')->with($this->alertDeleted());
            } else {
                return redirect()->route('article.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('article.index')->with($this->alertNotFound());
        }
    }
}
