<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\BlogArticleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreateBlogArticleRequest;
use App\Http\Requests\AdminPanel\UpdateBlogArticleRequest;
use App\Models\AdminPanel\BlogArticle;
use Illuminate\Http\Request;

class BlogArticleController extends Controller
{
    public function index(BlogArticleDataTable $datatable)
    {
        return $datatable->render('admin-panel.articles.index');
    }

    public function store(CreateBlogArticleRequest $request, BlogArticle $article)
    {
        // save
    }

    public function update(UpdateBlogArticleRequest $request, BlogArticle $article)
    {
        // update
    }

    public function delete(Request $request, BlogArticle $article)
    {
        // delete
    }
}
