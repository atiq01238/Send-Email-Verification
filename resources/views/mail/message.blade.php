@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Your login form goes here -->
@if ($errors->has('success'))
    <div class="alert alert-danger">
        {{ $errors->first('success') }}
    </div>
@endif
