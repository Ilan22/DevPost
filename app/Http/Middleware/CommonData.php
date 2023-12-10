<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Tag;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CommonData
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle($request, Closure $next)
    {
        $categories = Category::all();
        $tags = Tag::all();

        View::share(['categories'=>$categories, 'tags'=>$tags]);

        return $next($request);
    }
}
