<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<form action="{{ route('zoho.create') }}" method="post">
    @csrf
    <label for="deal_name">Deal Name</label>
    <input type="text" name="deal_name" id="deal_name" required>

    <label for="contact_name">Contact Name</label>
    <input type="text" name="contact_name" id="contact_name" required>

    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" required>

    <label for="account_name">Account Name</label>
    <input type="text" name="account_name" id="account_name" required>

    <label for="industry">Industry</label>
    <input type="text" name="industry" id="industry" required>

    <button type="submit">Create Deal and Account</button>
</form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif