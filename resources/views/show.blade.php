<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->titre }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%238b5cf6'><path d='M3 3h18a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2z'/></svg>">
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
</head>
<body>
    <div class="container">
        <div class="article-header">
            <h1> {{ $article->titre }}</h1>
            <div class="meta-info">
                 Par <strong>{{ $article->user->full_name ?? 'Système' }}</strong> •
                 Publié le {{ $article->created_at->format('d/m/Y à H:i') }}
                @if($article->updated_at != $article->created_at)
                    • ✏️ Modifié le {{ $article->updated_at->format('d/m/Y à H:i') }}
                @endif
            </div>
        </div>

        @if($article->banner_image)
            <div style="margin: 20px 0;">
                <img src="{{ asset('storage/' . $article->banner_image) }}" alt="{{ $article->titre }}" style="max-width: 100%; height: auto;">
            </div>
        @endif

        <div class="article-content">
            {{ $article->contenu }}
        </div>

        @auth
            @if(Auth::id() === $article->user_id)
                <div class="button-group">
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">✏️ Modifier</a>
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑️  Supprimer</button>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Section Commentaires -->
        <div style="margin-top: 40px; border-top: 1px solid rgba(139, 92, 246, 0.3); padding-top: 40px;">
            <h2>💬 Commentaires ({{ $article->comments->count() }})</h2>

            @auth
                <div style="margin: 30px 0; padding: 24px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(59, 130, 246, 0.03)); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 16px;">
                    <form method="POST" action="{{ route('comments.store', $article) }}">
                        @csrf
                        <div class="form-group">
                            <label for="content" style="color: #e4e4e7; font-weight: 600;">Ajouter un commentaire</label>
                            <textarea id="content" name="content" placeholder="Votre commentaire..." rows="3" style="width: 100%; padding: 12px 14px; border: 2px solid rgba(139, 92, 246, 0.2); background: rgba(20, 25, 45, 0.5); color: #e4e4e7; border-radius: 12px; font-size: 15px; font-family: inherit; transition: all 0.3s ease;">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Commenter</button>
                    </form>
                </div>
            @else
                <div style="margin: 30px 0; padding: 20px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.05)); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 12px;">
                    <p style="color: #3b82f6; margin: 0;"><a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: underline;">Connectez-vous</a> pour commenter.</p>
                </div>
            @endauth

            @forelse($article->comments as $comment)
                <div style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(59, 130, 246, 0.03)); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 16px; border-left: 4px solid #8b5cf6;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <strong style="color: #e4e4e7; font-size: 16px;">{{ $comment->user->full_name ?? 'Anonyme' }}</strong>
                            <small style="color: #71717a; display: block; font-size: 13px; margin-top: 4px;">{{ $comment->created_at->format('d/m/Y à H:i') }}</small>
                        </div>
                        @auth
                            @if(Auth::id() === $comment->user_id)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce commentaire ?')" style="padding: 8px 14px; font-size: 13px;">Supprimer</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <p style="margin: 0; color: #a1a1aa; line-height: 1.6; font-size: 15px;">{{ $comment->content }}</p>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: #71717a; background: linear-gradient(135deg, rgba(139, 92, 246, 0.03), rgba(59, 130, 246, 0.02)); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 12px; margin-top: 20px;">
                    <p style="margin: 0;">Aucun commentaire pour le moment.</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('articles.index') }}" class="btn btn-primary"> Retour à la liste</a>
        </div>
    </div>
</body>
</html>