@extends('alumni.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('alumni.view.dashboard')}}">Alumni</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{route('alumni.view.membership.list')}}">Membership</a></li>
        </ul>
        <h1 class="panel-title">Membership</h1>
    </div>
@endsection
    
@section('panel-body')


<div class="grid md:grid-cols-3 sm:grid-cols-1 md:gap-7 sm:gap-5">

    
    @foreach ($memberships as $membership)
            <figure class="panel-card">
                <div class="panel-card-body space-y-1">
                    <div class="pb-2">
                        <img src="{{asset('storage/'.$membership->thumbnail_image)}}" alt="membership-logo" class="w-[100px] h-auto">
                    </div>
                    <h1 class="title">{{ $membership->name }}</h1>
                    <h1 class="description">{{ $membership->summary }}</h1>
                    <div class="flex items-baseline justify-start space-x-2">
                        @if ($membership->discounted_price)
                        <h1 class="text-lg font-semibold">₹{{number_format($membership->discounted_price, 2)}}</h1>
                        <h1 class="text-base font-medium line-through text-gray-500">₹{{number_format($membership->regular_price,2)}}</h1>
                        @else
                        <h1 class="text-lg font-semibold">₹{{$membership->regular_price}}</h1>
                        @endif
                    </div>
                    <div>
                        <div class="pt-2">
                            <a href="#" class="btn-primary-sm w-full flex items-center justify-center space-x-2"><span>Buy Membership</span><i data-feather="arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </figure>
        @endforeach

</div>
@endsection

@section('panel-script')
<script>
    document.getElementById('membership-tab').classList.add('active');
</script>
@endsection