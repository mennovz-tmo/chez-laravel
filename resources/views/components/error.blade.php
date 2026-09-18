<div class="row justify-content-center">
    <div class="col-lg-8">
        @if ($errors->any())
            <div class="alert alert-danger alert-danger-custom m-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (Session::has('success'))
            <div class="alert alert-success alert-success-custom m-2">{{ Session::get('success') }}</div>
        @endif
    </div>
</div>
