<body>
    <h1>Form Tambah Data User</h1>
    <a href="{{ route('user') }}">Kembali</a>
    <form method="post" action="{{ route('user.tambah_simpan') }}">
        {{ csrf_field() }}
        
        <label>Username</label>
        <br>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>

        <label>Nama</label>
        <br>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>

        <label>Password</label>
        <br>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>

        <label>Level ID</label>
        <br>
        <input type="number" name="level_id">
        <br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
