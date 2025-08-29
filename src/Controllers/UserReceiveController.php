<?php

namespace OpenSynergic\LaravelSSO\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserReceiveController extends Controller
{
    public function userReceive(Request $request)
    {
        $encoded = $request->query('data');
        $portalUrl = config('laravelsso.portal');

        if (!$encoded) {
            return response()->view('unauthorized::unauthorized', ['portalUrl' => $portalUrl]);
        }

        $decoded = json_decode(base64_decode($encoded), true);
        Log::info("Incoming User: " . $decoded['email']);

        if (!$decoded || !isset($decoded['email'])) {
            return response()->view('unauthorized::unauthorized', ['portalUrl' => $portalUrl]);
        }

        $email = $decoded['email'];
        $userDivisions = $decoded['division'] ?? [];
        $appSpecificUserEmail = [];
        $appDivisions = [];

        // Baca YAML dan tampilkan ke log
        $yamlPath = storage_path('app/private/application.yaml');
        if (file_exists($yamlPath)) {
            try {
                $yamlContent = file_get_contents($yamlPath);
                $parsedYaml = Yaml::parse($yamlContent);

                $appDivisions = Crypt::decrypt($parsedYaml['division']);
                $decryptSpecificUsers = Crypt::decrypt($parsedYaml['specific_users']);

                foreach ($decryptSpecificUsers as $user) {
                    $appSpecificUserEmail[] = $user['email'];
                }
            } catch (\Exception $e) {
                Log::error("Failed to parse YAML: " . $e->getMessage());
            }
        } else {
            Log::warning("application.yaml not found at $yamlPath");
        }

        $user = User::where('email', $email)->first();

        // --- Proses pencocokan --- //
        $intersection = array_intersect($userDivisions, $appDivisions);
        $isIncludedUser = !empty(array_intersect($appSpecificUserEmail, [$email]));

        if (($user && !empty($intersection)) || ($decoded['role'] === 'admin') || ($user && $isIncludedUser)) {
            Auth::login($user);
            Log::info("User $email logged in successfully.");
            return redirect(config('laravelsso.success_auth_redirect'));
        }

        Log::info("Access denied for user: $email");
        return response()->view('unauthorized::unauthorized', ['portalUrl' => $portalUrl]);
    }
}