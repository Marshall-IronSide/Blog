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
            <a href="{{ route('articles.index') }}" class="nav-logo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 3h18a2 2 0 012 2v14a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    <path d="M3 9h18M8 13h8" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
                <span>Blog</span>
            </a>
        </div>

        <nav class="navbar-menu">
            <a href="{{ route('articles.index') }}" class="nav-link active">
                <span>📰</span> Articles
            </a>
            @auth
                <a href="{{ route('articles.create') }}" class="nav-link">
                    <span>➕</span> Créer
                </a>
            @endauth
        </nav>

        <div class="navbar-profile">
            @guest
                <div class="profile-button">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                        🔓 Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-sm">
                        📝 Inscription
                    </a>
                </div>
            @endguest

            @auth
                <div class="profile-button">
                    <div class="profile-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="profile-dropdown">
                        <div class="dropdown-user">
                            👤 {{ auth()->user()->full_name ?? auth()->user()->name }}
                        </div>
                        <hr style="border: none; border-top: 1px solid rgba(139, 92, 246, 0.2); margin: 8px 0;">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span class="dropdown-icon">⚙️</span>
                            Paramètres
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
        <div class="header-text">
            <h1>Bienvenue sur le Blog</h1>
            <p>Découvrez des articles inspirants et engageants</p>
        </div>
        @auth
            <a href="{{ route('articles.create') }}" class="btn btn-gradient">
                ✨ Écrire un article
            </a>
        @endauth
    </div>
</div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h2>📰 Liste des Articles</h2>
                <p class="header-subtitle">Gérez et consultez tous vos articles</p>
            </div>
            @auth
                <a href="{{ route('articles.create') }}" class="page-header-icon" title="Écrire un nouvel article">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </a>
            @endauth
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
                <?php $i = 0; ?>
                @foreach($articles as $article)
                    <div class="article-card">
                        @if($article->banner_image)
                            <div style="margin-bottom: 10px; border-radius: 5px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $article->banner_image) }}" alt="{{ $article->titre }}" style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                        @endif
                        <div class="article-id-badge">#{{ ++$i }}</div>
                        <h3 class="article-title">{{ $article->titre }}</h3>
                        <div class="article-date">
                            👤 {{ $article->user->full_name ?? 'Système' }} • 📅 {{ $article->created_at->format('d/m/Y') }}
                        </div>
                        <div class="article-actions">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-info" title="Voir cet article">👁️ Voir</a>
                            @auth
                                @if(Auth::id() === $article->user_id)
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning" title="Modifier cet article">✏️ Modifier</a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Supprimer cet article">🗑️ Supprimer</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div style="margin-top: 30px;">
                    {{ $articles->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">📄</div>
                <h2>Aucun article disponible</h2>
                <p>Commencez par créer votre premier article pour remplir cette liste.</p>
                @auth
                    <a href="{{ route('articles.create') }}" class="btn btn-primary">➕ Créer un article</a>
                @endauth
            </div>
        @endif
    </div>

    <!-- Footer -->
<footer class="blog-footer">
    <div class="footer-container">
        <div class="footer-section">
            <div class="footer-brand">
                <h3>✨ Blog</h3>
                <p>Découvrez des articles inspirants et engageants.</p>
            </div>
            <div class="footer-social">
                <a href="#" class="social-icon" title="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="social-icon" title="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 002.856-3.586c-1.04.585-2.189.969-3.402 1.142 1.225-1.423 2.15-3.58 2.546-5.134-1.145.689-2.408 1.184-3.754 1.456-.764-.818-1.858-1.335-3.077-1.335-2.331 0-4.22 1.889-4.22 4.22 0 .331.03.654.09.968-3.509-.175-6.621-1.857-8.704-4.416-.364.637-.57 1.382-.57 2.155 0 1.463.746 2.755 1.88 3.513-.694-.022-1.348-.201-1.92-.503v.053c0 2.047 1.457 3.753 3.393 4.141-.354.097-.731.15-1.121.15-.272 0-.541-.027-.801-.08.541 1.684 2.106 2.91 3.96 2.942-1.448 1.133-3.273 1.81-5.254 1.81-.341 0-.677-.02-1.01-.06 1.88 1.206 4.115 1.91 6.51 1.91 7.812 0 12.073-6.469 12.073-12.073 0-.184-.005-.366-.015-.543.829-.6 1.548-1.353 2.116-2.21z"/>
                    </svg>
                </a>
                <a href="#" class="social-icon" title="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="2.17" y="2.17" width="19.66" height="19.66" rx="4.58" ry="4.58" fill="none" stroke="currentColor" stroke-width="1.41"/>
                        <circle cx="12" cy="12" r="3.56" fill="none" stroke="currentColor" stroke-width="1.41"/>
                        <circle cx="18.5" cy="5.5" r="1.5" fill="currentColor"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Navigation</h4>
            <ul>
                <li><a href="{{ route('articles.index') }}">Articles</a></li>
                @auth
                    <li><a href="{{ route('articles.create') }}">Créer un article</a></li>
                    <li><a href="{{ route('profile.edit') }}">Mon profil</a></li>
                @else
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                @endauth
            </ul>
        </div>

        <div class="footer-section">
            <h4>Informations</h4>
            <ul>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Conditions d'utilisation</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Rester informé</h4>
            <p>Inscrivez-vous pour recevoir les derniers articles.</p>
            <form class="footer-newsletter">
                <input type="email" placeholder="Votre email" required>
                <button type="submit">S'abonner</button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ now()->year }} Blog. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>