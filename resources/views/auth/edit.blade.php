<x-layout>

     <x-form title="Edit Profile" subtitle="Update your profile information">
         <form action="{{ route('auth.update') }}" method="POST">
             @csrf
             @method("PATCH")

             <x-form.field title="Name" name="name" :value="auth()->user()->name" />
             <x-form.field title="Emial" name="email" type="email" :value="auth()->user()->email" />
             <x-form.field title="Password" name="password" type="password" />

             <button type="submit" class="btn h-10 w-full">Update</button>

         </form>
     </x-form>
</x-layout>