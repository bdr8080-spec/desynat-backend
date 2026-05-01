<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ProductManagementService;
use App\Services\CountryService;
use App\Services\BrandService;
use App\Services\CategoryService;

 
class ProductController extends Controller
{

    public function __construct(ProductManagementService $ProductManagementService, CountryService $CountryService, BrandService $BrandService, CategoryService $CategoryService)
    {
        $this->ProductManagementService = $ProductManagementService;
        $this->CountryService = $CountryService;
        $this->BrandService = $BrandService;
        $this->CategoryService = $CategoryService;
    }

    public function productManagement(Request $request){
        $countries = $this->CountryService->getCountries()['data'];
        $brands = $this->BrandService->getBrand($request)['data'];
        $categories = $this->CategoryService->getCategory($request)['data'];
        $subcategories = $this->CategoryService->getSubCategoriesByCategoryId($request->category)['data'];
        $products = $this->ProductManagementService->getProducts($request)['data'];
        //dd($products);
        return view('admin.product-mgt.index',compact('countries','brands','categories','subcategories','products'));
    }

    public function export_products_data(Request $request)
    {
        $response = $this->ProductManagementService->getProducts($request);

        $data = $response['data'] ?? collect();

            // Handle paginator or collection
            $products = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                ? collect($data->items())
                : collect($data);

        $fileName = 'products_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        return response()->stream(function () use ($products) {

            $file = fopen('php://output', 'w');

            // UTF-8 fix
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'SR No',
                'Seller Name',
                'Country',
                'Image',
                'Category',
                'Sub Category',
                'Brand',
                'Product Name',
                'Description',
                'Specification',
                'Actual Price(KD)',
                'Size Chart',
                'Rating'
            ]);

            foreach ($products as $index => $product) {

                // Seller Name
                $sellerName = trim(
                    ($product['seller_details']['first_name'] ?? '') . ' ' .
                    ($product['seller_details']['last_name'] ?? '')
                ) ?: 'N/A';

                // Country
                $country = $product['store']['country_info']['name'] ?? 'N/A';

                // Image (first variant image)
                $image = $product['product_variants'][0]['variant_image'][0] ?? 'N/A';

                // Category
                $category = $product['category']['name'] ?? 'N/A';

                // Sub Category
                $subCategory = $product['subcategory']['name_english'] ?? 'N/A';

                // Brand
                $brand = $product['brand']['name_english'] ?? 'N/A';

                // Product Name
                $productName = $product['product_name_en'] ?? 'N/A';

                // Description
                $description = strip_tags($product['description_en'] ?? 'N/A');

                // Specification (JSON safe)
                $specification = isset($product['product_specifications'])
                    ? json_encode($product['product_specifications'], JSON_UNESCAPED_UNICODE)
                    : 'N/A';

                // Actual Price
                $actualPrice = $product['product_variants'][0]['actual_price'] ?? 'N/A';

                // Size Chart
                $sizeChart = $product['upload_size_chart'] ?? 'N/A';

                // Rating
                $rating = $product['average_rating']['product'] ?? '0';

                fputcsv($file, [
                    $index + 1,
                    $sellerName,
                    $country,
                    $image,
                    $category,
                    $subCategory,
                    $brand,
                    $productName,
                    $description,
                    $specification,
                    $actualPrice,
                    $sizeChart,
                    $rating
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }





    



}