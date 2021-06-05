<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Twilio\Security\RequestValidator;

class TwilioRequestValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $requestValidator = new RequestValidator(getenv('TWILIO_AUTH_TOKEN'));

      $requestData = $request->toArray();

      if (array_key_exists('bodySHA256', $requestData)) {
        $requestData = $request->getContent();
      }

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        // Have tested with ngrok, but cannot use this validator at the same time as the URL will be ngrok's not Twilio's. Need Message's Sid to spoof URL... 
        // 'https://api.twilio.com/2010-04-01/Accounts/' . getenv('TWILIO_ACCOUNT_SID') . '/Messages/{Message Sid}/Media.json',
        $requestData
      );

      if ($isValid) {
        return $next($request);
      } else {
        // only value that does not match is the url.
        info($request->header('X-Twilio-Signature'));
        info($request->fullUrl());
        info(print_r($requestData, true));
        
        return new Response('You are not Twilio :(', 403);
      }
    }
}