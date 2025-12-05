<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(10);
        return view('index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour créer un article.');
        }
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour créer un article.');
        }

        $request->validate([
            'titre' => 'required|max:255',
            'contenu' => 'required',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'contenu.required' => 'Le contenu est obligatoire'
        ]);

        $data = [
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'user_id' => Auth::id()
        ];

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('banniere_images', 'public');
        }

        Article::create($data);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load(['user', 'comments.user']);
        return view('show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté.');
        }

        // Vérifier que l'utilisateur est l'auteur
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée. Vous ne pouvez modifier que vos propres articles.');
        }

        return view('edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Article $article, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté.');
        }

        // Vérifier que l'utilisateur est l'auteur
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée. Vous ne pouvez modifier que vos propres articles.');
        }

        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $data = [
            'titre' => $request->titre,
            'contenu' => $request->contenu
        ];

        if ($request->hasFile('banner_image')) {
            if ($article->banner_image) {
                Storage::disk('public')->delete($article->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('banniere_images', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article, Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté.');
        }

        // Vérifier que l'utilisateur est l'auteur
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée. Vous ne pouvez supprimer que vos propres articles.');
        }

        // Supprimer l'image si elle existe
        if ($article->banner_image) {
            Storage::disk('public')->delete($article->banner_image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}
