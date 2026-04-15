<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        @include('includes.style')
    </head>
    <body class="bg-gray-100">
        <div class="w-full h-screen flex items-center justify-center">
            <div class="p-5 rounded-lg bg-white">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-[500]">
                        Login
                    </h1>
                    <p class="text-sm opacity-50">Masukkan akun Anda</p>
                </div>
                <div>
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-2">
                            <label class="text-xs mb-2 text-gray-500 required" for="email">Email</label>
                            <input type="email" value="admin@example.com" class="bg-gray-100 w-full rounded-md py-2 px-3 outline-none" id="email" name="email" placeholder="your-email@gmail.com" required autofocus>
                        </div>
                        <div class="mb-6">
                            <label class="text-xs mb-2 text-gray-500 required" for="password">Password</label>
                            <input type="password" value="12345678" class="bg-gray-100 w-full rounded-md py-2 px-3 outline-none" id="password" placeholder="your-password" name="password" required>
                        </div>
                        <div class="w-full">
                            <a href="{{ route('admin.dashboard') }}" class="rounded-md flex items-center justify-center p-2 bg-red-500 hover:bg-red-500 text-white ">
                                Masuk
                            </a>
                            {{-- <button class="rounded-md w-full p-2 bg-blue-500 text-white hover:bg-blue-600" type="submit">Masuk</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('includes.scripts')
    </body>
</html>
