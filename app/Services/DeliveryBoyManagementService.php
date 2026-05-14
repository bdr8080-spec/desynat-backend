<?php
namespace App\Services;

use App\Models\DeliveryBoy;
use App\Models\DeliveryBoyDocument;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;

use Illuminate\Support\Facades\Hash;
use DB;


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

            //  Date filter
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

            // Search filter
            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('full_name_english', 'like', "%{$search}%");
                });
            }

            $query->orderBy('id', 'desc');


            if ($limit > 0) {

                $details = $query->paginate($limit);

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

            } else {

                $details = $query->get()->map(function ($deliveryboy) {

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
            }

            if ($details->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
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
                'data' => (object)[]
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
                    'message' => __('Service_messages.no_data_found'),
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
                ? __('Service_messages.delivery_boy_unblocked_successfully')
                : __('Service_messages.delivery_boy_blocked_successfully');

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
            DeliveryBoyDocument::where('delivery_boy_id', $details->id)->delete();
            $details->delete();

            return [
                'status' => 'success',
                'message' => __('Service_messages.delivery_boy_deleted_successfully'),
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

    public function addDeliveryBoy(Request $request)
    {
        try {
            DB::beginTransaction();

            $deliveryBoy = new DeliveryBoy();
            $deliveryBoy->profile_pic = $request->profile_pic; 
            $deliveryBoy->full_name_english = $request->full_name_english;
            $deliveryBoy->full_name_arabic = $request->full_name_arabic;
            $deliveryBoy->email = $request->email;
            $deliveryBoy->country_code = $request->country_code;
            $deliveryBoy->mobile = $request->mobile;
            $deliveryBoy->password = Hash::make($request->password); 
            $deliveryBoy->unhashed_password = $request->password;
            $deliveryBoy->address_line1 = $request->address_line1;
            $deliveryBoy->address_line2 = $request->address_line2;
            $deliveryBoy->city = $request->city;
            $deliveryBoy->state = $request->state;
            $deliveryBoy->let = $request->let;
            $deliveryBoy->long = $request->long;
            $deliveryBoy->zone_id = $request->zone_id;
            $deliveryBoy->vehicle_name = $request->vehicle_name;
            $deliveryBoy->vehicle_reg_no = $request->vehicle_reg_no;
            $deliveryBoy->save();

            $documents = [
                ['document' => 'vehicle_image_front', 'doc_type' => 1, 'is_front' => 1],
                ['document' => 'vehicle_image_back', 'doc_type' => 1],
                ['document' => 'identity_proof_front', 'doc_type' => 2, 'is_front' => 1],
                ['document' => 'identity_proof_back', 'doc_type' => 2],
                ['document' => 'driving_license_front', 'doc_type' => 3, 'is_front' => 1],
                ['document' => 'driving_license_back', 'doc_type' => 3],
                ['document' => 'vehicle_insurance', 'doc_type' => 4],
                ['document' => 'pollution_paper', 'doc_type' => 5],
                ['document' => 'registration_certificate_front', 'doc_type' => 6, 'is_front' => 1],
                ['document' => 'registration_certificate_back', 'doc_type' => 6],
            ];

            $documentsInserted = 0;

            foreach ($documents as $doc) {
                $field = $doc['document'];

                if (!empty($request->$field)) {

                    DeliveryBoyDocument::create([
                        'delivery_boy_id' => $deliveryBoy->id,
                        'document_type' => $doc['doc_type'],
                        'document_path' => $request->$field,
                        'is_front' => $doc['is_front'] ?? 0,
                    ]);

                    $documentsInserted++;
                }
            }

            if ($documentsInserted > 0) {
                $deliveryBoy->document_information = 1;
                $deliveryBoy->save();
            }

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('Service_messages.delivery_boy_added_successfully'),
                'data' => $deliveryBoy
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to add delivery boy: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateDeliveryBoy(Request $request)
    {
        try {
            DB::beginTransaction();

            $deliveryBoy = DeliveryBoy::find($request->delivery_boy_id);

            if (!$deliveryBoy) {
                return [
                    'status' => 'error',
                    'message' => 'Delivery Boy not found',
                    'data' => (object)[]
                ];
            }

            // Update all fields directly
            $deliveryBoy->profile_pic = $request->profile_pic;
            $deliveryBoy->full_name_english = $request->full_name_english;
            $deliveryBoy->full_name_arabic = $request->full_name_arabic;
            $deliveryBoy->email = $request->email;
            $deliveryBoy->country_code = $request->country_code;
            $deliveryBoy->mobile = $request->mobile;
            $deliveryBoy->password = Hash::make($request->password);
            $deliveryBoy->unhashed_password = $request->password;
            $deliveryBoy->address_line1 = $request->address_line1;
            $deliveryBoy->address_line2 = $request->address_line2;
            $deliveryBoy->city = $request->city;
            $deliveryBoy->state = $request->state;
            $deliveryBoy->let = $request->let;
            $deliveryBoy->long = $request->long;
            $deliveryBoy->zone_id = $request->zone_id;
            $deliveryBoy->vehicle_name = $request->vehicle_name;
            $deliveryBoy->vehicle_reg_no = $request->vehicle_reg_no;
            $deliveryBoy->save();

            // Remove old documents
            DeliveryBoyDocument::where('delivery_boy_id', $deliveryBoy->id)->delete();

            // Insert fresh documents
            $documents = [
                ['field' => 'vehicle_image_front', 'doc_type' => 1, 'is_front' => 1],
                ['field' => 'vehicle_image_back', 'doc_type' => 1],
                ['field' => 'identity_proof_front', 'doc_type' => 2, 'is_front' => 1],
                ['field' => 'identity_proof_back', 'doc_type' => 2],
                ['field' => 'driving_license_front', 'doc_type' => 3, 'is_front' => 1],
                ['field' => 'driving_license_back', 'doc_type' => 3],
                ['field' => 'vehicle_insurance', 'doc_type' => 4],
                ['field' => 'pollution_paper', 'doc_type' => 5],
                ['field' => 'registration_certificate_front', 'doc_type' => 6, 'is_front' => 1],
                ['field' => 'registration_certificate_back', 'doc_type' => 6]
            ];

            //dd($documents);

            foreach ($documents as $doc) {
                $field = $doc['field'];

                if (!empty($request->$field)) {

                    DeliveryBoyDocument::create([
                        'delivery_boy_id' => $deliveryBoy->id,
                        'document_type' => $doc['doc_type'],
                        'document_path' => $request->$field,
                        'is_front' => $doc['is_front'] ?? 0,
                    ]);

                }
            }

            $updatedDocuments = DeliveryBoyDocument::where('delivery_boy_id', $deliveryBoy->id)->get();

            DB::commit();

            return [
                'status'  => 'success',
                'message' => __('Service_messages.delivery_boy_updated_successfully'),
                'data'    => [
                    'delivery_boy' => $deliveryBoy,
                    'documents' => $updatedDocuments
                ]
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to update delivery boy: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function getKuwaitZones()
    {
        try {

            $query = Zone::where('country_id', 1)->orderBy('id','desc')->get();

            if ($query->isEmpty()) {
                return [
                    'status' => 'success',
                    'message' => __('Service_messages.no_data_found'),
                    'data' =>  []
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Zones fetched successfully',
                'data' => $query
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch zones: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function updateDeliveryBoyProfileExceptDocument(Request $request)
    {
        try {

            $deliveryBoy = DeliveryBoy::find($request->delivery_boy_id);

            if (!$deliveryBoy) {
                return [
                    'status' => 'error',
                    'message' => 'Delivery Boy not found',
                    'data' => (object)[]
                ];
            }

            $deliveryBoy->profile_pic = $request->profile_pic;
            $deliveryBoy->full_name_english = $request->full_name_english;
            $deliveryBoy->full_name_arabic = $request->full_name_arabic;
            $deliveryBoy->email = $request->email;
            $deliveryBoy->country_code = $request->country_code;
            $deliveryBoy->mobile = $request->mobile;
            // $deliveryBoy->password = Hash::make($request->password);
            // $deliveryBoy->unhashed_password = $request->password;
            $deliveryBoy->address_line1 = $request->address_line1;
            $deliveryBoy->address_line2 = $request->address_line2;
            $deliveryBoy->city = $request->city;
            $deliveryBoy->state = $request->state;
            $deliveryBoy->let = $request->let;
            $deliveryBoy->long = $request->long;
            $deliveryBoy->zone_id = $request->zone_id;
            // $deliveryBoy->vehicle_name = $request->vehicle_name;
            // $deliveryBoy->vehicle_reg_no = $request->vehicle_reg_no;
            $deliveryBoy->save();

            return [
                'status'  => 'success',
                'message' => __('Service_messages.profile_updated_successfully'),
                'data'    => $deliveryBoy
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Failed to update delivery boy: ' . $e->getMessage(),
                'data' => (object)[]
            ];
        }
    }

    public function dutyOnOff($deliveryBoyId)
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

            $previousDutyStatus = $deliveryboy->on_duty; 
            $deliveryboy->on_duty = $deliveryboy->on_duty == 1 ? 0 : 1;
            $deliveryboy->save();

            $message = $deliveryboy->on_duty == 1
                ? __('Service_messages.setting_changed_to_on_duty_successfully')
                : __('Service_messages.setting_changed_to_off_duty_successfully');

            return [
                'status' => 'success',
                'message' => $message,
                'data' => $deliveryboy
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed to update delivery boy duty status: ' . $e->getMessage(),
                'data' => []
            ];
        }
    }




    














}
    