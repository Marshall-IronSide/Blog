<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = Article::with('user')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Liste des articles récupérée avec succès',
            'data' => ArticleResource::collection($articles),
            'pagination' => [
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'from' => $articles->firstItem(),
                'to' => $articles->lastItem(),
            ]
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'user_id' => ['nullable', 'exists:users,id']
        ], [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'contenu.required' => 'Le contenu est obligatoire',
            'banner_image.image' => 'Le fichier doit être une image',
            'banner_image.max' => 'L\'image ne peut pas dépasser 2 Mo',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'titre' => $request->titre,
                'contenu' => $request->contenu,
                'user_id' => $request->user_id ?? null
            ];

            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')
                    ->store('banniere_images', 'public');
            }

            $article = Article::create($data);
            $article->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Article créé avec succès',
                'data' => new ArticleResource($article)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Article $article): JsonResponse
    {
        $article->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Article récupéré avec succès',
            'data' => new ArticleResource($article)
        ], 200);
    }

    public function update(Request $request, Article $article): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'user_id' => ['nullable', 'exists:users,id']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'titre' => $request->titre,
                'contenu' => $request->contenu
            ];

            if ($request->has('user_id')) {
                $data['user_id'] = $request->user_id;
            }

            if ($request->hasFile('banner_image')) {
                if ($article->banner_image) {
                    Storage::disk('public')->delete($article->banner_image);
                }
                $data['banner_image'] = $request->file('banner_image')
                    ->store('banniere_images', 'public');
            }

            $article->update($data);
            $article->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Article mis à jour avec succès',
                'data' => new ArticleResource($article)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            if ($article->banner_image) {
                Storage::disk('public')->delete($article->banner_image);
            }

            $article->delete();

            return response()->json([
                'success' => true,
                'message' => 'Article supprimé avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'article',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
