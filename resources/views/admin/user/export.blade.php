<table>
    <thead>
        <tr>
            <th style="background-color: yellow;color:black;width:50px">No</th>
            <th style="background-color: yellow;color:black;width:150px">Name</th>
            <th style="background-color: yellow;color:black;width:100px">Username</th>
            <th style="background-color: yellow;color:black;width:150px">Email</th>
            <th style="background-color: yellow;color:black;width:100px">Phone</th>
            <th style="background-color: yellow;color:black;width:100px">Gender</th>
            <th style="background-color: yellow;color:black;width:100px">Birthday</th>
            <th style="background-color: yellow;color:black;width:100px">Status</th>
            <th style="background-color: yellow;color:black;width:100px">Join Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($users as $user)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                @php
                    $gender = App\Services\BulkData::gender;
                @endphp
                <td>
                    @foreach ($gender as $g)
                        @if ($g['alias'] == $user->gender)
                            {{ $g['name'] }}
                        @endif
                    @endforeach
                </td>
                <td>{{ date('d/M/Y', strtotime($user->birthday)) }}</td>
                @php
                    $status = App\Services\BulkData::status;
                @endphp
                <td>
                    @foreach ($status as $s)
                        @if ($s['id'] == $user->status)
                            {{ strtoupper($s['name']) }}
                        @endif
                    @endforeach
                </td>
                <td>{{ date('d/M/Y', strtotime($user->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
