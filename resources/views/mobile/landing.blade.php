@extends('layouts.mobile')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center p-6 overflow-hidden">
    
    <!-- Top Left Food Image (Corner) -->
    <div class="absolute -top-10 -left-10 w-48 h-48 opacity-80">
        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300" 
             alt="food" class="rounded-full shadow-lg transform -rotate-12 border-4 border-white">
    </div>

    <!-- Main Logo Area -->
    <div class="flex flex-col items-center z-10 scale-110">
        <div class="relative w-48 h-48 bg-white rounded-full flex items-center justify-center shadow-2xl border-4 border-pink-600">
            <!-- Icon Mock -->
            <div class="flex flex-col items-center">
                <svg class="w-20 h-20 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                   <path d="M11,9H9V2H7V9H5V2H3V9c0,2.12,1.66,3.84,3.75,3.97V22h2.5v-9.03C11.34,12.84,13,11.12,13,9V2h-2V9z M16,6v8h3v8h2.5V2 c-3.04,0-5.5,2.46-5.5,5.5V6z"/>
                </svg>
                <!-- Text Banner -->
                <div class="gradient-btn px-6 py-1 rounded-full text-white font-bold text-xl mt-[-10px] shadow-md">
                    سفرة
                </div>
            </div>
            <!-- Concentric Circles Styling -->
            <div class="absolute inset-2 border-2 border-pink-200 rounded-full"></div>
            <div class="absolute inset-4 border border-pink-100 rounded-full"></div>
        </div>
    </div>

    <!-- Buttons Container -->
    <div class="mt-20 w-full max-w-xs space-y-4 z-10">
        <a href="#" class="gradient-btn w-full py-4 rounded-full text-white text-center font-bold text-lg shadow-lg flex items-center justify-center hover:opacity-90 transition transform active:scale-95">
            طلب طعام
        </a>
        <a href="#" class="gradient-btn w-full py-4 rounded-full text-white text-center font-bold text-lg shadow-lg flex items-center justify-center hover:opacity-90 transition transform active:scale-95">
            بيع طعام
        </a>
    </div>

    <!-- Bottom Right Food Image (Corner) -->
    <div class="absolute -bottom-10 -right-10 w-48 h-48 opacity-80">
        <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7bb7445?auto=format&fit=crop&q=80&w=300" 
             alt="food" class="rounded-full shadow-lg transform rotate-12 border-4 border-white">
    </div>

</div>
@endsection
