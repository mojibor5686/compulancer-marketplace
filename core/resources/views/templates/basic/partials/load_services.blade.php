@foreach (@$products ?? [] as $product)
    <div
        class="col-sm-6 col-lg-{{ $routeName == 'public.profile' ? '6' : '4' }} col-xxl-{{ $routeName == 'public.profile' ? '4' : '3' }}">
        <x-item :product="$product" :type="$type" />
    </div>
@endforeach
