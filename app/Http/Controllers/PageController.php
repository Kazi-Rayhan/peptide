<?php
namespace App\Http\Controllers;

use App\Mail\ContactFormNotification;
use App\Models\FaqCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Display the About Us page
     */
    public function about()
    {
        return view('frontend.pages.about');
    }

    /**
     * Display the Contact Us page
     */
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:25',
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
        ]);
     

        $admins = User::where('role_id', 1)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ContactFormNotification($data));
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Display the FAQ page
     */
    public function faq()
    {
        $faqCategories = FaqCategory::active()
            ->ordered()
            ->with(['activeFaqItems' => function ($query) {
                $query->ordered();
            }])
            ->get();

        return view('frontend.pages.faq', compact('faqCategories'));
    }
}
