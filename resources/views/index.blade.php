<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
</head>
<body>
    <div class="container">
        <h1> Liste des Articles</h1>

        <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Nouvel Article</a>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($articles->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->titre }}</td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info"> Voir</a>
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning">✏️ Modifier</a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"> Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-articles">
                <p>Aucun article disponible. Commencez par en créer un !</p>
            </div>
        @endif
    </div>
</body>
</html>