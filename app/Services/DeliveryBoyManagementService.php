<?php
namespace App\Services;

use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyDocument;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;


class DeliveryBoyManagementService
{
   
    public function getDeliveryBoys($request)
    {
        try {
            $limit = (int)($request->input('limit'));

            $query = DeliveryBoy::with([
                'vehicle_image',
                'identity_proof',
                'driving_license',
                'vehicle_insurance',
                'pollution_paper',
                'registration_certificate',
                'zone_info',
            ]);

            if (!empty($request->from_date) && !empty($request->to_date)) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            } elseif (!empty($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif (!empty($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('full_name_english', 'like', "%{$search}%");
                });
            }

            $details = $query->orderBy('id', 'desc')->paginate($limit);

            $details->getCollection()->transform(function ($deliveryboy) {

                $data = $deliveryboy->toArray();

                $data['vehicle_image'] = empty($data['vehicle_image']) ? null : $data['vehicle_image'];
                $data['identity_proof'] = empty($data['identity_proof']) ? null : $data['identity_proof'];
                $data['driving_license'] = empty($data['driving_license']) ? null : $data['driving_license'];
                $data['vehicle_insurance'] = empty($data['vehicle_insurance']) ? null : $data['vehicle_insurance'];
                $data['pollution_paper'] = empty($data['pollution_paper']) ? null : $data['pollution_paper'];
                $data['registration_certificate'] = empty($data['registration_certificate']) ? null : $data['registration_certificate'];
                $data['zone_info'] = empty($data['zone_info']) ? null : $data['zone_info'];

                return $data;
            });

            if ($details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => 'No Delivery Boy found',
                    'data' => (object)[]
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Delivery Boy fetched successfully',
                'data' => $details
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch delivery boy: ' . $e->getMessage(),
                'data' => (object) []
            ];
        }
    }




    public function getDeliveryBoyDetailsById($deliveryBoyId)
    {
        try {
            $deliveryBoy = DeliveryBoy::with([
                'vehicle_image',
                'identity_proof',
                'driving_license',
                'vehicle_insurance',
                'pollution_paper',
                'registration_certificate',
                'zone_info',
            ])->find($deliveryBoyId);

            if (!$deliveryBoy) {
                return [
                    'status' => 'error',
                    'message' => 'Delivery Boy not found',
                    'data' => (object) []
                ];
            }

            $data = $deliveryBoy->toArray();

            $data['vehicle_image'] = empty($data['vehicle_image']) ? null : $data['vehicle_image'];
            $data['identity_proof'] = empty($data['identity_proof']) ? null : $data['identity_proof'];
            $data['driving_license'] = empty($data['driving_license']) ? null : $data['driving_license'];
            $data['vehicle_insurance'] = empty($data['vehicle_insurance']) ? null : $data['vehicle_insurance'];

            $data['pollution_paper'] = empty($data['pollution_paper']) ? null : $data['pollution_paper'];
            $data['registration_certificate'] = empty($data['registration_certificate']) ? null : $data['registration_certificate'];
            $data['zone_info'] = empty($data['zone_info']) ? null : $data['zone_info'];

            return [
                'status' => 'success',
                'message' => 'Delivery Boy details fetched successfully',
                'data' => $data
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch delivery boy details: ' . $e->getMessage(),
                'data' => (object) []
            ];
        }
    }



    public function blockUnblockDeliveryBoy($deliveryBoyId)
    {
        try {
            $deliveryboy = DeliveryBoy::find($deliveryBoyId);

            if (!$deliveryboy) {
                return [
                    'status' => 'error',
                    'message' => 'Delivery Boy not found',
                    'data' => (object)[]
                ];
            }

            $previousStatus = $deliveryboy->status; 
            $deliveryboy->status = $deliveryboy->status == 1 ? 0 : 1;
            $deliveryboy->save();

            $message = $deliveryboy->status == 1
                ? 'Delivery Boy Unblocked Successfully'
                : 'Delivery Boy blocked Successfully';

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $deliveryboy
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update delivery boy status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function deleteDeliveryBoy($deliveryBoyId)
    {
        try {
            $details = DeliveryBoy::find($deliveryBoyId);

            if (!$details) {
                return [
                    'status' => 'error',
                    'message' => 'Delivery Boy not found',
                    'data' => (object)[]
                ];
            }
            $details->delete();

            return [
                'status' => 'success',
                'message' => 'Delivery Boy deleted successfully',
                'data' => []
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to delete delivery Boy',
                'data' => (object)[]
            ];
        }
    }

    














}
    