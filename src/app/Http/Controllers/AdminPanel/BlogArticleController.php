<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\BlogArticleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateBlogArticleRequest;
use App\Http\Requests\AdminPanel\UpdateBlogArticleRequest;
use App\Models\AdminPanel\BlogArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogArticleController extends Controller
{
    public function index(BlogArticleDataTable $datatable)
    {
        return $datatable->render('admin-panel.articles.index');
    }

    public function edit(Request $request, BlogArticle $article)
    {
        return view('admin-panel.articles.edit', compact('article'));
    }

    public function create(Request $request)
    {
        return view('admin-panel.articles.create');
    }

    public function store(CreateBlogArticleRequest $request)
    {
        $data = $request->safe()->toArray();
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::user()->id;

        $article = BlogArticle::create($data);

        return redirect()->route('admin.articles.edit', ['article' => $article->id]);
    }

    public function update(UpdateBlogArticleRequest $request, BlogArticle $article)
    {
        $article->update($request->safe()->toArray());

        return back()->with('successfully', 'Статья была обновлена!');
    }

    public function delete(Request $request, BlogArticle $article)
    {
        $article->images()->delete();

        $article->delete();

        return response([
            'message' => 'Статья была удалена!'
        ]);
    }
}
