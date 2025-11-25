# Laravel Blog 📝

A modern blog application built with Laravel framework as part of an academic project.

## 📋 About

This project is a full-featured blog application that demonstrates the implementation of CRUD operations, authentication, and content management using Laravel. It showcases modern web development practices with PHP and the MVC architectural pattern.

## ✨ Features

- **User Authentication**
  - User registration and login
  - Password reset functionality
  - User profile management

- **Blog Management**
  - Create, read, update, and delete blog posts
  - Rich text editor for content creation
  - Image upload for post thumbnails
  - Draft and publish functionality

- **Content Organization**
  - Categories and tags
  - Search functionality
  - Post filtering and sorting

- **User Interaction**
  - Comments system
  - Like/favorite posts
  - User dashboard

- **Admin Panel**
  - Manage all posts and users
  - Moderation tools
  - Analytics dashboard

## 🛠️ Tech Stack

- **Framework**: Laravel 10.x
- **Language**: PHP 8.1+
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade Templates, Bootstrap/Tailwind CSS
- **Authentication**: Laravel Breeze/Jetstream
- **Package Manager**: Composer

## 📦 Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or PostgreSQL >= 10
- Node.js & NPM (for frontend assets)
- Apache/Nginx web server

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/Marshall-IronSide/Blog.git
cd Blog
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install NPM dependencies

```bash
npm install
npm run dev
```

### 4. Environment setup

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure database

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run migrations and seeders

```bash
# Create database tables
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed
```

### 7. Create storage symlink

```bash
php artisan storage:link
```

### 8. Start the development server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🗂️ Project Structure

```
Blog/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
│
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
│
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
│
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
│
├── public/                  # Public assets
├── storage/                 # Application storage
└── tests/                   # Application tests
```

## 💻 Usage

### Creating a Post

1. Register or log in to your account
2. Navigate to "Create Post" from the dashboard
3. Fill in the title, content, and select categories/tags
4. Upload a featured image (optional)
5. Save as draft or publish immediately

### Managing Posts

Access your dashboard to:
- View all your posts
- Edit or delete existing posts
- Manage comments on your posts
- View post statistics

### Admin Functions

Admin users can:
- Access the admin panel at `/admin`
- Manage all users and posts
- Moderate comments
- View site analytics

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=PostTest
```

## 📚 API Documentation

If API endpoints are implemented:

### Posts API

```
GET    /api/posts           # Get all posts
GET    /api/posts/{id}      # Get single post
POST   /api/posts           # Create new post
PUT    /api/posts/{id}      # Update post
DELETE /api/posts/{id}      # Delete post
```

### Authentication

API requests require Bearer token authentication:

```bash
Authorization: Bearer {your-token}
```

## 🔒 Security

- CSRF protection enabled
- XSS protection with Blade templating
- SQL injection prevention via Eloquent ORM
- Password hashing with bcrypt
- Rate limiting on routes

## 🌐 Deployment

### Production setup

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Configure your production database
4. Run optimizations:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

5. Set proper file permissions:

```bash
chmod -R 755 storage bootstrap/cache
```

## 🚧 Roadmap

- [ ] RESTful API implementation
- [ ] Advanced search with filters
- [ ] Social media sharing integration
- [ ] Email notifications for comments
- [ ] Multi-language support
- [ ] SEO optimization features
- [ ] RSS feed generation
- [ ] Post scheduling functionality

## 🤝 Contributing

This is an academic project, but feedback and suggestions are welcome! Feel free to fork the repository for your own learning purposes.

## 👨‍💻 Author

**Marshall IronSide**
- GitHub: [@Marshall-IronSide](https://github.com/Marshall-IronSide)
- Project Link: [https://github.com/Marshall-IronSide/Blog](https://github.com/Marshall-IronSide/Blog)

## 📄 License

This project is developed for educational purposes. All rights reserved.

## 🙏 Acknowledgments

- Laravel framework and community
- Bootstrap/Tailwind CSS for UI components
- All open-source contributors

## 📞 Support

For questions or issues, please open an issue on GitHub or contact the project maintainer.

---

⭐ If you find this project helpful, please give it a star!
