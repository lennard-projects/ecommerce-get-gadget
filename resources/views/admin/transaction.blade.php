@extends('layout')

@section('content')
    <div class="flex justify-center m-6">
        <h1 class="text-lg font-semibold">transactions</h1>
    </div>
    <div class="p-4 w-full">
        @unless (count($transactions) == 0)
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
                    @foreach ($transactions as $transaction)
                        <tbody class="text-center">
                            <tr>
                                <td class="px-3 py-2 border">{{ $transaction->id }}</td>
                                <td class="px-3 py-2 border">{{ $transaction->user_id }}</td>
                                <td class="px-3 py-2 border">{{ $transaction->payment_id }}</td>
                                <td class="px-3 py-2 border">{{ $transaction->product_id }}</td>
                                <td class="px-3 py-2 border">{{ $transaction->payment_created_at }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        @else
            <div>
                <h1>No transactions found.</h1>
            </div>
        @endunless
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
