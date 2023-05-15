<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $header ?? '' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (isset($breads))
                        @foreach ($breads as $bread)
                            @if ($bread['url'] == 'active')
                            <li class="breadcrumb-item active">{{ $bread['name'] }}</li>
                            @else
                            <a href="{{ $bread['url'] }}"><li class="breadcrumb-item">{{ $bread['name'] }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>
</section>