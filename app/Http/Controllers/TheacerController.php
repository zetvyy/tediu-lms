<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorageTeacherRequest;
use App\Models\Theacer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TheacerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Theacer::orderBy('id', 'desc')->get();

        return view('admin.teachers.index', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorageTeacherRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Data tidak ditemukan'
            ]);
        }

        if ($user->hasRole('teacher')) {
            return back()->withErrors([
                'email' => 'Email tersebut telah menjadi guru'
            ]);
        }

        DB::transaction(function () use ($user, $validated) {

            $validated['user_id'] = $user->id;
            $validated['is_active'] = true;

            Theacer::create($validated);

            if ($user->hasRole('student')) {
                $user->removeRole('student');
            }
            $user->assignRole('teacher');
        });


        return view('admin.teachers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Theacer $theacer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theacer $theacer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theacer $theacer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theacer $theacer)
    {
        DB::beginTransaction();
        try {
            $theacer->delete();
            DB::commit();

            $user = User::find($theacer->user_id);

            $user->removeRole('teacher');
            $user->assignRole('student');

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'system_error' => ['System error', $e->getMessage()]
            ]);
            throw $error;
        }
    }
}
