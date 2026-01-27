<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h4>Users</h4>
        <a href="/admin/users/create" class="btn btn-success">+ Add User</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>DOB</th>
                <th>Gender</th>
                <th width="35%">Address</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                {{-- <td>{{ $user->id }}</td> --}}
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->user_name }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->dob }}</td>
                <td>{{ $user->gender }}</td>

                <td>
                    @php
                        $home = $user->addresses->where('address_type','Home')->first();
                        $office = $user->addresses->where('address_type','Office')->first();
                    @endphp

                    @if($home)
                        <div class="mb-2 p-2 border rounded bg-light">
                            <strong>Home</strong>
                            @if($home->primary === 'Yes')
                                <span class="badge bg-success ms-2">Primary</span>
                            @endif
                            <div class="small mt-1">
                                {{ $home->door_street }}<br>
                                {{ $home->city }}, {{ $home->state }}<br>
                                {{ $home->country }}
                            </div>
                        </div>
                    @endif

                    @if($office)
                        <div class="p-2 border rounded bg-light">
                            <strong>Office</strong>
                            @if($office->primary === 'Yes')
                                <span class="badge bg-success ms-2">Primary</span>
                            @endif
                            <div class="small mt-1">
                                {{ $office->door_street }}<br>
                                {{ $office->city }}, {{ $office->state }}<br>
                                {{ $office->country }}
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm mb-1">Edit</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
