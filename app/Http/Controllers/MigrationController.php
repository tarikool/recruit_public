<?php

namespace App\Http\Controllers;

use App\Migration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function index()
    {
//        $migration = Migration::where('migration', 'LIKE', '%question%')->update(['batch' => 1]);

        $migration = Migration::where('migration', 'LIKE', '%jobs%')->get()[1];
        $migration->update(['batch' => 1]);
        return $migration;
    }
}
