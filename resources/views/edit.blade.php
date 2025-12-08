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

        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
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

            <div class="form-group">
                <label>Image bannière</label>
                @if($article->banner_image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $article->banner_image) }}" alt="{{ $article->titre }}" style="max-width: 200px; max-height: 150px; border-radius: 8px;">
                    </div>
                @endif
                <div class="file-input-wrapper">
                    <input type="file" id="banner_image" name="banner_image" accept="image/*">
                    <label for="banner_image" class="file-input-label">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <div class="file-input-text">
                            <strong>Cliquez ou glissez-déposez</strong>
                            <small>PNG, JPG, GIF jusqu'à 2MB</small>
                        </div>
                    </label>
                </div>
                <div id="file-name"></div>
                @error('banner_image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-warning">✏️ Mettre à jour</button>
                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">❌ Annuler</a>
            </div>
        </form>
    </div>

    <script>
        const fileInput = document.getElementById('banner_image');
        const fileNameDiv = document.getElementById('file-name');
        const fileLabel = document.querySelector('.file-input-label');

        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
                fileNameDiv.innerHTML = `✅ <strong>${fileName}</strong> (${fileSize} MB)`;
                fileNameDiv.classList.add('active', 'success');
            }
        });

        // Drag and drop
        fileLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileLabel.style.background = 'linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.15))';
            fileLabel.style.borderColor = 'rgba(139, 92, 246, 0.6)';
        });

        fileLabel.addEventListener('dragleave', () => {
            fileLabel.style.background = 'linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.05))';
            fileLabel.style.borderColor = 'rgba(139, 92, 246, 0.3)';
        });

        fileLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
            fileLabel.style.background = 'linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.05))';
            fileLabel.style.borderColor = 'rgba(139, 92, 246, 0.3)';
        });
    </script>
</body>
</html>