<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Traits\FlashAlert;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FaqController extends Controller
{

    use FlashAlert;
    use HasRolesAndPermissions;


    public function index()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin') || $user->isAbleTo('faqs-read')) {
            $faqs = Faq::paginate(10);
            return view('faq.index', compact('faqs'));
        } else {
            return redirect()->route('dashboard')->with($this->permissionDenied());
        }
    }

    public function create()
    {
        return view('faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string',],
            'published' => 'required|boolean',
        ]);
        $faqData = $request->all();

        request()->user()->faqs()->create($faqData);

        return redirect()->route('faq.index')->with($this->alertCreated());
    }

    public function edit($id)
    {
        try {
            $faq = Faq::findOrFail($id);

            if (
                request()->user()->hasRole('superadmin') ||
                request()->user()->isAbleTo('faqs-update', $faq) ||
                $faq->user_id === request()->user()->id
            ) {
                return view('faq.edit', compact('faq'));
            } else {
                return redirect()->route('faq.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('faq.index')->with($this->alertNotFound());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = Faq::findOrFail($id);

            if (
                request()->user()->hasRole(['superadmin']) ||
                request()->user()->isAbleTo('faqs-update', $faq) ||
                $faq->user_id === request()->user()->id
            ) {
                $request->validate([
                    'question' => ['required', 'string', 'max:255'],
                    'answer' => ['required', 'string',],
                    'published' => 'required|boolean',
                ]);

                $faqData = $request->all();
                $faq->update($faqData);

                return redirect()->route('faq.index')->with($this->alertUpdated());
            } else {
                return redirect()->route('faq.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('faq.index')->with($this->alertNotFound());
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);

            if (
                request()->user()->hasRole(['superadmin']) ||
                request()->user()->isAbleTo('faqs-delete', $faq) ||
                $faq->user_id === request()->user()->id
            ) {
                $faq->delete();

                return redirect()->route('faq.index')->with($this->alertDeleted());
            } else {
                return redirect()->route('faq.index')->with($this->permissionDenied());
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('faq.index')->with($this->alertNotFound());
        }
    }
}
