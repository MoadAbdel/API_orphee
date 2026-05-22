<?php

namespace App\Http\Concerns;

trait GeneratesApiUrls
{
    protected function apiUrl(string $routeName, array $parameters = [], array $query = []): string
    {
        $url = request()->getSchemeAndHttpHost().route($routeName, $parameters, absolute: false);

        if ($query !== []) {
            $url .= (str_contains($url, '?') ? '&' : '?').http_build_query($query);
        }

        return $url;
    }
}
