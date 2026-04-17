 <x-layout>

     <x-form title="Register Now" subtitle="Make an account and publish your Idea">
         <form action="/register" method="POST">
             @csrf

             <x-form.field title="Name" name="name" />
             <x-form.field title="Emial" name="email" type="email" />
             <x-form.field title="Password" name="password" type="password" />

             <button type="submit" class="btn h-10 w-full">Register</button>

         </form>
     </x-form>







 </x-layout>
