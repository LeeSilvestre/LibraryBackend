<?php


namespace App\Http\Controllers;

use App\Models\CasesLog;
use Illuminate\Http\Request;

class CasesLogController extends Controller
{
    public function index()
    {
        $casesLogs = CasesLog::all();
        return view('cases_logs.index', compact('casesLogs'));
    }

    public function create()
    {
      
    }

    public function store(Request $request)
    {
       
    }

    public function show(CasesLog $casesLog)
    {
        return view('cases_logs.show', compact('casesLog'));
    }

    public function edit(CasesLog $casesLog)
    {
       
    }
    public function update(Request $request, CasesLog $casesLog)
    {
       
    }

    public function destroy(CasesLog $casesLog)
    {
    }
}
