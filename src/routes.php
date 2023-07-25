<?php 

use jaysingh\irr\irrCalculationController;
use Illuminate\Support\Facades\Route;

 Route::get('irr',[irrCalculationController::class,'getIRR']);

?>