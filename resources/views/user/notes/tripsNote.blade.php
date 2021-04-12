<link href="{{ asset('/css/flash_message.css') }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@if ($users = Session::get('notation_trajet'))
        <div class="alert alert-danger custom-alert">
            <form method="POST" action = "{{ route('note.notation') }}">
            <ul style="list-style-type:none;">
                    <li>Notation</li>
                <?php $count = 0 ?>
                @foreach ($users->all() as $user)
                    <?php $count++; ?>
                    <li class="li-error">{{ $user->name }}</li>
                    @include('include.rating', ['count' => $count, 'enabled' => 'enabled'])
                @endforeach
            </ul>
            <div>
<!--                TODO attention valeur 0 = non noté -->
                <input class="error_confirmation" type="submit" value="Confirmer">
            </div>
            <br>
            <div>
                <input class="error_confirmation" type="button" onclick="$('div.custom-alert').remove()" value="Annuler">
            </div>
            </form>
        </div>
    @endif
