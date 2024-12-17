<nav class="flex justify-between items-center pt-6 px-[50px]">
    <a href="">
        <img src="assets/logo/tediu-putih.png" alt="logo" class="w-[150px]">
    </a>
    <ul class="flex items-center gap-[30px] text-white">
        @forelse($categories as $category)
        <li>
            <a href="{{route('front.category', $category->slug)}}" class="font-semibold">{{$category->name}}</a>
        </li>
        @empty 
        @endforelse
    </ul>
    @auth
    <div class="flex gap-[10px] items-center">
        <div class="flex flex-col items-end justify-center">
            <p class="font-semibold text-white">Hi, {{Auth::user()->name}}</p>
            @if(Auth::user()->hasActiveSubscription())
                <p class="p-[2px_10px] rounded-full bg-[#4B7BFF] font-semibold text-xs text-white text-center">PRO</p>
            @endif
        </div>
        <a href="{{route('dashboard')}}">
            <div class="w-[56px] h-[56px] overflow-hidden rounded-full flex shrink-0">
                <img src={{Storage::url(Auth::user()->avatar)}} class="w-full h-full object-cover" alt="photo">
            </div>
        </a>
    </div>
    @endauth
    @guest
    <div class="flex gap-[10px] items-center">
        <a href="{{route('register')}}" class="text-white font-semibold rounded-[30px] p-[16px_32px] ring-1 ring-white transition-all duration-300 hover:ring-2 hover:ring-[#4B7BFF]">Sign Up</a>
        <a href="{{route('login')}}" class="text-white font-semibold rounded-[30px] p-[16px_32px] bg-[#4B7BFF] transition-all duration-300 hover:shadow-[0_10px_20px_0_#D4379080]">Sign In</a>
    </div>
    @endguest
</nav>