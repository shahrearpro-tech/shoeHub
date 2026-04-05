<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()    { return view('pages.about'); }
    public function contact()  { return view('pages.contact'); }
    public function faq()      { return view('pages.faq'); }
    public function shippingPolicy() { return view('pages.shipping-policy'); }
    public function returns()  { return view('pages.returns'); }
    public function sizeGuide(){ return view('pages.size-guide'); }
    public function happyCustomers() { 
        $videos = \App\Models\CustomerVideo::active()->latest()->get();
        return view('pages.happy-customers', compact('videos')); 
    }
}