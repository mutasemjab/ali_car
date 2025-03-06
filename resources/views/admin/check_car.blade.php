<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>فحص السيارة - نظام قطع الغيار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .main-container {
            max-width: 1200px;
            margin: 30px auto;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .card-header {
            background-color: #3f51b5;
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 15px 20px;
        }
        .form-control {
            padding: 12px;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #3f51b5;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #303f9f;
        }
        .vehicle-info-card {
            border-right: 4px solid #3f51b5;
            background-color: #fff;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .vehicle-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .part-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .part-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .part-card img {
            height: 150px;
            object-fit: cover;
            background-color: #f5f5f5;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3f51b5;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .result-section {
            display: none;
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-car me-2"></i> فحص معلومات السيارة وقطع الغيار المتوافقة</h3>
            </div>
            <div class="card-body">
                <form id="vinForm" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="vin" class="form-label">رقم الشاسيه (VIN)</label>
                                <input type="text" class="form-control" id="vin" name="vin"
                                       placeholder="أدخل رقم الشاسيه المكون من 17 حرف"
                                       required minlength="17" maxlength="17">
                                <div class="form-text">رقم الشاسيه موجود عادةً في المستندات الرسمية للسيارة أو على لوحة معدنية في مقدمة السيارة.</div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                <i class="fas fa-search me-2"></i> فحص السيارة
                            </button>
                        </div>
                    </div>
                </form>

                <div id="error-container" class="alert alert-danger" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i> <span id="error-message"></span>
                </div>

                <div id="loader" class="text-center" style="display: none;">
                    <div class="loader"></div>
                    <p class="mt-2">جاري البحث عن معلومات السيارة...</p>
                </div>

                <!-- قسم نتائج معلومات السيارة -->
                <div id="vehicle-info-container" class="result-section mt-4">
                    <h4 class="mb-4"><i class="fas fa-info-circle me-2"></i> معلومات السيارة</h4>
                    <div class="card vehicle-info-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">الماركة</div>
                                    <div id="vehicle-make" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">الموديل</div>
                                    <div id="vehicle-model" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">سنة الصنع</div>
                                    <div id="vehicle-year" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">نوع الوقود</div>
                                    <div id="vehicle-fuel" class="fs-5">-</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">المحرك</div>
                                    <div id="vehicle-engine" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">ناقل الحركة</div>
                                    <div id="vehicle-transmission" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">نوع الدفع</div>
                                    <div id="vehicle-drive-type" class="fs-5">-</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-label">نوع الهيكل</div>
                                    <div id="vehicle-body-style" class="fs-5">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- قسم قطع الغيار المتوافقة -->
                <div id="parts-container" class="result-section mt-5">
                    <h4 class="mb-4"><i class="fas fa-cogs me-2"></i> قطع الغيار المتوافقة</h4>
                    <div id="parts-list" class="row">
                        <!-- سيتم إضافة القطع بشكل ديناميكي هنا -->
                    </div>
                </div>

                <!-- قسم لا توجد قطع متوافقة -->
                <div id="no-parts-container" class="result-section mt-4" style="display: none;">
                    <div class="alert alert-warning">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vinForm = document.getElementById('vinForm');
            const loader = document.getElementById('loader');
            const errorContainer = document.getElementById('error-container');
            const errorMessage = document.getElementById('error-message');
            const vehicleInfoContainer = document.getElementById('vehicle-info-container');
            const partsContainer = document.getElementById('parts-container');
            const noPartsContainer = document.getElementById('no-parts-container');
            const partsList = document.getElementById('parts-list');

            // الحصول على CSRF token بطريقة صحيحة
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            vinForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const vin = document.getElementById('vin').value.trim();

                if (vin.length !== 17) {
                    showError('رقم الشاسيه يجب أن يتكون من 17 حرف');
                    return;
                }

                // إخفاء أي رسائل خطأ سابقة ونتائج
                hideError();
                hideResults();

                // إظهار المؤشر الدوار
                loader.style.display = 'block';

                // إرسال الطلب إلى API
                fetchVehicleInfo(vin);
            });

            function fetchVehicleInfo(vin) {
                // استخدام مسار /api/vehicle/check للطلب
                fetch('{{ route("api.vehicle.check") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ vin: vin })
                })
                .then(response => {
                    // التحقق من نوع الاستجابة
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('الاستجابة ليست بتنسيق JSON صالح');
                    }
                    return response.json();
                })
                .then(data => {
                    // إخفاء المؤشر الدوار
                    loader.style.display = 'none';

                    if (data.success) {
                        // عرض معلومات السيارة
                        displayVehicleInfo(data.vehicle_info);

                        // عرض قطع الغيار المتوافقة
                        if (data.compatible_parts && data.compatible_parts.length > 0) {
                            displayCompatibleParts(data.compatible_parts);
                            partsContainer.style.display = 'block';
                            noPartsContainer.style.display = 'none';
                        } else {
                            partsContainer.style.display = 'none';
                            noPartsContainer.style.display = 'block';
                        }
                    } else {
                        showError(data.message || 'حدث خطأ غير معروف');
                    }
                })
                .catch(error => {
                    loader.style.display = 'none';
                    showError('حدث خطأ أثناء الاتصال بالخادم: ' + error.message);
                    console.error('خطأ في الطلب:', error);
                });
            }

            function displayVehicleInfo(vehicleInfo) {
                // تعبئة معلومات السيارة
                document.getElementById('vehicle-make').textContent = vehicleInfo.make || 'غير معروف';
                document.getElementById('vehicle-model').textContent = vehicleInfo.model || 'غير معروف';
                document.getElementById('vehicle-year').textContent = vehicleInfo.year || 'غير معروف';
                document.getElementById('vehicle-fuel').textContent = vehicleInfo.fuel_type || 'غير معروف';
                document.getElementById('vehicle-engine').textContent = vehicleInfo.engine || 'غير معروف';
                document.getElementById('vehicle-transmission').textContent = vehicleInfo.transmission || 'غير معروف';
                document.getElementById('vehicle-drive-type').textContent = vehicleInfo.drive_type || 'غير معروف';
                document.getElementById('vehicle-body-style').textContent = vehicleInfo.body_style || 'غير معروف';

                // إظهار جميع المتغيرات المتاحة للتصحيح (يمكن إزالته لاحقاً)
                if (vehicleInfo.all_variables) {
                    showDebugInfo(vehicleInfo.all_variables);
                }

                // إظهار قسم معلومات السيارة
                vehicleInfoContainer.style.display = 'block';
            }

            // دالة لعرض جميع المتغيرات المتاحة للتصحيح
            function showDebugInfo(allVariables) {
                // التحقق من وجود قسم التصحيح وإنشائه إذا لم يكن موجوداً
                let debugContainer = document.getElementById('debug-container');
                if (!debugContainer) {
                    debugContainer = document.createElement('div');
                    debugContainer.id = 'debug-container';
                    debugContainer.className = 'mt-4 p-3 border rounded bg-light';
                    debugContainer.innerHTML = '<h5>جميع البيانات المتاحة من API (للتصحيح):</h5><div id="debug-content" class="small"></div>';

                    // إضافة القسم بعد قسم معلومات السيارة
                    document.getElementById('vehicle-info-container').after(debugContainer);
                }

                // إظهار جميع المتغيرات
                const debugContent = document.getElementById('debug-content');
                let debugHTML = '<table class="table table-sm table-striped"><thead><tr><th>المتغير</th><th>القيمة</th></tr></thead><tbody>';

                for (const [key, value] of Object.entries(allVariables)) {
                    debugHTML += `<tr><td>${key}</td><td>${value}</td></tr>`;
                }

                debugHTML += '</tbody></table>';
                debugContent.innerHTML = debugHTML;
            }

            function displayCompatibleParts(parts) {
                // مسح أي قطع سابقة
                partsList.innerHTML = '';

                // إضافة القطع
                parts.forEach(part => {
                    const partCard = document.createElement('div');
                    partCard.className = 'col-lg-4 col-md-6 mb-4';

                    const imagePath = part.image ? part.image : '/images/part-placeholder.jpg';

                    partCard.innerHTML = `
                        <div class="card part-card h-100">
                            <img src="${imagePath}" class="card-img-top" alt="${part.name}">
                            <div class="card-body">
                                <h5 class="card-title">${part.name}</h5>
                                <p class="card-text">${part.description || ''}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold">${part.price} ريال</span>
                                    <span class="badge bg-${part.stock_quantity > 0 ? 'success' : 'danger'}">
                                        ${part.stock_quantity > 0 ? 'متوفر' : 'غير متوفر'}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <small class="text-muted">الفئة: ${part.category ? part.category.name : '-'}</small><br>
                                <small class="text-muted">الشركة المصنعة: ${part.manufacturer ? part.manufacturer.name : '-'}</small>
                            </div>
                        </div>
                    `;

                    partsList.appendChild(partCard);
                });
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorContainer.style.display = 'block';
            }

            function hideError() {
                errorContainer.style.display = 'none';
            }

            function hideResults() {
                vehicleInfoContainer.style.display = 'none';
                partsContainer.style.display = 'none';
                noPartsContainer.style.display = 'none';
            }
        });
        </script>
</body>
</html>
