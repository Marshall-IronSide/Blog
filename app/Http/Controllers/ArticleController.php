<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
    return view('index', compact('articles')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|max:255',
            'contenu' => 'required'
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'contenu.required' => 'Le contenu est obligatoire'
        ]);

        Article::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu
        ]);


        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);
    return view('show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
    return view('edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titre' => 'required|max:255',
            'contenu' => 'required'
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'contenu.required' => 'Le contenu est obligatoire'
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu
        ]);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}
