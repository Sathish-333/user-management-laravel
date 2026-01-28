<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-light">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    @if($errors->any())
        toastr.error("{{ $errors->first() }}");
    @endif
    </script>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h4>Edit User</h4>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <input
                type="text"
                name="user_name"
                id="user_name"
                class="form-control mb-1"
                placeholder="User Name"
                oninput="validateName(this)"
                value="{{ old('user_name', $user->user_name) }}"
                maxlength="25"
                required
            >
            <small id="nameError" class="text-danger d-none"></small>


            <input
                type="text"
                name="mobile"
                maxlength="10"
                minlength="10"
                class="form-control mb-2"
                placeholder="Mobile"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                value="{{ old('mobile', $user->mobile) }}"
                required
            >
            <input
                class="form-control mb-2"
                type="date"
                name="dob"
                value="{{ old('dob', $user->dob) }}"
                max="{{ date('Y-m-d') }}"
                required
            >


            <select class="form-control mb-3" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            @php
                $home = $user->addresses->where('address_type', 'Home')->first();
                $office = $user->addresses->where('address_type', 'Office')->first();
                $primary = old('primary_address', $user->addresses->where('primary', 'Yes')->first()->address_type ?? '');
            @endphp

            <h6 class="mt-3">Home Address</h6>
            <input class="form-control mb-2" name="home[address_type]" value="Home" readonly>
            <input class="form-control mb-2" name="home[door_street]" placeholder="Door / Street" value="{{ old('home.door_street', $home->door_street ?? '') }}">
            <input class="form-control mb-2" name="home[landmark]" placeholder="Landmark" value="{{ old('home.landmark', $home->landmark ?? '') }}">
            <input class="form-control mb-2" name="home[city]" placeholder="City" value="{{ old('home.city', $home->city ?? '') }}">
            <input class="form-control mb-2" name="home[state]" placeholder="State" value="{{ old('home.state', $home->state ?? '') }}">
            <input class="form-control mb-2" name="home[country]" placeholder="Country" value="{{ old('home.country', $home->country ?? '') }}">

            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="primary_address" value="Home" {{ $primary == 'Home' ? 'checked' : '' }}>
                <label class="form-check-label">Set as Primary Address</label>
            </div>

            <hr>

            <h6>Office Address</h6>
            <input class="form-control mb-2" name="office[address_type]" value="Office" readonly>
            <input class="form-control mb-2" name="office[door_street]" placeholder="Door / Street" value="{{ old('office.door_street', $office->door_street ?? '') }}">
            <input class="form-control mb-2" name="office[landmark]" placeholder="Landmark" value="{{ old('office.landmark', $office->landmark ?? '') }}">
            <input class="form-control mb-2" name="office[city]" placeholder="City" value="{{ old('office.city', $office->city ?? '') }}">
            <input class="form-control mb-2" name="office[state]" placeholder="State" value="{{ old('office.state', $office->state ?? '') }}">
            <input class="form-control mb-2" name="office[country]" placeholder="Country" value="{{ old('office.country', $office->country ?? '') }}">

            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="primary_address" value="Office" {{ $primary == 'Office' ? 'checked' : '' }}>
                <label class="form-check-label">Set as Primary Address</label>
            </div>

            <button class="btn btn-primary w-100">Update User</button>
        </form>

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</div>

</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function () {

    window.validateName = function (input) {
        const error = document.getElementById('nameError');
        let value = input.value;

        if (!/^[A-Za-z\s]*$/.test(value)) {
            input.value = value.replace(/[^A-Za-z\s]/g, '');
            error.innerText = "Name should contain only letters";
            error.classList.remove('d-none');
            return;
        }

        value = value.replace(/^\s+/, '');
        input.value = value;

        if (value.length < 3) {
            error.innerText = "Name must be at least 3 characters";
            error.classList.remove('d-none');
        } else {
            error.classList.add('d-none');
        }
    };

    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        const homeCity = document.querySelector('[name="home[city]"]').value.trim();
        const officeCity = document.querySelector('[name="office[city]"]').value.trim();
        const primaryAddress = document.querySelector('input[name="primary_address"]:checked');

        if (!homeCity && !officeCity) {
            e.preventDefault();
            toastr.error("Please fill at least Home or Office address");
            return;
        }

        if (!primaryAddress) {
            e.preventDefault();
            toastr.error("Please select Primary Address");
            return;
        }
    });

});
</script>
