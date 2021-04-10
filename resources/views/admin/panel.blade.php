Isi dengan halaman utama admin

{{ Auth::user() }}

<form action="/logout" method="POST">
    @csrf
    <button>Logout</button>
</form>
