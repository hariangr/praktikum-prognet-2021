Isi dengan halaman utama admin

{{ Auth::user() }}

<form action="/logout" method="POST">
    @csrf
    <button>Logout</button>
</form>

<a href="/admindashboard" class="btn btn-primary" role="button">DASHBOARD ADMIN</a>
