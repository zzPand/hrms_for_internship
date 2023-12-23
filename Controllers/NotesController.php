<?php

// app/Http/Controllers/NotesController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function showNotes()
    {
        return view('Notes.notes');
    }
}

