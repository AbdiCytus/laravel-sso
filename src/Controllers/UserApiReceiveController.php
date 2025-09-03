<?php

namespace OpenSynergic\LaravelSSO\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UserApiReceiveController extends Controller
{
    public function users($id = null)
    {
        if ($id) {
            $param = '/api/users/' . $id;
            $defaultData = null;
        } else {
            $param = '/api/users';
            $defaultData = [];
        }

        $apiUrl = config('laravelsso.portal') . $param;
        $apiToken = config('laravelsso.api_token');

        $response = Http::withToken($apiToken)->acceptJson()->get($apiUrl);

        $data = $defaultData;
        if ($response->successful()) {
            $data = $response->json('data', $defaultData);
        }

        if ($response->notFound()) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json($data);
    }
}