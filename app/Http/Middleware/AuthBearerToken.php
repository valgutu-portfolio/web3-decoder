<?php

namespace App\Http\Middleware;

use App\Http\DTO\ErrorJsonResponse;
use App\Repositories\Clients\Contracts\ClientRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBearerToken
{
    public function __construct(private ClientRepository $clientRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientResponse = $this->clientRepository->findByToken($request->bearerToken());

        if (400 === $clientResponse->getStatusCode()) {
            return new ErrorJsonResponse(403, ['error' => 'Not Authorized']);
        }

        $request->setUserResolver(function () use ($clientResponse) {
            return $clientResponse->getData();
        });

        return $next($request);
    }
}
