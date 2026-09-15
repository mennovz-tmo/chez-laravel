<div class="row justify-content-center">
    <div class="col-lg-8">@if ($errors->any())
        <div class="m-2 alert alert-danger alert-danger-custom">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @elseif (Session::has('success'))
            <div class="m-2 alert alert-success alert-success-custom">
                {{ Session::get('success') }}
            </div>
        @endif
    </div>
</div>