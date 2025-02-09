<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/get-dashboard-data', [App\Http\Controllers\HomeController::class, 'get_dashboard_data']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

/* --- patient route start --- */
Route::get('/dashboard-appointment-calendar', [App\Http\Controllers\Appointment\AppointmentController::class, 'dashboard_appointments']);
/* --- patient route end --- */


/* --- doctor route end --- */

/* --- appointment route start --- */
Route::get('/all-appointments', [App\Http\Controllers\Appointment\AppointmentController::class, 'all_appointments']);
Route::get('/create-appointment', [App\Http\Controllers\Appointment\AppointmentController::class, 'create_appointment']);
Route::get('/get-available-date', [App\Http\Controllers\Appointment\AppointmentController::class, 'get_available_date']);
Route::get('/get-available-time', [App\Http\Controllers\Appointment\AppointmentController::class, 'get_available_time']);
Route::post('/book-appointment', [App\Http\Controllers\Appointment\AppointmentController::class, 'book_appointment']);
Route::post('/update-checkedin-status', [App\Http\Controllers\Appointment\AppointmentController::class, 'update_checkedin_status']);
Route::post('/delete-appointment', [App\Http\Controllers\Appointment\AppointmentController::class, 'delete_appointment']);
Route::get('/view-appointment/{id}', [App\Http\Controllers\Appointment\AppointmentController::class, 'view_appointment']);
Route::post('/save-appointment-note', [App\Http\Controllers\Appointment\AppointmentController::class, 'save_appointment_note']);
Route::post('/delete-appointment-note', [App\Http\Controllers\Appointment\AppointmentController::class, 'delete_appointment_note']);
Route::post('/update-appointment-note', [App\Http\Controllers\Appointment\AppointmentController::class, 'update_appointment_note']);
Route::post('/update-consent-form', [App\Http\Controllers\Appointment\AppointmentController::class, 'update_consent_form']);
Route::post('/update-user-consent-form', [App\Http\Controllers\Appointment\AppointmentController::class, 'update_user_consent_form']);
Route::get('/load-appointment-notes', [App\Http\Controllers\Appointment\AppointmentController::class, 'load_appointment_notes']);
/* --- appointment route end --- */

/* --- product route start --- */
Route::get('/all-product-categoris', [App\Http\Controllers\Product\ProductController::class, 'all_product_categories']);
Route::post('/add-product-category', [App\Http\Controllers\Product\ProductController::class, 'add_product_category']);
Route::post('/update-product-category', [App\Http\Controllers\Product\ProductController::class, 'update_product_category']);
Route::get('/add-product', [App\Http\Controllers\Product\ProductController::class, 'add_product']);
Route::post('/save-product', [App\Http\Controllers\Product\ProductController::class, 'save_product']);
Route::get('/all-products', [App\Http\Controllers\Product\ProductController::class, 'all_products']);
Route::post('/delete-product', [App\Http\Controllers\Product\ProductController::class, 'delete_product']);
Route::get('/edit-product/{id}', [App\Http\Controllers\Product\ProductController::class, 'edit_product']);
Route::post('/update-product', [App\Http\Controllers\Product\ProductController::class, 'update_product']);
Route::post('/delete-product-variation', [App\Http\Controllers\Product\ProductController::class, 'delete_product_variation']);
Route::get('/get-products-by-clinic', [App\Http\Controllers\Product\ProductController::class, 'get_products_by_clinic']);
Route::get('/product-variations/{id}', [App\Http\Controllers\Product\ProductController::class, 'getProductVariations']);
/* --- product route end --- */

/* --- quotation route start --- */
Route::get('/create-quotation/{patient_id}', [App\Http\Controllers\Quotation\QuotationController::class, 'create_quotation']);
Route::post('/generate-quotation', [App\Http\Controllers\Quotation\QuotationController::class, 'generate_quotation']);
Route::get('/all-quotations', [App\Http\Controllers\Quotation\QuotationController::class, 'all_quotations'])->name('all-quotations');
Route::post('/delete-quotation', [App\Http\Controllers\Quotation\QuotationController::class, 'delete_quotation']);
Route::get('/view-quotation/{id}', [App\Http\Controllers\Quotation\QuotationController::class, 'view_quotation']);
Route::get('/pay-quotation/{id}', [App\Http\Controllers\Quotation\QuotationController::class, 'pay_quotation']);
/* --- quotation route end --- */

/* --- payment route start --- */
Route::get('/all-invoices', [App\Http\Controllers\Payment\PaymentController::class, 'all_invoices']);
Route::get('/payment-methods', [App\Http\Controllers\Payment\PaymentController::class, 'all_payment_methods']);
Route::post('/save-payment-method', [App\Http\Controllers\Payment\PaymentController::class, 'save_payment_method']);
Route::post('/make-payment', [App\Http\Controllers\Payment\PaymentController::class, 'make_payment']);
Route::get('/stripe/checkout/success', [App\Http\Controllers\Payment\PaymentController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
Route::get('/stripe/checkout/cancel', [App\Http\Controllers\Payment\PaymentController::class, 'stripeCheckoutCancel'])->name('stripe.checkout.cancel');
Route::post('/stripe/webhook', [App\Http\Controllers\Payment\StripeWebhookController::class, 'handleStripeWebhook']);
/* --- payment route end --- */

/* --- report route start --- */
Route::get('/patient-report', [App\Http\Controllers\Report\PatientReportController::class, 'generate_patient_report']);
Route::get('/appointment-report', [App\Http\Controllers\Report\AppointmentReportController::class, 'generate_appointment_report']);
Route::get('/quotation-report', [App\Http\Controllers\Report\QuotationReportController::class, 'generate_quotation_report']);
Route::get('/invoice-report', [App\Http\Controllers\Report\InvoiceReportController::class, 'generate_invoice_report']);
/* --- report route end --- */


/*back to dashboard*/
Route::get('/autologin/{userId}/{token}', [App\Http\Controllers\Auth\LoginController::class, 'autoLogin']);




// Client sing up
Route::get('client/sing-up/{clientId}/{token}', [App\Http\Controllers\Client\ClientController::class, 'clientSingUpForm'])->name('client.singUp.form');
Route::post('client/sing-up/{clientId}', [App\Http\Controllers\Client\ClientController::class, 'clientSingUp'])->name('client.singUp');
Route::get('client/profile/{clientId}', [App\Http\Controllers\Client\ClientController::class, 'updateProfileForm'])->name('client.update.profile.form');
Route::post('client/profile-update/{clientId}', [App\Http\Controllers\Client\ClientController::class, 'updateProfile'])->name('client.update.profile');
 // Client tos
Route::get('client/tos-view/{clientId}', [App\Http\Controllers\Client\ClientController::class, 'tosView'])->name('client.tos.view');
Route::get('client/tos-view-pdf', [App\Http\Controllers\Client\ClientController::class, 'tosViewPdf'])->name('client.tos.view.pdf');
 // Route::get('client/tos/download/{clientId}', [ClientController::class, 'tosDownload'])->name('client.tos.download');
Route::post('client/tos/signature/{clientId}', [App\Http\Controllers\Client\ClientController::class, 'tosSignature'])->name('client.tos.signature');
Route::get('documents', [App\Http\Controllers\Client\DocumentController::class, 'listDocuments'])->name('client.listDocuments');
Route::get('all-dcouments', [App\Http\Controllers\Client\DocumentController::class, 'allDocuments'])->name('allDocuments');
Route::get('download-doc/{id}', [App\Http\Controllers\Client\DocumentController::class, 'downloadDoc'])->name('downloadDoc');
