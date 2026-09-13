<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockQueueController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\DiscountTypeController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DosageFormController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\DrugClassification\DrugClassificationController;
use App\Http\Controllers\NotificationController;


// === REDIRECT ROOT TO LOGIN ===
Route::get('/', function () {
    return redirect('/login');
});

// === PUBLIC ROUTES (accessible kahit di naka-login) ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Change from public to protected - only admins can access
Route::middleware(['auth', 'permission:create users'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'submitForgotPassword'])->name('forgot.password.submit');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'submitResetPassword'])->name('reset.password.submit');

// ========== OTP VERIFICATION ROUTES (NO AUTH REQUIRED) ==========
Route::get('/verify-otp', [OtpController::class, 'showVerificationForm'])->name('otp.verify');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify.post');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

// ==============Add this line after OTP routes=============
Route::get('/verify-otp/link', [OtpController::class, 'verifyWithLink'])->name('otp.verify.link');

// ========== TRUSTED DEVICES ROUTES (AUTH REQUIRED) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/trusted-devices', [OtpController::class, 'trustedDevices'])->name('trusted-devices.index');
    Route::delete('/trusted-devices/{deviceId}', [OtpController::class, 'removeDevice'])->name('trusted-devices.remove');
    Route::post('/trusted-devices/clear-all', [OtpController::class, 'clearAllDevices'])->name('trusted-devices.clear-all');
});

// ============= PROTECTED ROUTES (only for logged-in users) ===============
Route::middleware('auth')->group(function () {

    // =======================Dashboard=========================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ================Dashboard aliases para sa iba't ibang roles=====================
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/cashier/dashboard', [DashboardController::class, 'index'])->name('cashier.dashboard');
    Route::get('/pharmacist/dashboard', [DashboardController::class, 'index'])->name('pharmacist.dashboard');
    Route::get('/assistant/dashboard', [DashboardController::class, 'index'])->name('assistant.dashboard');

    // ========== USER & ACCESS MANAGEMENT ROUTES ==========
    
    // ===========User & Access Dashboard===============
    Route::get('/user-access', [UserController::class, 'index'])
        ->middleware('permission:view users')
        ->name('user-access.index');

    // ==============User Management================
    
    Route::resource('users', UserController::class);
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/edit-data', [UserController::class, 'editData'])->name('users.edit-data');
    Route::get('/users/deleted', [UserController::class, 'deleted'])->name('users.deleted');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // ==============Role Management================
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{id}/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions');

    // ========== CUSTOM PERMISSIONS ROUTES ==========
    Route::get('/permissions/data', [PermissionController::class, 'getPermissionsData'])->name('permissions.data');
    Route::get('/permissions/list', [PermissionController::class, 'getPermissionsList'])->name('permissions.list');

    //===============Permission Management============
    Route::resource('permissions', PermissionController::class);

    // ========== INVENTORY ROUTES ==========
    Route::middleware(['permission:view inventory|view inventory read only'])->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/item/{id}', [InventoryController::class, 'show'])->name('inventory.show');
        Route::get('/inventory/batch/{id}', [InventoryController::class, 'getBatch']);
        Route::get('/inventory/batch/{id}/edit', [InventoryController::class, 'editBatch'])->name('inventory.batch.edit');
        Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
        Route::get('/inventory/fetch-tab', [InventoryController::class, 'fetchTab'])->name('inventory.fetch-tab');
    });

    Route::middleware(['permission:view inventory'])->group(function () {
        Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
        Route::get('/inventory/{id}/edit-data', [InventoryController::class, 'getProductForEdit'])->name('inventory.edit-data');
        Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
        Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::post('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update.post');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
        Route::post('/inventory/{id}/deduct', [InventoryController::class, 'deduct'])->name('inventory.deduct');
        // ========== Supports both POST and PUT========
        Route::match(['post', 'put'], '/inventory/update-batch/{batchId}', [InventoryController::class, 'updateBatch'])->name('inventory.batch.update');
    });

    // ========== CATEGORIES ROUTES ==========
    Route::middleware(['permission:view categories'])->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/categories-json', [CategoryController::class, 'getCategories'])->name('categories.json');
    });

    // ========== POS ROUTES ==========
    Route::middleware(['permission:view pos'])->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/search-prescription', [PosController::class, 'searchPrescription'])->name('pos.search-prescription');
        Route::get('/pos/get-prescription/{id}', [PosController::class, 'getPrescription'])->name('pos.get-prescription');
        Route::get('/pos/find-by-barcode/{barcode}', [PosController::class, 'findByBarcode'])->name('pos.find-by-barcode');
    });

    // ========== PROMOS ROUTES ==========
    Route::middleware(['permission:view promos'])->group(function () {
        Route::get('/promos', [PromoController::class, 'index'])->name('promos.index');
        Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
        Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
        Route::get('/promos/{promo}/edit', [PromoController::class, 'edit'])->name('promos.edit');
        Route::put('/promos/{promo}', [PromoController::class, 'update'])->name('promos.update');
        Route::delete('/promos/{promo}', [PromoController::class, 'destroy'])->name('promos.destroy');
    });

    // ========== DISCOUNT TYPES ROUTES ==========
    Route::middleware(['permission:view discounts'])->group(function () {
        Route::get('/discount-types', [DiscountTypeController::class, 'index'])->name('discount-types.index');
        Route::post('/discount-types', [DiscountTypeController::class, 'store'])->name('discount-types.store');
        Route::put('/discount-types/{discountType}', [DiscountTypeController::class, 'update'])->name('discount-types.update');
        Route::delete('/discount-types/{discountType}', [DiscountTypeController::class, 'destroy'])->name('discount-types.destroy');
    });

    // ========== STOCK QUEUE ROUTES ==========
    Route::post('/stock-queue/{id}/transfer', [StockQueueController::class, 'transfer'])->name('stock-queue.transfer');
    Route::delete('/stock-queue/{id}', [StockQueueController::class, 'destroy'])->name('stock-queue.destroy');

    // ========== RECEIPTS ROUTES ==========
    Route::middleware(['permission:view receipts'])->group(function () {
        Route::get('/receipts', [ReceiptsController::class, 'index'])->name('receipts.index');
        Route::get('/receipts/{id}/print', [ReceiptsController::class, 'printReceipt'])->name('receipts.print');
    });

    // ========== SALES & REPORTS ROUTES ==========
    Route::prefix('sales-reports')->middleware('permission:view sales reports')->group(function () {
        Route::get('/', [SalesReportController::class, 'index'])->name('sales-reports.index');
        Route::get('/export', [SalesReportController::class, 'export'])->name('sales-reports.export');
        Route::get('/print', [SalesReportController::class, 'print'])->name('sales-reports.print');
    });

    // ========== INVENTORY REPORT ROUTE ==========
    Route::get('/inventory/report', [InventoryReportController::class, 'index'])->name('inventory.report');

    // ========== INVENTORY REPORT ROUTES ==========
    Route::middleware(['auth', 'permission:view inventory reports'])->group(function () {
        Route::get('/inventory/report', [InventoryReportController::class, 'index'])->name('inventory.report');
        Route::get('/inventory/report/print', [InventoryReportController::class, 'print'])->name('inventory.report.print');
        Route::get('/inventory/report/export', [InventoryReportController::class, 'export'])->name('inventory.report.export');
    });

    // ========== SETTINGS ROUTES ==========
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/update', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/profile', [SettingsController::class, 'profile'])->name('settings.profile');
        Route::post('/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        
        // ✅ REDIRECT old settings activity logs to new personal logs
        Route::get('/activity-logs', function() {
            return redirect()->route('activity-logs.personal');
        })->name('settings.activity-logs');
        
        Route::post('/activity-logs/filter', [SettingsController::class, 'filterActivityLogs'])->name('settings.activity-logs.filter');
    });

    // ========== ACTIVITY LOGS ROUTES ==========
    // ✅ Personal logs (for all users - no permission required)
    Route::prefix('activity-logs')->middleware('auth')->group(function () {
        Route::get('/personal', [ActivityLogController::class, 'personalLogs'])->name('activity-logs.personal');
    });
    
    // ✅ All logs (Admin only - requires permission)
    Route::prefix('activity-logs')->middleware(['auth', 'permission:view logs'])->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/data', [ActivityLogController::class, 'getData'])->name('activity-logs.data');
        Route::post('/filter', [ActivityLogController::class, 'filter'])->name('activity-logs.filter');
        Route::get('/export-preview', [ActivityLogController::class, 'exportPreview'])->name('activity-logs.export-preview');
        Route::get('/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::get('/stats', [ActivityLogController::class, 'getStats'])->name('activity-logs.stats');
        Route::post('/clear-old', [ActivityLogController::class, 'clearOld'])->name('activity-logs.clear-old');
        Route::delete('/{id}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
    });

    // ========== PRESCRIPTIONS ROUTES ==========
    Route::middleware(['auth', 'permission:view prescriptions'])->group(function () {
        Route::resource('prescriptions', PrescriptionController::class);
        Route::get('prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])->name('prescriptions.print');
        Route::put('prescriptions/{prescription}/cancel', [PrescriptionController::class, 'cancel'])->name('prescriptions.cancel');
        Route::get('/prescriptions/search', [PrescriptionController::class, 'search'])->name('prescriptions.search');
        Route::get('/prescriptions/get/{id}', [PrescriptionController::class, 'getPrescription'])->name('prescriptions.get');
    });

    // ========== USER ROLE & PERMISSION MANAGEMENT ==========
    Route::post('/users/{id}/sync-roles', [UserController::class, 'syncRoles'])->name('users.sync-roles');
    Route::post('/users/{id}/sync-permissions', [UserController::class, 'syncPermissions'])->name('users.sync-permissions');

    // ========== USER DOCUMENTS ==========
    Route::post('/users/upload-documents', [UserController::class, 'uploadDocuments'])->name('users.upload-documents');

    // ========== BARCODE ROUTES ==========
    Route::prefix('barcodes')->group(function () {
        Route::post('/generate', [App\Http\Controllers\BarcodeController::class, 'generate'])->name('barcodes.generate');
        Route::get('/image/{barcode}', [App\Http\Controllers\BarcodeController::class, 'image'])->name('barcodes.image');
        Route::get('/print-labels', [App\Http\Controllers\BarcodeController::class, 'printLabelsForm'])->name('barcodes.print-labels');
        Route::post('/print-labels', [App\Http\Controllers\BarcodeController::class, 'printLabels'])->name('barcodes.print-labels.post');
        Route::get('/print-receipt/{saleId}', [App\Http\Controllers\BarcodeController::class, 'printReceiptWithBarcode'])->name('barcodes.print-receipt');
    });

    // ========== DOSAGE FORMS ROUTES ==========
    Route::middleware(['auth', 'permission:view inventory'])->group(function () {
        Route::get('/dosage-forms', [DosageFormController::class, 'index'])->name('dosage-forms.index');
        Route::get('/dosage-forms/create', [DosageFormController::class, 'create'])->name('dosage-forms.create');
        Route::post('/dosage-forms', [DosageFormController::class, 'store'])->name('dosage-forms.store');
        Route::get('/dosage-forms/{dosageForm}', [DosageFormController::class, 'show'])->name('dosage-forms.show');
        Route::get('/dosage-forms/{dosageForm}/edit', [DosageFormController::class, 'edit'])->name('dosage-forms.edit');
        Route::put('/dosage-forms/{dosageForm}', [DosageFormController::class, 'update'])->name('dosage-forms.update');
        Route::delete('/dosage-forms/{dosageForm}', [DosageFormController::class, 'destroy'])->name('dosage-forms.destroy');
        Route::post('dosage-forms/{dosageForm}/toggle-status', [DosageFormController::class, 'toggleStatus'])->name('dosage-forms.toggle-status');
        Route::get('dosage-forms/get/all', [DosageFormController::class, 'getDosageForms'])->name('dosage-forms.get');
    });

    // ========== BACKUP ROUTES ==========
    Route::prefix('backup')->middleware(['auth', 'role:Admin'])->group(function () {
        Route::post('/settings', [App\Http\Controllers\BackupController::class, 'saveSettings'])->name('backup.settings');
        Route::post('/create', [App\Http\Controllers\BackupController::class, 'createBackup'])->name('backup.create');
        Route::get('/status', [App\Http\Controllers\BackupController::class, 'getStatus'])->name('backup.status');
    });

    // ========== DRUG CLASSIFICATION ROUTES ==========
    Route::middleware(['auth', 'permission:view drug classifications'])->group(function () {
        Route::get('/drug-classification', [DrugClassificationController::class, 'index'])->name('drug-classification.index');
        Route::get('/drug-classification/create', [DrugClassificationController::class, 'create'])->name('drug-classification.create');
        Route::post('/drug-classification', [DrugClassificationController::class, 'store'])->name('drug-classification.store');
        Route::get('/drug-classification/{drugClassification}', [DrugClassificationController::class, 'show'])->name('drug-classification.show');
        Route::get('/drug-classification/{drugClassification}/edit', [DrugClassificationController::class, 'edit'])->name('drug-classification.edit');
        Route::put('/drug-classification/{drugClassification}', [DrugClassificationController::class, 'update'])->name('drug-classification.update');
        Route::delete('/drug-classification/{drugClassification}', [DrugClassificationController::class, 'destroy'])->name('drug-classification.destroy');
    });
    
    // ========== Notification Routes ==========
Route::prefix('notifications')->middleware('auth')->group(function () {
    Route::post('/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

    // ========== DOWNLOAD RESUME ==========
    Route::get('/download/resume/{id}', function($id) {
        $user = App\Models\User::findOrFail($id);
        
        if (!$user->resume || !file_exists(storage_path('app/public/' . $user->resume))) {
            abort(404, 'Resume not found');
        }
        
        return response()->download(storage_path('app/public/' . $user->resume));
    })->middleware(['auth'])->name('download.resume');

    // ========== LOGOUT ==========
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========== SCHEDULER ==========
    Schedule::command('stock:auto-transfer')->everyFiveMinutes();

    // ========== TEST ROUTE (optional) ==========
    Route::get('/test-transfer/{id}', function ($id) {
        try {
            $stockQueue = \App\Models\StockQueue::find($id);

            if (!$stockQueue) {
                return "StockQueue not found!";
            }

            echo "<h2>StockQueue Data:</h2>";
            echo "<pre>";
            print_r($stockQueue->toArray());
            echo "</pre>";

            echo "<h2>Checking Product:</h2>";
            if ($stockQueue->product_id) {
                $product = \App\Models\Product::find($stockQueue->product_id);
                echo "Product Found: " . ($product ? $product->name : 'NO');
            } else {
                echo "No product_id in queue";
            }

            echo "<h2>Checking ProductBatch Model:</h2>";
            echo "Model exists: " . (class_exists('App\Models\ProductBatch') ? 'YES' : 'NO');

            echo "<h2>Test Creating Batch:</h2>";
            try {
                $batch = \App\Models\ProductBatch::create([
                    'product_id' => 1,
                    'quantity' => 10,
                    'pieces_per_box' => 100,
                    'pieces_left' => 1000,
                    'total_pieces' => 1000,
                    'expiry_date' => '2025-12-31',
                    'arrival_date' => now(),
                    'batch_number' => 'TEST-' . time(),
                ]);
                echo "Batch created successfully! ID: " . $batch->id;
            } catch (\Exception $e) {
                echo "Error creating batch: " . $e->getMessage();
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    });
});