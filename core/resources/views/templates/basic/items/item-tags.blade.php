@if ($type == 'job')
    <div class="card-body__block">
        <ul class="skill-list">
            @foreach (($product->skill ?? []) as $skill)
                <li class="skill-list__item">
                    <a class="skill-list__link" href="{{ route('job') }}?skill={{ $skill }}">
                        {{ __($skill) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
