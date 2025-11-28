<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">
</head>
<body>
    <!-- Header Unifié avec Navbar -->
    <div class="unified-header">
            <div class="navbar-container">
                <div class="navbar-brand">
                    <h1 class="nav-title">✨ Blog</h1>
                </div>
                
                <!-- Profile section moved inside navbar -->
                <div class="navbar-profile">
                    @guest
                <div class="profile-button">
                    <div class="profile-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="profile-dropdown">
                        <a href="{{ route('login') }}" class="dropdown-item">
                            <span class="dropdown-icon">🔓</span>
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="dropdown-item">
                            <span class="dropdown-icon">📝</span>
                            Inscription
                        </a>
                    </div>
                </div>
            @endguest

            @auth
                <div class="profile-button">
                    <div class="profile-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="profile-dropdown">
                        <div class="dropdown-user">
                            {{ auth()->user()->name }}
                        </div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="dropdown-icon">👤</span>
                            Mon Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-logout">
                                <span class="dropdown-icon">🚪</span>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
                </div>
            </div>
            <div class="blog-header-content">
                <p class="blog-description">Découvrez nos derniers articles et actualités</p>
            </div>
        </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h2>📰 Liste des Articles</h2>
                <p class="header-subtitle">Gérez et consultez tous vos articles</p>
            </div>
            <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Nouvel Article</a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <span class="alert-message">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Articles Grid or Empty State -->
        @if($articles->count() > 0)
            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="article-count"><span>{{ $articles->count() }}</span> article{{ $articles->count() > 1 ? 's' : '' }}</div>
                <div class="stats-date">Dernière mise à jour: {{ now()->format('d/m/Y') }}</div>
            </div>

            <!-- Articles Grid -->
            <div class="articles-grid">
                @foreach($articles as $article)
                    <div class="article-card">
                        <div class="article-id-badge">#{{ $article->id }}</div>
                        <h3 class="article-title">{{ $article->titre }}</h3>
                        <div class="article-date">
                            📅 {{ $article->created_at->format('d/m/Y') }}
                        </div>
                        <div class="article-actions">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info" title="Voir cet article">👁️ Voir</a>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning" title="Modifier cet article">✏️ Modifier</a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Supprimer cet article">🗑️ Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📄</div>
                <h2>Aucun article disponible</h2>
                <p>Commencez par créer votre premier article pour remplir cette liste.</p>
                <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Créer un article</a>
            </div>
        @endif
    </div>
</body>
</html>