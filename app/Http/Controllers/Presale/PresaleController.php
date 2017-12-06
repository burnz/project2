<?php
    namespace App\Http\Controllers\Presale;
    use App\Http\Controllers\Controller;
    class PresaleController extends Controller
    {
        public function index()
        {
            return view('adminlte::presale.index');
        }
    }
?>