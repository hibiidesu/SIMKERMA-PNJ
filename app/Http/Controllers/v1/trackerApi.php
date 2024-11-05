<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
class trackerApi extends Controller
{
    public function getKerjasama($id)
    {
        $data = Kerjasama::with('log_persetujuan', 'user')
            ->where('id', $id)
            ->get();
            //with log_persetujuan hold role_id, user_id , step call role_name from role model, call user name from user tabel and step getStep()
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'error'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
}
