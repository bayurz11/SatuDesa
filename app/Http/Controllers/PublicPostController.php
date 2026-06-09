<?php

namespace App\Http\Controllers;

use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Services\VisitTrackerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $category = trim((string) $request->string('category'));

        $baseQuery = Post::query()
            ->with(['author:id,name', 'category:id,name,slug'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', '%' . $search . '%')
                        ->orWhere('excerpt', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                });
            })
            ->when($category !== '', function ($query) use ($category) {
                $query->whereHas('category', function ($categoryQuery) use ($category) {
                    $categoryQuery->where('slug', $category);
                });
            })
            ->orderByDesc('published_at');

        $featuredPost = (clone $baseQuery)
            ->where('is_featured', true)
            ->first();

        $posts = (clone $baseQuery)
            ->when($featuredPost, function ($query) use ($featuredPost) {
                $query->where('id', '!=', $featuredPost->id);
            })
            ->paginate(4)
            ->withQueryString();

        $categories = PostCategory::query()
            ->whereHas('posts', function ($query) {
                $query->where('status', 'published')->whereNotNull('published_at');
            })
            ->withCount([
                'posts as published_posts_count' => function ($query) {
                    $query->where('status', 'published')->whereNotNull('published_at');
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $latestPosts = (clone $baseQuery)
            ->limit(3)
            ->get();

        return view('pages.public.posts.index', compact(
            'posts',
            'categories',
            'featuredPost',
            'latestPosts',
            'search',
            'category'
        ));
    }

    public function show(Request $request, string $slug): View
    {
        $post = Post::query()
            ->with(['author:id,name', 'category:id,name,slug'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('slug', $slug)
            ->firstOrFail();

        VisitTrackerService::trackPostView($request, $post);

        $relatedPosts = Post::query()
            ->with(['category:id,name,slug'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function ($query) use ($post) {
                $query->where('category_id', $post->category_id);
            })
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.public.posts.show', compact('post', 'relatedPosts'));
    }
}
