<nav>
    <a href="/" class="{{ $current_page == 'home' ? 'highlighted' : '' }}">Home</a>
   
    @auth 
        <a href="{{route('mypolls')}}" class="{{ $current_page == 'mypolls' ? 'highlighted' : '' }}">My Polls</a>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button>Logout</button>
        </form>
    @else
        <a href="/register" class="{{ $current_page == 'register' ? 'highlighted' : '' }}">Register</a>
        <a href="/login" class="{{ $current_page == 'login' ? 'highlighted' : '' }}">Login</a>
    @endauth
</nav>