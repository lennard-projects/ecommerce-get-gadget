@extends('layout')

@section('content')
    <div class="flex justify-center m-6">
        <h1 class="text-lg font-semibold">Users</h1>
    </div>
    <div class="p-4 w-full">
        @unless (count($users) == 0)
            <div class="max-w-7xl mx-auto">
                <table class="border-collapse w-full mt-3 text-sm">
                    <thead class="text-xs uppercase border border-gray-100">
                        <tr>
                            <th class="px-3 py-3 border">ID</th>
                            <th class="px-3 py-3 border">Name</th>
                            <th class="px-3 py-3 border">Email</th>
                            <th class="px-3 py-3 border">Role</th>
                            <th class="px-3 py-3 border w-[100px]">Actions</th>
                        </tr>
                    </thead>
                    @foreach ($users as $user)
                        <tbody class="text-center">
                            <tr>
                                <td class="px-3 py-2 border">{{ $user->id }}</td>
                                <td class="px-3 py-2 border">{{ $user->name }}</td>
                                <td class="px-3 py-2 border">{{ $user->email }}</td>
                                <td class="px-3 py-2 border">{{ $user->role }}</td>
                                <td class="px-3 py-2 border flex justify-center w-full">
                                    <form action="{{ route('admin.deleteUser', ['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="delete-button bg-red-500 hover:bg-red-700 text-white font-semibold p-2 rounded mx-2 w-[80px]">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        @else
            <div>
                <h1>No users found.</h1>
            </div>
        @endunless
    </div>
    <div>
        <div>
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    <script type="text/javascript">
        $('.delete-button').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
