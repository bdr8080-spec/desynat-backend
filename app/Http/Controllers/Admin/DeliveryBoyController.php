<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyDocument;
use App\Http\Controllers\CommonController;
use App\Services\DeliveryBoyManagementService;

 
class DeliveryBoyController extends Controller
{
    public function __construct(DeliveryBoyManagementService $DeliveryBoyManagementService)
    {
        $this->DeliveryBoyManagementService = $DeliveryBoyManagementService;
    }

    public function deliveryBoyManagement(Request $request){
        $deliveryBoys = $this->DeliveryBoyManagementService->getDeliveryBoys($request)['data'];
       // dd($deliveryBoys);
        return view('admin.delivery-boy-management.index',compact('deliveryBoys'));
    }

    public function deliveryboy_reg_step1(Request $request){
        $zones = $this->DeliveryBoyManagementService->getKuwaitZones($request)['data'];
        //dd($zones);
        return view('admin.delivery-boy-management.reg_step1',compact('zones'));
    }

    public function deliveryboy_reg_step2(Request $request){
        return view('admin.delivery-boy-management.reg_step2');
    }

    public function edit_deliveryboy_step1(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step1');
    }

    public function edit_deliveryboy_step2(Request $request){
        return view('admin.delivery-boy-management.edit_reg_step2');
    }

    public function change_deliveryboy_status($id)
    {
        $data = $this->DeliveryBoyManagementService->blockUnblockDeliveryBoy($id);

        if ($data['status'] == 'success') {
            $statusText = $data['data']->status == 1 ? 'Activated' : 'Deactivated';
  
            return response()->json([
                'success' => true,
                'status' => $data['data']->status,
                // 'message' => "Delivery Boy has been {$statusText} Successfully!"
                'message' => $data['message']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $data['message']
            ], 400); 
        }
    }


    public function deleteDeliveryBoy($id)
    {
        $result = $this->DeliveryBoyManagementService->deleteDeliveryBoy($id);

        if ($result['status'] === 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result['message']
        ], 200);
    }
    



}