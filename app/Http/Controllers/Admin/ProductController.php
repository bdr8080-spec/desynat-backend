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

        $products = ($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
            ? collect($data->items())
            : collect($data);

        $fileName = 'products_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $locale = app()->getLocale();

        return response()->stream(function () use ($products, $locale) {

            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            /* =========================
            HEADERS EN / AR
            ========================= */

            $headersEn = [
                'SR No',
                'Seller Name',
                'Country',
                'Image',
                'Category',
                'Sub Category',
                'Brand',
                'Product Name',
                'Description',
                //'Specification',
                'Actual Price (KD)',
                'Size Chart',
                'Rating'
            ];

            $headersAr = [
                'الرقم',
                'اسم البائع',
                'الدولة',
                'الصورة',
                'الفئة',
                'الفئة الفرعية',
                'العلامة التجارية',
                'اسم المنتج',
                'الوصف',
                //'المواصفات',
                'السعر (دينار)',
                'مخطط المقاسات',
                'التقييم'
            ];

            fputcsv($file, $locale == 'ar' ? $headersAr : $headersEn);

            $na = $locale == 'ar' ? 'غير متوفر' : 'N/A';

            foreach ($products as $index => $product) {

                /* Seller */
                $sellerName = trim(
                    ($product['seller_details']['first_name'] ?? '') . ' ' .
                    ($product['seller_details']['last_name'] ?? '')
                ) ?: $na;

                /* Country */
                $country = $product['store']['country_info'] ?? null;

                $countryName = $country
                    ? ($locale == 'ar'
                        ? ($country['name_ar'] ?? $country['name'] ?? $na)
                        : ($country['name'] ?? $na))
                    : $na;

                /* Image */
                $image = $product['product_variants'][0]['variant_image'][0] ?? $na;

                /* Category */
                $category = $product['category'] ?? null;

                $categoryName = $category
                    ? ($locale == 'ar'
                        ? ($category['name_ar'] ?? $category['name'] ?? $na)
                        : ($category['name'] ?? $na))
                    : $na;

                /* Sub Category */
                $subCategory = $product['subcategory'] ?? null;

                $subCategoryName = $subCategory
                    ? ($locale == 'ar'
                        ? ($subCategory['name_arabic'] ?? $subCategory['name_english'] ?? $na)
                        : ($subCategory['name_english'] ?? $na))
                    : $na;

                /* Brand */
                $brand = $product['brand'] ?? null;

                $brandName = $brand
                    ? ($locale == 'ar'
                        ? ($brand['name_arabic'] ?? $brand['name_english'] ?? $na)
                        : ($brand['name_english'] ?? $na))
                    : $na;

                /* Product Name */
                $productName = $locale == 'ar'
                    ? ($product['product_name_ar'] ?? $product['product_name_en'] ?? $na)
                    : ($product['product_name_en'] ?? $na);

                /* Description */
                $description = strip_tags(
                    $locale == 'ar'
                        ? ($product['description_ar'] ?? $product['description_en'] ?? $na)
                        : ($product['description_en'] ?? $na)
                );

                /* Specification */
                $specification = isset($product['product_specifications'])
                    ? json_encode($product['product_specifications'], JSON_UNESCAPED_UNICODE)
                    : $na;

                /* Price */
                $actualPrice = $product['product_variants'][0]['actual_price'] ?? $na;

                /* Size Chart */
                $sizeChart = $product['upload_size_chart'] ?? $na;

                /* Rating */
                $rating = $product['average_rating']['product'] ?? '0';

                /* CSV ROW */
                fputcsv($file, [
                    $index + 1,
                    $sellerName,
                    $countryName,
                    $image,
                    $categoryName,
                    $subCategoryName,
                    $brandName,
                    $productName,
                    $description,
                   // $specification,
                    $actualPrice,
                    $sizeChart,
                    $rating
                ]);
            }

            fclose($file);

        }, 200, $headers);
    }





    



}