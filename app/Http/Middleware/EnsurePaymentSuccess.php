<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class EnsurePaymentSuccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionId = (string) $request->query('session_id', '');

        if ($sessionId === '') {
            return redirect()->route('feed')->with('error', 'The checkout session is missing.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);
            $isRecent = (time() - (int) $session->created) <= 86400;
            $belongsToUser = (string) ($session->metadata->user_id ?? '') === (string) $request->user()->id;

            if (
                $session->payment_status !== 'paid'
                || $session->status !== 'complete'
                || ! $isRecent
                || ! $belongsToUser
            ) {
                return redirect()->route('feed')->with('error', 'This checkout session could not be verified.');
            }

            $request->merge(['session' => $session]);

            return $next($request);
        } catch (\Throwable $exception) {
            Log::warning('Unable to verify Stripe checkout session', [
                'session_id' => $sessionId,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('feed')->with('error', 'This checkout session could not be verified.');
        }
    }
}
