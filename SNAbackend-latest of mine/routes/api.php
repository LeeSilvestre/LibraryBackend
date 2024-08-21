<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// CONTROLLERS FOR PROFILING
use App\Http\Controllers\StudentFamilyInfoController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\StudentProfilingController;
use App\Http\Controllers\ImageController;
use App\http\Controllers\UserController;

// REGISTRAR CONTROLLERS
use App\Http\Controllers\Registrar\EnrollmentInfo;
use App\Http\Controllers\Registrar\FacultyProfile;
use App\Http\Controllers\Registrar\AlumniProfile;
use App\Http\Controllers\Registrar\StudentRecords;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\SchedulingController;

//LIBRARY CONTROLLERS
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\FacultyBorrowController;
use App\Http\Controllers\LibraryStatusController;
use App\Http\Controllers\LoggingController;
use App\Http\Controllers\RentalController;


// CLINIC
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PhysicalExaminationController;
use App\Http\Controllers\ConsultationRecordController;
use App\Http\Controllers\MedicalCertController;
use App\Http\Controllers\DentalCertController;
use App\Http\Controllers\InventoryController;

// GUIDANCE
use App\Http\Controllers\CasesController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\ConsultationArchiveController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ViolationController;

// ADMIN
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;



// INVENTORY
use App\Http\Controllers\RoomsController;
use App\Models\roomInventory;
use App\Http\Controllers\BorrowingItemsController;
use App\Http\Controllers\DamageItemController;
use App\Http\Controllers\UnusableItemController;
use App\Http\Controllers\DashboardController;
use App\Models\unusableItems;
use App\Http\Controllers\BorrowedItemController;
use App\Http\Controllers\ItemsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $user->load([
        'studentProfile.adviser',
        'studentProfile.library',
        'studentProfile.borrowed', 'studentProfile.guidance',
        'studentProfile.docreq',
        'studentProfile.schedule',
        'studentProfile.schedule.faculty',
        'studentProfile.consultation',
        'studentProfile.physical_exam'
    ]);
    // $user->load(['studentProfile.adviser', 'studentProfile.guidance', 'studentProfile.docreq']);
    return $user;
});

Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {
   $user = $request->user();
   $user->load('user');
//    $usper->studentProfile->load('adviser');
   return $user;
});



Route::post('/admin', [AdminController::class, 'createUser']);
Route::post('/loginadmin', [AdminLoginController::class, 'login']);


Route::get('getAcc', [UserController::class, 'getUsers']);


//STUDENT PROFILE HANDLNNG
Route::post('/login', [StudentLoginController::class, 'authenticate']);
Route::get('student',[StudentProfilingController::class,'index']);
Route::get('student/{id}',[StudentProfilingController::class,'indexId']);
Route::post('student',[StudentProfilingController::class,'upload']);
Route::put('student/edit/{id}',[StudentProfilingController::class,'edit']);
Route::put('create/{id}', [StudentProfilingController::class, 'createAccount']);
Route::put('student/editstat/{id}',[StudentProfilingController::class,'updateStatus']);
Route::get('getSched', [SchedulingController::class, 'getSched']);
Route::get('getSched/{id}', [SchedulingController::class, 'getSchedules']);
Route::get('getSec', [SectionsController::class, 'getSections']);

Route::post('createSched', [SchedulingController::class, 'insertSched']);
// Route::post('postSched', [SchedulingController::class, 'insertSched']);

Route::delete('student/edit/{id}',[StudentProfilingController::class,'delete']);

//STUDENT FAMILYINFO
Route::get('studentfamily',[StudentFamilyInfoController::class,'getFamilyInfo']);
Route::post('studentfamily',[StudentFamilyInfoController::class,'storeFamilyInfo']);


// STUDENT ENROLLMENT INFO
Route::get('faculty',[FacultyProfile::class,'index']);
Route::get('faculties',[FacultyProfile::class,'getFacultyNames']);
Route::get('count',[StudentRecords::class,'getCounts']);
Route::get('countGrade',[StudentRecords::class,'getGradeCounts']);



// DATA ENTRIES
Route::get('jhs',[StudentRecords::class, 'getJHS']);
Route::get('shs',[StudentRecords::class, 'getSHS']);
Route::get('alumni',[AlumniProfile::class,'index']);


// ################## POST METHODS ##################
// FACULTY PROFILE INFO
Route::post('faculty',[FacultyProfile::class,'store']);
// ALUMNI PROFILE INFO
Route::post('alumni',[AlumniProfile::class,'store']);

Route::get('docreq', [DocumentRequestController::class,'index']);
Route::get('docreq/{id}', [DocumentRequestController::class,'getDocument']);
Route::post('docreq', [DocumentRequestController::class, 'upload']);




Route::get('image', [ImageController::class, 'index']);
Route::get('image/{id}', [ImageController::class, 'show']);
Route::post('imageStud', [ImageController::class, 'storeStudIMG']);
Route::post('imageFaculty', [ImageController::class, 'storeFacultyIMG']);
Route::put('image/{id}', [ImageController::class, 'update']);

Route::prefix('library')->group(function () {
    // Borrowed Books
    Route::get('/borrowstatus/new', [BorrowedBookController::class, 'showNewestStatusId']); //check
    Route::get('/borrowstatus', [BorrowedBookController::class, 'allBorrows']); //check
    Route::post('/borrowstatus', [BorrowedBookController::class, 'createBorrowStatus']); //check
    Route::get('/borrowstatus/user/{id}', [BorrowedBookController::class, 'getAllBorrowByStudent']); //check
    Route::get('/borrowstatus/borrow/{id}', [BorrowedBookController::class, 'getAllBorrowByBorrow']); //check
    Route::put('/borrowstatus/{id}', [BorrowedBookController::class, 'updateBorrowStatus']); //check
    Route::put('/borrowstatus/damaged/{id}', [BorrowedBookController::class, 'damagedBorrowStatus']);
    Route::put('/borrowstatus/damagedpay/{id}', [BorrowedBookController::class, 'dPayBorrowStatus']);
    Route::put('/borrowstatus/lostpay/{id}', [BorrowedBookController::class, 'lPayBorrowStatus']);
    Route::put('/borrowstatus/lost/{id}', [BorrowedBookController::class, 'lostBorrowStatus']);
    Route::put('/borrowstatus/overdue/{id}', [BorrowedBookController::class, 'oPayBorrowStatus']);

    // Students Profile
    Route::get('/student', [StudentProfileController::class, 'allStudents']); //check
    Route::get('/student/{id}', [StudentProfileController::class, 'showAStudent']); //check
    Route::post('/student', [StudentProfileController::class, 'createStudentP']);
    Route::put('/student/{id}', [StudentProfileController::class, 'updateStudentP']);
    Route::delete('/student/{id}', [StudentProfileController::class, 'deleteStudentP']);

    // Books
    Route::get('/books', [BookController::class, 'allBooks']); //check
    Route::get('/books/{id}', [BookController::class, 'showABook']); //check
    Route::post('/books', [BookController::class, 'createBook']); //check
    Route::delete('/books/{id}', [BookController::class, 'deleteBookP']); //check
    Route::put('/books/{id}', [BookController::class, 'updateBookP']); //check
    Route::put('/books/archive/{id}', [BookController::class, 'archiveBook']);
    Route::put('/books/unarchive/{id}', [BookController::class, 'unarchiveBook']);

    // Categories
    Route::get('/category', [BookCategoryController::class, 'allCategory']); //check
    Route::get('/category/{id}', [BookCategoryController::class, 'showACategory']); //check
    Route::post('/category', [BookCategoryController::class, 'createCategory']); //check
    Route::delete('/category/{id}', [BookCategoryController::class, 'deleteCategory']); //check
    Route::put('/category/{id}', [BookCategoryController::class, 'updateCategory']); //check
    Route::put('/category/archive/{id}', [BookCategoryController::class, 'archiveCategory']);
    Route::put('/category/unarchive/{id}', [BookCategoryController::class, 'unarchiveCategory']);

    // Faculty Borrows
    Route::get('/faculty/borrows', [FacultyBorrowController::class, 'allFacultyBorrows']);
    Route::post('/faculty/borrows', [FacultyBorrowController::class, 'createFacultyBorrow']);
    Route::get('/faculty/borrows/{id}', [FacultyBorrowController::class, 'getFacultyBorrow']);
    Route::put('/faculty/borrows/update/{id}', [FacultyBorrowController::class, 'updateFacultyBorrowStatus']);
    Route::put('/faculty/damaged/{id}', [FacultyBorrowController::class, 'damagedFacultyBorrowStatus']);
    Route::put('/faculty/damagedpay/{id}', [FacultyBorrowController::class, 'dPayFacultyBorrowStatus']);
    Route::put('/faculty/lost/{id}', [FacultyBorrowController::class, 'lostFacultyBorrowStatus']);
    Route::put('/faculty/lostpay/{id}', [FacultyBorrowController::class, 'lPayFacultyBorrowStatus']);
    Route::put('/faculty/overdue/{id}', [FacultyBorrowController::class, 'oPayFacultyBorrowStatus']);
    Route::put('/faculty/borrows/cancel/{id}', [FacultyBorrowController::class, 'cancelFacultyBorrowStatus']);

    // Faculty
    Route::get('/faculty', [FacultyController::class, 'allFaculty']);
    Route::get('/faculty/{id}', [FacultyController::class, 'showFaculty']);
    Route::post('/faculty', [FacultyController::class, 'createFaculty']);
    Route::put('/faculty/{id}', [FacultyController::class, 'updateFaculty']);
    Route::delete('/faculty/{id}', [FacultyController::class, 'deleteFaculty']);

    //Librarian
    Route::get('/librarian', [LibrarianController::class, 'allLibrarian']);

    //Library Status
    Route::get('/librarystatus', [LibraryStatusController::class, 'allLibStat']);
    Route::get('/librarystatus/{id}', [LibraryStatusController::class, 'showALibStat']);

    //Logging
    Route::get('/logs', [LoggingController::class, 'allLog']);
    Route::get('/logs/{id}', [LoggingController::class, 'showALog']);
    Route::post('/logs', [LoggingController::class, 'createALog']);

    //Rental
    Route::get('/rental', [RentalController::class, 'allRental']);
    Route::get('/rental/{id}', [RentalController::class, 'showARental']);
    Route::post('/rental', [RentalController::class, 'createRental']);
    Route::put('/rental/{id}', [RentalController::class, 'updateRental']);
    Route::put('/rental/receipt/{id}', [RentalController::class, 'receiptRental']);
    Route::put('/rental/return/{id}', [RentalController::class, 'returnRental']);
});

Route::prefix('clinic')->group(function(){


    Route::get('/consultation-records', [ConsultationRecordController::class, 'allRecords']);
    Route::post('/consultation-records', [ConsultationRecordController::class, 'createConsultationRecord']);
    Route::get('/consultation-records/{studentId}', [ConsultationRecordController::class, 'getConsultationRecordsByStudent']);
    Route::put('/consultation-records/{studentId}', [ConsultationRecordController::class, 'updateConsultationRecord']);    Route::patch('/consultation-records/{id}/timeout', [ConsultationRecordController::class, 'updateTimeoutStatus']);
    Route::delete('/consultation-records/{studentId}', [ConsultationRecordController::class, 'deleteConsultationRecord']);
    Route::patch('/consultation-records/{id}/timeout', [ConsultationRecordController::class, 'updateTimeout']);
    Route::get('/dashboard-data', [ConsultationRecordController::class, 'getDashboardData']);
    Route::get('/monthly-consultations', [ConsultationRecordController::class, 'getMonthlyConsultations']);

    // Medicine
    Route::get('/medicines', [MedicineController::class, 'allMedicines']);
    Route::get('/medicines/{id}', [MedicineController::class, 'showAMedicine']);
    Route::post('/medicines', [MedicineController::class, 'createMedicine']);
    Route::put('/medicines/{id}', [MedicineController::class, 'updateMedicineP']);
    Route::delete('/medicines/{id}', [MedicineController::class, 'deleteMedicineP']);
    Route::post('/generate-medical-certificate', [MedicalCertificateController::class, 'generate']);
    Route::post('/generate-dental-certificate', [DentalCertificateController::class, 'generate']);


    // Login
    Route::post('/clinic', [ClinicController::class, 'createUser']);
    Route::post('/clinicAuth', [ClinicLogin::class, 'authenticate']);
    Route::post('/clinicLogout', [ClinicLogin::class, 'logout'])->middleware('auth:api');

    Route::get('medical-certs', [MedicalCertController::class, 'index']); // GET all medical certificates
    Route::post('medical-certs', [MedicalCertController::class, 'store']); // POST create a new medical certificate
    Route::get('medical-certs/{medicalCert}', [MedicalCertController::class, 'show']); // GET a specific medical certificate
    Route::put('medical-certs/{medicalCert}', [MedicalCertController::class, 'update']); // PUT update a specific medical certificate
    Route::delete('medical-certs/{medicalCert}', [MedicalCertController::class, 'destroy']); // DELETE a specific medical certificate


    
    Route::get('/dental-certs', [DentalCertController::class, 'index']); // Get all dental certificates
    Route::get('/dental-certs/{studentId}', [DentalCertController::class, 'getDentalCerts']); // Get a specific dental certificate
    Route::post('/dental-certs', [DentalCertController::class, 'store']); // Create a new dental certificate
    Route::put('/dental-certs/{studentId}', [DentalCertController::class, 'update']); // Update a specific dental certificate
    Route::delete('/dental-certs/{id}', [DentalCertController::class, 'destroy']); // Delete a specific dental certificate


    Route::post('/physical-examinations', [PhysicalExaminationController::class, 'store']);
    Route::get('/physical-examinations', [PhysicalExaminationController::class, 'getAllPhysicalExaminations']); // New route for getting all records
    Route::get('/physical-examinations/{id}', [PhysicalExaminationController::class, 'getPhysicalExamination']);
    Route::get('/physical-examinations/{studentId}', [PhysicalExaminationController::class, 'getPhysicalExamination']);
    Route::delete('/physical-examinations/{id}', [PhysicalExaminationController::class, 'deletePhysicalExamination']);
    Route::put('/physical-examinations/{studentId}', [PhysicalExaminationController::class, 'updatePhysicalExamination']);


    Route::get('inventories', [InventoryController::class, 'index']); // For listing inventories
    Route::post('inventories', [InventoryController::class, 'store']); // For creating an inventory record
    Route::get('inventories/{id}', [InventoryController::class, 'show']); // For getting a single inventory record
    Route::put('inventories/{id}', [InventoryController::class, 'update']); // For updating an inventory record
    Route::delete('inventories/{id}', [InventoryController::class, 'destroy']); // For deleting an inventory record
    Route::get('/consultation-records-with-inventory/{id}', [ConsultationRecordController::class, 'getRecordWithInventory']);

    Route::post('/archive', [CasesController::class, 'archive']);
});


Route::prefix('archives')->group(function () {
    Route::get('/', [ConsultationArchiveController::class, 'index']);
    Route::get('/{id}', [ConsultationArchiveController::class, 'show']);
    Route::post('/', [ConsultationArchiveController::class, 'store']);
    Route::put('/{id}', [ConsultationArchiveController::class, 'update']);
    Route::delete('/{id}', [ConsultationArchiveController::class, 'destroy']);
});
Route::get('/cases', [ViolationController::class, 'index']);
Route::post('/cases', [ViolationController::class, 'store']);
Route::post('/violation/archive', [ViolationController::class, 'archive']);
Route::post('/cases/restore', [ViolationController::class, 'restore']);
Route::get('/vio/getJHS', [ViolationController::class, 'getJHS']);
Route::get('/vio/getSHS', [ViolationController::class, 'getSHS']);

Route::post('/register', [AdminController::class, 'store']);
Route::post('/authlogin', [AdminLoginController::class, 'authenticate']);
Route::get('/authlogin', [AdminLoginController::class, 'authenticate']);

Route::get('/roleget', [AdminController::class, 'getRole']);



Route::get('/consultations/archived', [ConsultationController::class, 'archived']);
Route::get('/consultations/countjhs', [ConsultationController::class, 'ConsultationJHS']);
Route::get('/consultations/countshs', [ConsultationController::class, 'ConsultationSHS']);

Route::prefix('cases')->group(function () {
    Route::apiResource('cases', CaseController::class);
    Route::get('/', [CasesController::class, 'index']);
    Route::post('/', [CasesController::class, 'store']);
    Route::get('/{id}', [CasesController::class, 'show']);
    Route::put('/{id}', [CasesController::class, 'update']);
    Route::put('/{id}/status-update', [CasesController::class, 'statusUpdate']);
    Route::delete('/{id}', [CasesController::class, 'destroy']);
    Route::post('/arch', [CasesController::class, 'archive']);

});
    Route::get('/archived', [CasesController::class, 'getArchivedCases']);
    Route::get('/examinations/arch', [ExaminationController:: class, 'examArchived']);
// Routes for ExaminationController
Route::prefix('examinations')->group(function () {
    Route::get('/', [ExaminationController::class, 'index']);
    Route::post('/', [ExaminationController::class, 'store']);
    Route::get('/{id}', [ExaminationController::class, 'show']);
    Route::put('/{id}', [ExaminationController::class, 'update']);
    Route::delete('/{id}', [ExaminationController::class, 'destroy']);
    Route::post('/{id}/archive', [ExaminationController::class, 'archive']);

});

Route::prefix('consultation')->group(function () {
    Route::get('/', [ConsultationController::class, 'index']);
    Route::get('/{id}', [ConsultationController::class, 'show']);
    Route::post('/', [ConsultationController::class, 'store']);
    Route::put('/{id}', [ConsultationController::class, 'update']);
    Route::delete('/{id}', [ConsultationController::class, 'destroy']);
    Route::post('/{id}/archive', [ConsultationController::class, 'archive']);
    });
    
    Route::get('/cons/jhs', [ConsultationController::class, 'ConsultationsJHS']);
    Route::get('/cons/shs', [ConsultationController::class, 'ConsultationSHS']);

 Route::get('/consultations/countjhs', [ConsultationController::class, 'ConsultationJHS']);

Route::prefix('inventory')->group(function(){

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);


    //Items
    Route::get('items', [ItemsController::class, 'displayItems']);
    Route::post('items/add', [ItemsController::class, 'addItems']);
    Route::post('items/update/{id}', [ItemsController::class, 'updateItems']);
    Route::post('items/delete/{id}', [ItemsController::class, 'deleteItems']);


    Route::get('/borrowed-items', [BorrowedItemController::class, 'index']);
    Route::post('/borrowed-items', [BorrowedItemController::class, 'store']);
    Route::get('/total-borrowed-quantity-per-item', [BorrowedItemController::class, 'totalBorrowedQuantityPerItem']);
    Route::post('/borrowed-items/return', [BorrowedItemController::class, 'returnItem']);
    Route::get('/total-overdue-quantities-per-item', [BorrowedItemController::class, 'totalOverdueQuantitiesPerItem']);


    Route::get('/damaged-items', [DamageItemController::class, 'index']);
    Route::get('/total-damage-quantity-per-item', [DamageItemController::class, 'totalDamagedQuantitiesPerItem']);
    Route::post('/damaged-items', [BorrowedItemController::class, 'markAsDamaged']);
    Route::post('/damaged-items/repair', [DamageItemController::class, 'repairItem']);
    Route::post('/damaged-items/unusable', [DamageItemController::class, 'returnAsDamaged']);

    Route::get('/unusable-items', [UnusableItemController::class, 'index']);
    Route::post('/unusable-items', [UnusableItemController::class, 'store']);
});


