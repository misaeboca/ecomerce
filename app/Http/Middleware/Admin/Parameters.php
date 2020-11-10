<?php

namespace App\Http\Middleware\Admin;

use Closure;

class Parameters
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
        $data = $request->all();

        $field = '';
        if(isset($data['search']) && $data['search'] != '') {
            $field = $data['search'];
        }

        $request->request->add(['search' => $field]);

        $field = 50;
        if(isset($data['paginate']) && intval($data['paginate']) > 50 && intval($data['paginate']) <= 200) {
            $field = intval($data['paginate']);
        }

        $request->request->add(['paginate' => $field]);

        $field = 0;
        if(isset($data['page']) && intval($data['page']) > 0) {
            $field = intval($data['page']);
        }

        $request->request->add(['page' => $field]);

        $field = 'desc';
        if(isset($data['sort']) && $data['sort'] != '' && ($data['sort'] == 'asc' || $data['sort'] == 'desc') ) {
            $field = $data['sort'];
        }

        $request->request->add(['sort' => $field]);

        $field = date("Y-m-d", strtotime("-1 week"));
        if(isset($data['from']) && $data['from'] != '' && validateDate($data['from'], $format = 'Y-m-d')) {
            $field = $data['from'];
        }

        $request->request->add(['from' => $field]);

        $field = date('Y-m-d');
        if(isset($data['until']) && $data['until'] != '' && validateDate($data['until'], $format = 'Y-m-d')) {
            $field = $data['until'];
        }

        $request->request->add(['until' => $field]);
        return $next($request);

    }

}
