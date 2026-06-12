<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $search = trim((string) $request->string('q'));
        $category = trim((string) $request->string('category'));

        $routeName = match ($category) {
            'pengumuman' => 'public.announcements.index',
            'potensi' => 'public.potentials.index',
            'umkm' => 'public.businesses.index',
            'apbdesa' => 'public.budgets.index',
            'layanan' => 'public.services.index',
            'penduduk' => 'public.population.index',
            'berita', '' => 'public.posts.index',
            default => 'public.posts.index',
        };

        return redirect()->route($routeName, array_filter([
            'q' => $search !== '' ? $search : null,
        ]));
    }
}
