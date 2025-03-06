<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\VehicleInfoController as AdminVehicleInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{
    /**
     * عرض صفحة فحص السيارة
     */
    public function showCheckCarPage()
    {
        return view('admin.check_car');
    }


    /**
     * فحص معلومات السيارة والقطع المتوافقة (مسار API عام)
     */
    public function checkVehicleInfo(Request $request)
    {
        // لضمان قبول طلبات JSON فقط
        if (!$request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن يكون الطلب بتنسيق JSON'
            ], 400);
        }

        // التحقق من صحة البيانات
        $request->validate([
            'vin' => 'required|string|min:17|max:17',
        ]);

        $vin = $request->vin;

        try {
            // 1. الاتصال بـ API خارجي للحصول على معلومات السيارة
            $vehicleInfo = $this->fetchVehicleInfoFromExternalApi($vin);



            // 3. تجهيز البيانات للإرجاع
            $response = [
                'success' => true,
                'vehicle_info' => $vehicleInfo,

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
        // الاتصال بـ API
        $response = Http::get("https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/{$vin}?format=json");

        if ($response->successful()) {
            $data = $response->json();

            // للتصحيح - طباعة جميع المتغيرات الموجودة في الاستجابة لمعرفة الأسماء الصحيحة
            $allVariables = [];
            foreach ($data['Results'] as $result) {
                $allVariables[$result['Variable']] = $result['Value'];
            }

            // استخدام أسماء المتغيرات الصحيحة وتوفير قيم بديلة
            $vehicleInfo = [
                'make' => $this->extractValueByVariableName($data, 'Make') ?: 'غير معروف',
                'model' => $this->extractValueByVariableName($data, 'Model') ?: 'غير معروف',
                'year' => $this->extractValueByVariableName($data, 'Model Year') ?:
                        $this->extractValueByVariableName($data, 'ModelYear') ?: 'غير معروف',
                'engine' => $this->buildEngineDescription($data),
                'transmission' => $this->extractValueByVariableName($data, 'Transmission Style') ?:
                                 $this->extractValueByVariableName($data, 'TransmissionStyle') ?: 'غير معروف',
                'drive_type' => $this->extractValueByVariableName($data, 'Drive Type') ?:
                               $this->extractValueByVariableName($data, 'DriveType') ?: 'غير معروف',
                'fuel_type' => $this->extractValueByVariableName($data, 'Fuel Type - Primary') ?:
                              $this->extractValueByVariableName($data, 'FuelTypePrimary') ?: 'غير معروف',
                'body_style' => $this->extractValueByVariableName($data, 'Body Class') ?:
                               $this->extractValueByVariableName($data, 'BodyClass') ?: 'غير معروف',
                'all_variables' => $allVariables // مفيد للتصحيح
            ];

            return $vehicleInfo;
        }

        throw new \Exception('فشل في الحصول على معلومات السيارة من API الخارجي');
    }

    /**
     * بناء وصف المحرك بشكل أفضل
     */
    private function buildEngineDescription($data)
    {
        $engineConfig = $this->extractValueByVariableName($data, 'Engine Configuration') ?:
                       $this->extractValueByVariableName($data, 'EngineConfiguration') ?: '';

        $displacement = $this->extractValueByVariableName($data, 'Displacement (L)') ?:
                       $this->extractValueByVariableName($data, 'DisplacementL') ?: '';

        $cylinders = $this->extractValueByVariableName($data, 'Engine Number of Cylinders') ?:
                    $this->extractValueByVariableName($data, 'EngineNumberOfCylinders') ?: '';

        $enginePower = $this->extractValueByVariableName($data, 'Engine Power (HP)') ?:
                      $this->extractValueByVariableName($data, 'EnginePower') ?: '';

        $description = [];

        if (!empty($engineConfig)) {
            $description[] = $engineConfig;
        }

        if (!empty($displacement)) {
            $description[] = $displacement . 'L';
        }

        if (!empty($cylinders)) {
            $description[] = $cylinders . ' أسطوانات';
        }

        if (!empty($enginePower)) {
            $description[] = $enginePower . ' حصان';
        }

        return !empty($description) ? implode(' - ', $description) : 'غير معروف';
    }


        /**
     * استخراج قيمة محددة من استجابة NHTSA API مع إضافة المزيد من المرونة
     */
    private function extractValueByVariableName($data, $variableName)
    {
        if (isset($data['Results'])) {
            foreach ($data['Results'] as $result) {
                if ($result['Variable'] === $variableName && !empty($result['Value']) && $result['Value'] !== 'Not Applicable') {
                    return $result['Value'];
                }
            }
        }

        return null;
    }

    /**
     * طباعة جميع المتغيرات المتاحة في الاستجابة - مفيد للتصحيح
     */
    private function getAllAvailableVariables($data)
    {
        $variables = [];
        if (isset($data['Results'])) {
            foreach ($data['Results'] as $result) {
                if (!empty($result['Value']) && $result['Value'] !== 'Not Applicable') {
                    $variables[$result['Variable']] = $result['Value'];
                }
            }
        }
        return $variables;
    }

}
