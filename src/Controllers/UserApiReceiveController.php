<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserApiReceiveController extends Controller
{
    public function index()
    {
        $apiUrl = config('laravelsso.portal') . '/api/users';
        $apiToken = config('laravelsso.api_token'); // Simpan ini di file .env untuk keamanan

        $response = Http::withToken($apiToken)->acceptJson()->get($apiUrl);

        $users = [];
        if ($response->successful()) {
            $users = $response->json('data', []); // Ambil array 'data', default ke array kosong jika tidak ada
        }
        // Kirim data user ke view
        return response()->json($users);
    }
}