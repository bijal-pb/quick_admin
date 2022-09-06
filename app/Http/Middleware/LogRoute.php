<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use App\Http\Controllers\Api\ApiLogsController;
// use Log;
use App\Models\ApiLog;
use App\Models\Setting;

class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        return $response;
    }

    public function terminate(Request $request, $response)
    {
        $setting = Setting::latest()->first();
        if($setting->api_log == 'true')
        {
            $api_log = new ApiLog;
            $api_log->method = $request->method();
            $api_log->url = $request->path();
            $api_log->payload = $this->payload($request);
            $api_log->response = $response->getContent();
            $api_log->ip = $request->ip();
            $api_log->save();
        }
    }

    protected function payload($request)
    {
        $allFields = $request->all();

        foreach (config('apilog.dont_log', []) as $key) {
            if (array_key_exists($key, $allFields)) {
                unset($allFields[$key]);
            }
        }

        return json_encode($allFields);
    }
}
