

    <table class="table table-striped table-responsive-sm" id="participatsTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Sebagai</th>
                <th>Nama Tim</th>
                <th>Kategori Lomba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user['mahasiswa_nrp']}}</td>
                <td>{{ $user['mahasiswa_name'] }}</td>
                @if($user['is_team_leader'] == 1)
                <td>Ketua</td>
                @else
                <td>Anggota</td>
                @endif
                <td>{{ $user['team']['team_name'] }}</td>
                <td>{{ $user['category']['competition_category_name'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
