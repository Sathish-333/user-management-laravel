<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
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
        <h4>Create User</h4>

        <form method="POST" action="/admin/users">
            @csrf

            <input
                type="text"
                name="user_name"
                id="user_name"
                class="form-control mb-1"
                placeholder="User Name"
                oninput="validateName(this)"
                required
            >

            <small id="nameError" class="text-danger d-none">
                Name should contain only letters
            </small>

            <input
                type="text"
                name="mobile"
                maxlength="10"
                class="form-control mb-2"
                placeholder="Mobile"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                required
            >


            <input class="form-control mb-2"type="date" name="dob"required>


            <select class="form-control mb-3" name="gender">
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option> 
            </select>

            <h6 class="mt-3">Home Address</h6>
            <input class="form-control mb-2" name="home[address_type]" value="Home" readonly>
            <input class="form-control mb-2" name="home[door_street]" placeholder="Door / Street">
            <input class="form-control mb-2" name="home[landmark]" placeholder="Landmark">
            <input class="form-control mb-2" name="home[city]" placeholder="City">
            <input class="form-control mb-2" name="home[state]" placeholder="State">
            <input class="form-control mb-2" name="home[country]" placeholder="Country">

            <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="primary_address" value="Home">
            <label class="form-check-label">Set as Primary Address</label>
            </div>

            <hr>

            <h6>Office Address</h6>
            <input class="form-control mb-2" name="office[address_type]" value="Office" readonly>
            <input class="form-control mb-2" name="office[door_street]" placeholder="Door / Street">
            <input class="form-control mb-2" name="office[landmark]" placeholder="Landmark">
            <input class="form-control mb-2" name="office[city]" placeholder="City">
            <input class="form-control mb-2" name="office[state]" placeholder="State">
            <input class="form-control mb-2" name="office[country]" placeholder="Country">

            <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="primary_address" value="Office">
            <label class="form-check-label">Set as Primary Address</label>
            </div>

            <button class="btn btn-primary w-100">Save User</button>
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
function validateName(input) {
    const regex = /^[A-Za-z\s]*$/;
    const error = document.getElementById('nameError');

    if (!regex.test(input.value)) {
        error.classList.remove('d-none');
        input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    } else {
        error.classList.add('d-none');
    }
}
</script>

