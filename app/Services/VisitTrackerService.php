<?php

namespace App\Services;

use App\Domains\Analytics\Models\PostView;
use App\Domains\Analytics\Models\WebsiteVisit;
use App\Domains\Post\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class VisitTrackerService
{
    public const VISITOR_COOKIE = 'satudesa_visitor';
    public const DEDUPE_MINUTES = 30;

    public static function trackWebsiteVisit(Request $request): void
    {
        if (! self::shouldTrack($request)) {
            return;
        }

        $visitorToken = self::ensureVisitorToken($request);
        $visitedAt = now();

        $existingVisit = WebsiteVisit::query()
            ->where('visitor_token', $visitorToken)
            ->where('path', '/' . ltrim($request->path(), '/'))
            ->where('visited_at', '>=', $visitedAt->copy()->subMinutes(self::DEDUPE_MINUTES))
            ->exists();

        if ($existingVisit) {
            return;
        }

        WebsiteVisit::create([
            'visitor_token' => $visitorToken,
            'session_id' => $request->session()->getId(),
            'path' => '/' . ltrim($request->path(), '/'),
            'url' => $request->fullUrl(),
            'referer' => $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'visited_at' => $visitedAt,
        ]);
    }

    public static function trackPostView(Request $request, Post $post): void
    {
        if (! self::shouldTrack($request)) {
            return;
        }

        $visitorToken = self::ensureVisitorToken($request);
        $viewedAt = now();

        $existingView = PostView::query()
            ->where('post_id', $post->id)
            ->where('visitor_token', $visitorToken)
            ->where('viewed_at', '>=', $viewedAt->copy()->subMinutes(self::DEDUPE_MINUTES))
            ->exists();

        if ($existingView) {
            return;
        }

        PostView::create([
            'post_id' => $post->id,
            'visitor_token' => $visitorToken,
            'session_id' => $request->session()->getId(),
            'referer' => $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'viewed_at' => $viewedAt,
        ]);
    }

    public static function ensureVisitorToken(Request $request): string
    {
        $existingToken = (string) $request->cookie(self::VISITOR_COOKIE);

        if ($existingToken !== '') {
            return $existingToken;
        }

        $token = (string) Str::uuid();

        Cookie::queue(
            cookie(
                self::VISITOR_COOKIE,
                $token,
                60 * 24 * 365 * 2,
                '/',
                null,
                app()->environment('production'),
                false,
                false,
                'Lax'
            )
        );

        return $token;
    }

    protected static function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson()) {
            return false;
        }

        return ! self::isBot((string) $request->userAgent());
    }

    protected static function isBot(string $userAgent): bool
    {
        if ($userAgent === '') {
            return false;
        }

        return (bool) preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|monitor/i', $userAgent);
    }
}
