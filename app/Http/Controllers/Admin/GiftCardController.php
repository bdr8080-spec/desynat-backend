<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\CommonController;
use App\Models\GiftCard;
use App\Services\GiftCardService;

 
class GiftCardController extends Controller
{

    public function __construct(GiftCardService $GiftCardService)
    {
        $this->GiftCardService = $GiftCardService;
    }

    public function giftCardManagement(Request $request){
        $giftCard = GiftCard::orderBy('id', 'desc')->get();
        return view('admin.giftcard-management.index',compact('giftCard'));
    }

    public function deleteGiftCard($id)
    {
        $giftCard = GiftCard::find($id);
        if (!$giftCard) {
            return response()->json(['success' => false, 'message' => 'Gift Card not found.']);
        }
        $giftCard->delete();
        return response()->json(['success' => true, 'message' => __('admin_messages.gift_card_category_deleted_successfully')]);
    }

    public function updateGiftCardStatus($id)
    {
        $giftCard = GiftCard::find($id);
        if (!$giftCard) {
            return response()->json(['success' => false, 'message' => 'Gift Card not found.']);
        }
        $giftCard->status = $giftCard->status == 1 ? 0 : 1;
        $giftCard->save();
        $message = $giftCard->status == 1
            ? __('admin_messages.gift_card_category_unblocked_successfully')
            : __('admin_messages.gift_card_category_blocked_successfully');

        return response()->json([
            'success' => true,
            'status' => $giftCard->status,
            'message' => $message
        ]);
    }

    public function addGiftCard(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'name_english.required' => 'Please Enter Category Name in English',
            'name_arabic.required' => 'Please Enter Category Name in Arabic',
            'image.required' => 'Please Upload an Image',
            'image.image' => 'The uploaded file must be an image',
            'image.mimes' => 'Image must be in JPEG, PNG, JPG, or GIF format',
            'image.max' => 'Image size should not exceed 5MB',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $giftCard = new GiftCard();
        $giftCard->name_english = $request->name_english;
        $giftCard->name_arabic = $request->name_arabic;

        if($request->hasFile('image')){
            // $commonController = app(CommonController::class);
            // $uploadResult = $commonController->upload($request);
            // $uploadResultArray = $uploadResult->getData(true); 

            // if ($uploadResultArray['status'] === 'error') {
            //     return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            // }

            // $imageUrl = $uploadResultArray['data']['url'];

            $imageUrl=image_upload($request->image,'giftcard/');
    
            $giftCard->image = $imageUrl; 
        }

        $giftCard->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.gift_card_category_added_successfully')]);
    }

    public function updateGiftCard(Request $request, $id)
    {
        $giftCard = GiftCard::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name_english' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $giftCard->name_english = $request->name_english;
        $giftCard->name_arabic = $request->name_arabic;

        if ($request->hasFile('image')) {

            $imageUrl=image_upload($request->image,'giftcard/');
        // $commonController = app(CommonController::class);
            // $uploadResult = $commonController->upload($request->image);
            // $uploadResultArray = $uploadResult->getData(true);
            // if ($uploadResultArray['status'] === 'error') {
            //     return response()->json(['success' => false, 'message' => $uploadResultArray['message']]);
            // }

            // $imageUrl = $uploadResultArray['data']['url'];
            $giftCard->image = $imageUrl;
        }

        $giftCard->save();

        return response()->json(['success' => true, 'message' => __('admin_messages.gift_card_category_updated_successfully')]);
    }



    



}