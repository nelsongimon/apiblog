<?php

namespace App\Http\Controllers;

use App\Article;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return $this->responseCollection($articles);
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
           'title' => 'required',
           'body'  => 'required'
        ]);

        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();

        return $this->successResponse('El artículo se ha creado con éxito', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //$article = Article::findOrFail($id);
        return $this->responseObject($article);
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
        $request->validate([
            'title' => 'min:3',
            'body'  => 'min:5'
        ]);

        $article = Article::findOrFail($id);

        if ($request->has('title')){
            $article->title = $request->title;
        }
        if ($request->has('body')){
            $article->body = $request->body;
        }
        if($article->isClean()){
            return $this->errorResponse('no ha modificado ningun valor', 422);
        }

        $article->save();
        return $this->successResponse('Se ha modificado el artículo con éxito', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return $this->successResponse('Se ha eliminado el artículo', 204);
    }
}
