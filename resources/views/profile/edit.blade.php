<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
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
                            <a href="{{ route('profile.edit') }}" class="dropdown-item active">
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
                <h1>Mon Profil</h1>
                <p>Gérez vos informations personnelles et vos paramètres de sécurité</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h2>👤 Paramètres du Profil</h2>
                <p class="header-subtitle">Mettez à jour vos informations personnelles</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="alert alert-success">
                <span class="alert-icon">✅</span>
                <span class="alert-message">Vos informations ont été mises à jour avec succès !</span>
            </div>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning">
                <span class="alert-icon">⚠️</span>
                <span class="alert-message">
                    Votre adresse e-mail n'est pas vérifiée. 
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="text-blue-600 underline">Cliquez ici pour renvoyer l'e-mail de vérification.</button>
                    </form>
                </span>
            </div>
            
            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success">
                    <span class="alert-icon">✅</span>
                    <span class="alert-message">Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</span>
                </div>
            @endif
        @endif

        <!-- Profile Sections -->
        <div class="profile-sections">
            <!-- Section Informations Personnelles -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h3>📋 Informations Personnelles</h3>
                    <p>Mettez à jour vos informations de profil</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="first_name">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus />
                        @error('first_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Nom</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required />
                        @error('last_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" />
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required />
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
                    </div>
                </form>
            </div>

            <!-- Section Mot de Passe -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h3>🔐 Mot de Passe</h3>
                    <p>Changez votre mot de passe pour sécuriser votre compte</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="current_password">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" autocomplete="current-password" />
                        @error('current_password', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nouveau mot de passe</label>
                        <input type="password" id="new_password" name="password" autocomplete="new-password" />
                        @error('password', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" />
                        @error('password_confirmation', 'updatePassword')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">🔒 Mettre à jour le mot de passe</button>
                    </div>
                </form>
            </div>

            <!-- Section Suppression du Compte -->
            <div class="profile-card danger-card">
                <div class="profile-card-header">
                    <h3>🗑️ Zone de Danger</h3>
                    <p>Supprimer définitivement votre compte</p>
                </div>

                <p class="danger-message">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données que vous souhaitez conserver.
                </p>

                <div class="form-actions">
                    <button type="button" class="btn btn-danger" onclick="openDeleteModal()">
                        ⚠️ Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmation de Suppression -->
    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>⚠️ Êtes-vous sûr ?</h2>
                <button type="button" class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>

            <div class="modal-body">
                <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Cette action est irréversible.</p>
                <p style="margin-top: 15px; font-weight: 500;">Veuillez entrer votre mot de passe pour confirmer :</p>

                <form method="post" action="{{ route('profile.destroy') }}" style="margin-top: 20px;">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label for="confirm_password">Mot de passe</label>
                        <input type="password" id="confirm_password" name="password" required />
                        @error('password', 'userDeletion')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
                    </div>
                </form>
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
        .profile-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .profile-card {
            background: white;
            border: 1px solid rgba(139, 92, 246, 0.1);
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.2);
        }

        .profile-card.danger-card {
            border-color: rgba(239, 68, 68, 0.2);
            background: rgba(239, 68, 68, 0.01);
        }

        .profile-card-header {
            margin-bottom: 25px;
            border-bottom: 2px solid rgba(139, 92, 246, 0.1);
            padding-bottom: 15px;
        }

        .profile-card-header h3 {
            margin: 0;
            font-size: 18px;
            color: #1a202c;
            font-weight: 600;
        }

        .profile-card-header p {
            margin: 8px 0 0 0;
            color: #718096;
            font-size: 14px;
        }

        .profile-form {
            display: grid;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .danger-message {
            color: #7f1d1d;
            background: rgba(239, 68, 68, 0.1);
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            color: #1a202c;
            font-size: 18px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #718096;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #2d3748;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body p {
            color: #4a5568;
            font-size: 14px;
            margin: 0 0 15px 0;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #166534;
        }

        .alert-warning {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.2);
            color: #92400e;
        }

        .alert-icon {
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .profile-sections {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 95%;
            }

            .modal-actions {
                flex-direction: column-reverse;
            }

            .modal-actions .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        function openDeleteModal() {
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
