<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article</title>
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
</head>
<body>
    <div class="container">
        <h1>✏️ Modifier l'article</h1>

        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titre">Titre de l'article *</label>
                <input type="text" id="titre" name="titre" value="{{ old('titre', $article->titre) }}" placeholder="Entrez le titre de l'article">
                @error('titre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contenu">Contenu de l'article *</label>
                <textarea id="contenu" name="contenu" placeholder="Entrez le contenu de l'article">{{ old('contenu', $article->contenu) }}</textarea>
                @error('contenu')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-warning"> Mettre à jour</button>
                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>