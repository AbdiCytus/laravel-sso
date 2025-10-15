# Laravel SSO Client Package
## About Package
Laravel SSO is a package designed for client applications to integrate with a central portal application.
The main feature of this package is SSO (Single Sign-On), which allows client applications to authenticate users through the portal rather than through the client application directly.
## How This Package Works?
A client application that installs or uses this package will be fully authorized, meaning it cannot be accessed unless the user logs in via the portal.

When a user logs in from the portal to the client application, the portal sends a hash containing the user’s data to the client.
The client application receives this data and verifies whether the user is registered or has permission within the client app.

- If the verification succeeds, the user will be logged in automatically.
- If it fails, the page will show an Unauthorized status and then redirect back to the portal after a few seconds.

## Installation
**Requirements**

This package requires the following:
- **PHP v8.0+**
- **Laravel v10.0+**
- **Filament v3.0+**

Open your terminal and install the package via Composer:

```composer require abdicytus/laravel-sso```

Wait for the installation process to complete.
## Getting Started

Open your **.env** file and add the following environment variables:

```
SSO_PORTAL_URL=https://portal-example.com   #example
SSO_SUCCESS_AUTH_REDIRECT=/dashboard        #example
API_TOKEN=4P1t0k3n123KnfjO                  #example
```
**API_TOKEN** bisa didapatkan dari aplikasi portal setelah aplikasi client didaftarkan.
#
Next, open **App/Providers/Filament/AdminPanelProvider.php**, and import the middleware from the package:

```use OpenSynergic\LaravelSSO\Middleware\SsoRedirectMiddleware;```

Then, replace the `authMiddleware` from **`Authenticate::class`** with **`SsoRedirectMiddleware:class`**

```
->authMiddleware([
    SsoRedirectMiddleware::class
]);
```
#
To disable the SSO feature in the client application, add the following variable to your **.env** file and set its value to **false**.
This variable is optional (by default, SSO is enabled).

`ENABLE SSO=false`

## Portal API
The portal application provides several API routes that can be accessed by the client application.

To access portal user data, use the API endpoints listed below.
The base URL is the portal’s URL, and each request must include the header:
**Authorization: Bearer *token***
where ***token*** is the **API_TOKEN** you defined in your **.env** file.

Available routes:
- **[GET]** `/api/users`        — Retrieve all users from the portal
- **[GET]** `/api/user/{id} `   — Retrieve a specific user from the portal by ID
#
**Example: Fetching Data from** `/api/users`

Create a new controller, for example **UserClientController.php**, with the following content:

```
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserClientController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = config('app.services.base_url');
        $apiToken = config('app.services.api_token');
        $route = '/api/users'; // Fetch all users from the portal

        $page = $request->get('page', 1);
        $response = Http::withToken($apiToken)
            ->get($baseUrl . $route, ['page' => $page]);
        
        if($response->failed()) {
            abort(500, 'Failed to fetch data from portal')
        }

        return $reponse->json('data.data');
    }
}
```

Then, open **config/app.php**, and add the following configuration under **services**:
```
'services' => [
    'base_url' => env('SSO_PORTAL_URL'),
    'api_token' => env('API_TOKEN'),
]
```
Next, open **routes/web.php** and define a route for the controller you just created:
```
use App\Http\Controllers\UserClientController;

Route:get('/users', [UserClientController::class, 'index']);
```