<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribeTransactionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $courses = Course::with(['category', 'teacher', 'students'])->orderByDesc('id')->get();

        return view('front.index', compact('categories', 'courses'));
    }

    public function details(Course $course)
    {
        return view('front.details', compact('course'));
    }

    public function category(Category $category)
    {
        $categories = Category::get();
        $courses = $category->courses()->get();
        return view('front.category', compact('courses', 'categories'));
    }

    public function learning(Course $course, $courseVideoId)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->route('front.pricing');
        }

        $video = $course->course_videos->firstWhere('id', $courseVideoId);

        $user->courses()->syncWithoutDetaching($course->id);

        return view('front.learning', compact('course', 'video'));
    }

    public function pricing()
    {
        $user = Auth::user();

        if (!$user) {
            return view('auth.login');
        } else if ($user->hasActiveSubscription()) {
            return redirect()->route('front.index');
        }
        return view('front.pricing');
    }

    public function checkout()
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return redirect()->route('front.index');
        }
        return view('front.checkout');
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request)
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return redirect()->route('front.index');
        }

        try {
            DB::transaction(function () use ($request, $user) {
                $validated = $request->validated();

                if ($request->hasFile('proof')) {
                    $proofPath = $request->file('proof')->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                }

                $validated['user_id'] = $user->id;
                $validated['total_amount'] = 490000;
                $validated['is_paid'] = false;

                SubscribeTransaction::create($validated);
            });

            return redirect()->route('dashboard')->with('success', 'Checkout berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
