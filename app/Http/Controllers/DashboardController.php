<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Switch_;
use Psy\CodeCleaner\ReturnTypePass;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        switch (auth()->user()->role) {
            case 'member':
             return redirect()->route('member.dashboard');     // return view('member.dashboard');  
                break;
            case 'instructor':
                return redirect()->route('instructor.dashboard');
                 break;
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            
            default:
            return redirect()->route('login');
                break;
        }
    }
}
