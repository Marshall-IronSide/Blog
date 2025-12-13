<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
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
                <a href="{{ route('articles.index') }}" class="nav-link">
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
                <h1>Tableau de bord</h1>
                <p>Bienvenue, {{ Auth::user()->full_name ?? Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                    <div style="width: 40px; height: 40px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" style="width: 24px; height: 24px;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h2>Informations du profil</h2>
                </div>
                <p class="header-subtitle">Aperçu de votre compte et vos informations personnelles</p>
            </div>
        </div>

        <!-- Dashboard Card -->
        <div class="dashboard-card">
            <!-- Avatar Section -->
            <div class="dashboard-avatar-section">
                <img class="dashboard-avatar" 
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name) }}&color=8b5cf6&background=f3e8ff&font-size=0.5" 
                     alt="{{ Auth::user()->name }}">
                <span class="avatar-status">✓</span>
            </div>

            <!-- User Info Section -->
            <div class="dashboard-info">
                <h2 class="dashboard-name">{{ Auth::user()->full_name ?? Auth::user()->name }}</h2>
                <p class="dashboard-email">{{ Auth::user()->email }}</p>
            </div>

            <!-- Stats Grid -->
            <div class="dashboard-stats">
                <div class="stat-item">
                    <span class="stat-label">Membre depuis</span>
                    <span class="stat-value">{{ Auth::user()->created_at->format('M Y') }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Statut du compte</span>
                    <span class="stat-badge">Actif</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Dernière connexion</span>
                    <span class="stat-value">{{ now()->format('d M Y') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="dashboard-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-gradient">
                    ⚙️ Modifier le profil
                </a>
                <a href="{{ route('articles.index') }}" class="btn btn-info">
                    📰 Liste des articles
                </a>
            </div>
        </div>

        <!-- Quick Stats Section -->
        <div class="quick-stats-section">
            <h3>📈 Statistiques rapides</h3>
            
            <div class="stats-grid">
                <div class="stats-card">
                    <div class="stats-card-icon">📝</div>
                    <div class="stats-card-content">
                        <h4>Vos articles</h4>
                        <p class="stats-card-value">{{ Auth::user()->articles()->count() }}</p>
                        <a href="{{ route('articles.index') }}" class="stats-card-link">Voir tous →</a>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card-icon">💬</div>
                    <div class="stats-card-content">
                        <h4>Commentaires reçus</h4>
                        <p class="stats-card-value">{{ Auth::user()->comments()->count() }}</p>
                        <a href="{{ route('articles.index') }}" class="stats-card-link">Consulter →</a>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-card-icon">⭐</div>
                    <div class="stats-card-content">
                        <h4>Total articles + comments</h4>
                        <p class="stats-card-value">{{ Auth::user()->articles()->count() + Auth::user()->comments()->count() }}</p>
                        <a href="{{ route('articles.index') }}" class="stats-card-link">Détails →</a>
                    </div>
                </div>
            </div>
        </div>
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

    <style>
        .dashboard-card {
            background: white;
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.2);
        }

        .dashboard-avatar-section {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .dashboard-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(139, 92, 246, 0.2);
            object-fit: cover;
        }

        .avatar-status {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 28px;
            height: 28px;
            background: #22c55e;
            border: 3px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .dashboard-name {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin: 15px 0 5px 0;
        }

        .dashboard-email {
            color: #718096;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 25px 0;
            padding: 20px 0;
            border-top: 1px solid rgba(139, 92, 246, 0.1);
            border-bottom: 1px solid rgba(139, 92, 246, 0.1);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            color: #718096;
            font-size: 13px;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            color: #1a202c;
            font-size: 16px;
            font-weight: 600;
        }

        .stat-badge {
            background: rgba(34, 197, 94, 0.1);
            color: #166534;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .dashboard-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .dashboard-actions .btn {
            min-width: 200px;
        }

        .quick-stats-section {
            margin-top: 40px;
        }

        .quick-stats-section h3 {
            font-size: 18px;
            color: #1a202c;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stats-card {
            background: white;
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 8px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stats-card:hover {
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.2);
            transform: translateY(-2px);
        }

        .stats-card-icon {
            font-size: 32px;
            min-width: 50px;
            text-align: center;
        }

        .stats-card-content {
            flex: 1;
        }

        .stats-card-content h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .stats-card-value {
            margin: 0;
            font-size: 28px;
            color: #1a202c;
            font-weight: 700;
        }

        .stats-card-link {
            display: inline-block;
            margin-top: 8px;
            font-size: 12px;
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .stats-card-link:hover {
            color: #7c3aed;
        }

        @media (max-width: 768px) {
            .dashboard-card {
                padding: 20px;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .dashboard-actions {
                flex-direction: column;
            }

            .dashboard-actions .btn {
                min-width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>