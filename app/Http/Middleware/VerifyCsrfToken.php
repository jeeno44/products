<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/categories/show',
        'api/categories/show/*',
        'api/categories/create/*',
        'api/categories/update/*',
        'api/categories/delete/*',
        'api/products/create/*',
        'api/products/update/*',
        'api/products/delete/*',
    ];
}
