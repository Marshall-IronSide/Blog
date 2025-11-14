<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
</head>
<body>
    <div class="container">
        <h1>✍️ Créer un nouvel article</h1>

        <form action="{{ route('articles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="titre">Titre de l'article *</label>
                <input type="text" id="titre" name="titre" value="{{ old('titre') }}" placeholder="Entrez le titre de l'article">
                @error('titre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="contenu">Contenu de l'article *</label>
                <textarea id="contenu" name="contenu" placeholder="Entrez le contenu de l'article">{{ old('contenu') }}</textarea>
                @error('contenu')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-success"> Enregistrer</button>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>