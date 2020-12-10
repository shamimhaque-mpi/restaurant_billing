@if (Session::has('old_password'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {!! Session::get('old_password') !!}
            </div>
        </div>
    </div>
@endif


@if ($errors->any())
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif