<div x-show="activeTab=='{{$tab}}'" class="grid grid-cols-4 gap-4">
    @foreach ($protocols as $areaName => $area)
    <h1 class="col-span-4 font-semibold text-lg text-left">{{$areaName}}</h1>
    @foreach ($area as $protocol)
    <div>
        <div class="aspect-w-1 aspect-h-1 border">
            <div class="flex flex-col justify-center"
                @click="open = true; modalData = {{json_encode($protocol)}}; modalData.img = '{{$protocol->getFirstMediaUrl('partner_logo')}}'; modalData.contacts = {{json_encode($protocol->contacts)}}; modalData.addresses = {{json_encode($protocol->addresses)}}">
                @if($protocol->getFirstMediaUrl('partner_logo'))
                <img src="{{$protocol->getFirstMediaUrl('partner_logo')}}" class="w-3/4 mx-auto" />
                @else
                <p>{{$protocol->name}}</p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @endforeach
</div>
