<header class="border border-border px-6">
    <nav class="flex items-center justify-between max-w-7xl h-16 mx-auto">
        <div class="logo">
            <h2 class="text-3xl">Ideas</h2>
        </div>

        <div class="menu space-x-10">
            <a href="#" class="home">Home</a>
            <a href="#" class="home">About</a>
            <a href="#" class="home">Contact</a>
        </div>

        <div class="space-x-10">
            @auth
            <a href="/logout" class="login">Logout</a>
            @endauth
            @guest
            <a href="/login" class="login">Login</a>
            <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </nav>
</header>
