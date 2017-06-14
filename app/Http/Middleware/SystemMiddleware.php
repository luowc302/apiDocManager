<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;
use Illuminate\Support\Facades\Request;

class SystemMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $methodList = config('options.method_to_id');
        $currentActionName = getCurrentAction()['method'];
        $settingId = '';
        foreach ($methodList as $key => $value) {
            if ($key == $currentActionName) {
                $settingId = $value;
            }
        }
        $setting = new Setting;
        $settingInfo = $setting->where(['id' => $settingId])->select(['is_used'])->get()->toArray();
        if (!empty($settingInfo)) {
            if ($settingInfo[0]['is_used'] == 0) {
                if (Request::ajax()) {
                    header('Content-type: text/json');
                    $error = json_encode(['msg' => config('options.function')[$settingId] .'已关闭', 'code' => 0]);
                    exit($error);
                } else {
                    return redirect('/shutdown');
                }
            }
        }
        return $next($request);
    }

}
