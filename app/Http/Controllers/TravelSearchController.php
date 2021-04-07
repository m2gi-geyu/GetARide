<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\LinkUserTrip;
use App\Models\Trip;
use App\Notifications\trip\tripRequest;

class TravelSearchController extends Controller
{
    public function search_trip_view()
    {
        return view('trip/search_trip');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query[0] != '' || $query[1] != '' || $query[2] != '')
            {
                $data = DB::table('trips')
                    ->join('users', 'users.id', '=', 'trips.id_driver')
                    ->select('trips.*', 'users.username')
                    ->whereRAW('((trips.starting_town like \''.$query[0].'%\' and trips.ending_town like \''.$query[1].'%\')
                                    or
                                    (trips.starting_town like \''.$query[0].'%\' and exists(
                                       select * from stages_trip where trips.id = stages_trip.id_trip and stage like \''.$query[1].'%\'))
                                    or
                                    (trips.ending_town like \''.$query[1].'%\' and exists(
                                       select * from stages_trip where trips.id = stages_trip.id_trip and stage like \''.$query[0].'%\'))
                                    or
                                    (exists(
                                       select * from stages_trip s1 where s1.id_trip = trips.id and s1.stage like \''.$query[0].'%\' and exists(
                                           select * from stages_trip s2 where s2.id_trip = s1.id_trip and s2.stage like \''.$query[1].'%\' and s2.order > s1.order))))')
                    ->where('trips.private', '=', 0)
                    ->where('trips.date_trip', 'like', $query[2].'%')
                    ->where('trips.number_of_seats', ">", 0)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            else
            {
                $data = DB::table('trips')
                    ->join('users', 'users.id', '=', 'trips.id_driver')
                    ->select('trips.*', 'users.username')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $trip)
                {
                    $output .= '<tr>'.
                        '<td>'.$trip->username.'</td>'.
                        '<td>'.$trip->number_of_seats.'</td>'.
                        '<td>'.$trip->starting_town.'</td>'.
                        '<td>'.$trip->ending_town.'</td>'.
                        '<td>'.$trip->date_trip.'</td>'.
                        '<td>'.$trip->price.'</td>'.
                        '<td>'.$trip->description.'</td>'.
                        '</tr>';
                }
            }
            else {
                $data = DB::table('trips')
                    ->whereRaw('starting_town like \''.$query[0].'%\'
                                or
                                exists(select * from stages_trip where stage like \''.$query[0].'%\')')
                    ->count();
                if ($data == 0) {
                    $output = '
       <tr>
        <td align="center" colspan="10">Il n\'existe aucun trajet démarrant à une ville commençant par \''.$query[0].'\'</td>
       </tr>
       ';
                } else {
                    $data = DB::table('trips')
                        ->whereRaw('ending_town like \'' . $query[1] . '%\'
                                or
                                exists(select * from stages_trip where stage like \'' . $query[1] . '%\')')
                        ->count();
                    if ($data == 0) {
                        $output = '
       <tr>
        <td align="center" colspan="10">Il n\'existe aucun trajet finissant à une ville commençant par \'' . $query[1] . '\'</td>
       </tr>
       ';
                    }else{
                        $data = DB::table('trips')
                            ->where('date_trip', 'like', $query[2].'%')
                            ->count();
                        if($data == 0){
                            $output = '
       <tr>
        <td align="center" colspan="10">Aucun trajet trouvé pour le '.$query[2].'</td>
       </tr>
       ';
                        }else{
                            $output = '
       <tr>
        <td align="center" colspan="10">No Data Found</td>
       </tr>
       ';
                        }
                    }
                }
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }

     /**
     * Fonction permettant d'envoyer une requête de participation à un trajet (d'ID $tripID)
     */
    public function sendTripRequest(int $tripID){
        $passenger = User::find(session()->get('LoggedUserID')); // Utilisateur passager
        $trip = Trip::find($tripID); // Trajet concerné
        $driver = User::find($trip -> id_driver); // Utilisateur créateur du trajet (conducteur)
        
        $linkTripUser = new LinkTripUser; // Rajout de la requête dans la BDD
        $linkTripUser -> id_trip = $trip;
        $linkTripUser -> id_user = $passenger;
        $linkTripUser -> validated = NULL;
        $linkTripUser -> save();

        $driver -> notify(new tripRequest($passenger, $driver, $trip)); // Notification du conducteur de la demande de participation
    }
}
