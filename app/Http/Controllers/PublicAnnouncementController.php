<?php

namespace App\Http\Controllers;

use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Services\VisitTrackerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicAnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $category = trim((string) $request->string('category'));

        $baseQuery = Post::query()
            ->announcements()
            ->with(['author:id,name', 'category:id,name,slug'])
            ->published()
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
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at');

        $featuredAnnouncement = (clone $baseQuery)->first();

        $announcements = (clone $baseQuery)
            ->when($featuredAnnouncement, function ($query) use ($featuredAnnouncement) {
                $query->where('id', '!=', $featuredAnnouncement->id);
            })
            ->paginate(6)
            ->withQueryString();

        $categories = PostCategory::query()
            ->whereHas('posts', function ($query) {
                $query->announcements()->published();
            })
            ->withCount([
                'posts as published_posts_count' => function ($query) {
                    $query->announcements()->published();
                },
            ])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $latestAnnouncements = (clone $baseQuery)->limit(4)->get();

        return view('pages.public.announcements.index', compact(
            'announcements',
            'categories',
            'featuredAnnouncement',
            'latestAnnouncements',
            'search',
            'category'
        ));
    }

    public function show(Request $request, string $slug): View
    {
        $announcement = Post::query()
            ->announcements()
            ->with(['author:id,name', 'category:id,name,slug'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        VisitTrackerService::trackPostView($request, $announcement);

        $relatedAnnouncements = Post::query()
            ->announcements()
            ->with(['category:id,name,slug'])
            ->published()
            ->where('id', '!=', $announcement->id)
            ->when($announcement->category_id, function ($query) use ($announcement) {
                $query->where('category_id', $announcement->category_id);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.public.announcements.show', compact('announcement', 'relatedAnnouncements'));
    }
}
