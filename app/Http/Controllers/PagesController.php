<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\ContactRequest;
use App\Jobs\SendContactEmail;
use App\Work;

class PagesController extends Controller
{
    /**
     * Home Page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $works = Work::all();
        $customers = Customer::all();

        return view('home', compact('works', 'customers'));
    }

    /**
     * Resume Page.
     *
     * @return \Illuminate\View\View
     */
    public function resume()
    {
        return view('resume');
    }

    /**
     * Contact form.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Send the Contact request.
     *
     * @param \App\Http\Requests\ContactRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function postContact(ContactRequest $request)
    {
        $this->dispatch(new SendContactEmail($request->all()));

        return view('contact')->withSuccess(trans('app.contact.mailSent'));
    }

    /**
     * Translate the website.
     *
     * @param $lang string
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function translate($lang)
    {
        session()->set('language', $lang);

        return redirect()->back();
    }
}
