 <x-layout>

     <x-form title="Login Now" subtitle="Welcome Back">
         <form action="/login" method="POST">
             @csrf

             <x-form.field title="Emial" name="email" type="email" />
             <x-form.field title="Password" name="password" type="password" />

             <button type="submit" class="btn h-10 w-full">Login</button>

         </form>
     </x-form>







 </x-layout>
