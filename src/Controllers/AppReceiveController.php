<?php

namespace OpenSynergic\LaravelSSO\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

class AppReceiveController extends Controller
{
    public function appReceive(Request $request)
    {
        $data = $request->all();

        Log::info("App setting(s) update:", $data);

        // Encrypt hanya field division
        if (isset($data['division'])) {
            $data['division'] = Crypt::encrypt($data['division']);
            $data['specific_users'] = Crypt::encrypt($data['specific_users']);
        }

        // Simpan ke file YAML
        $yaml = Yaml::dump($data, 2, 4, Yaml::DUMP_OBJECT_AS_MAP);
        Storage::disk('local')->put('application.yaml', $yaml);

        return response()->json(['status' => 'ok']);
    }
}

