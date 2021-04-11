<div class="container">
    <div class="row">
        <div class="col">
            <span class="">
                @php
                    $user = App\Models\User::find($rawNotification->data['id_user_origin']);
                    //echo $user->name." ".$user->surname;
                     echo '<a href="../user/check_user_profile/'.$user->id.'">'.$user->username.'</a>';


                @endphp

                ne vous accepte pas dans son trajet prévu le
                @php
                    $trip = App\Models\Trip::find($rawNotification->data['id_trip']);
                    $date = strtotime($trip->date_trip);
                    echo date('d/m/Y', $date);
                    echo " à ";
                    echo date('H:i', $date);
                @endphp
            <span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="">
                @php
                    $trip = App\Models\Trip::find($rawNotification->data['id_trip']);
                    echo $trip->starting_town;
                @endphp
            <span>
        </div>
        <div class="col">
            <span class="">
                @php
                    $trip = App\Models\Trip::find($rawNotification->data['id_trip']);
                    echo $trip->ending_town;
                @endphp
            <span>
        </div>
    </div>
</div>
