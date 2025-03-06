<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\CarPart;
use App\Models\Vehicle;

class VehicleInfoController extends Controller
{
    /**
     * الحصول على معلومات السيارة بواسطة رقم الشاسيه
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicleInfoByVin(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'vin' => 'required|string|min:17|max:17',
        ]);

        $vin = $request->vin;

        try {
            // 1. الاتصال بـ API خارجي للحصول على معلومات السيارة
            $vehicleInfo = $this->fetchVehicleInfoFromExternalApi($vin);

            // 2. الحصول على القطع المتوافقة من قاعدة البيانات الخاصة بك
            $compatibleParts = $this->getCompatibleParts($vehicleInfo);

            // 3. تجهيز البيانات للإرجاع
            $response = [
                'success' => true,
                'vehicle_info' => $vehicleInfo,
                'compatible_parts' => $compatibleParts,
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * الاتصال بـ API خارجي للحصول على معلومات السيارة
     *
     * @param string $vin
     * @return array
     */
    private function fetchVehicleInfoFromExternalApi($vin)
    {
        // يمكنك استخدام خدمة مثل NHTSA API (مجانية) للحصول على بيانات أساسية
        // أو اشتراك في خدمة متخصصة مثل CarMD أو AutoDNA

        // مثال باستخدام NHTSA API (معلومات أساسية فقط)
        $response = Http::get("https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/{$vin}?format=json");

        if ($response->successful()) {
            $data = $response->json();

            // استخراج المعلومات المهمة من الاستجابة
            $vehicleInfo = [
                'make' => $this->extractValueByVariableName($data, 'Make'),
                'model' => $this->extractValueByVariableName($data, 'Model'),
                'year' => $this->extractValueByVariableName($data, 'ModelYear'),
                'engine' => $this->extractValueByVariableName($data, 'EngineConfiguration') . ' ' .
                           $this->extractValueByVariableName($data, 'DisplacementL') . 'L',
                'transmission' => $this->extractValueByVariableName($data, 'TransmissionStyle'),
                'drive_type' => $this->extractValueByVariableName($data, 'DriveType'),
                'fuel_type' => $this->extractValueByVariableName($data, 'FuelTypePrimary'),
                'body_style' => $this->extractValueByVariableName($data, 'BodyClass'),
            ];

            return $vehicleInfo;
        }

        throw new \Exception('فشل في الحصول على معلومات السيارة من API الخارجي');
    }

    /**
     * استخراج قيمة محددة من استجابة NHTSA API
     */
    private function extractValueByVariableName($data, $variableName)
    {
        if (isset($data['Results'])) {
            foreach ($data['Results'] as $result) {
                if ($result['Variable'] === $variableName && !empty($result['Value'])) {
                    return $result['Value'];
                }
            }
        }

        return null;
    }


}
