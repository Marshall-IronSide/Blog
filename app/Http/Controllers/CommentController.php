<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    /**
     * Enregistrer un nouveau commentaire
     */
    public function store(Request $request, Article $article)
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour commenter.');
        }
        $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        Comment::create([
            'content' => $request->content,
            'article_id' => $article->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Commentaire ajouté avec succès !');
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Comment $comment)
    {
        // Vérifier que l'utilisateur est l'auteur du commentaire
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $article = $comment->article;
        $comment->delete();

        return redirect()->route('articles.show', $article)
            ->with('success', 'Commentaire supprimé avec succès !');
    }
}
