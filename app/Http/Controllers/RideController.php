<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\LinkUsersGroup;
use App\Models\LinkUserTrip;
use App\Models\Stage;
use App\Models\Trip;
use App\Models\User;
use App\Notifications\trip\tripCanceled;
use App\Notifications\trip\tripRequest;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Psr\Log\NullLogger;
use Illuminate\Support\Facades;
use App\Notifications\trip\newPrivateTrip;
use App\Notifications\trip\tripRequestCanceled;
use App\Notifications\trip\tripRequestAccepted;
use App\Notifications\trip\tripRequestRefused;
use function GuzzleHttp\Promise\all;

/**
 * Class RideController
 * @package App\Http\Controllers
 */
class RideController extends Controller
{
    /**
     * Rennvoie la page de création d'offre de trajet
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create_ride_form()
    {

        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            $data = DB::select('SELECT * FROM `groups` WHERE id_creator=:id', ['id' => $user->id]);
        }
        return view('trip.create_trip',['data'=>$data]);
    }

    /**
     * Vérifie les informations données par l'utilisateur et rajoute un voyage en bdd
     * si tout est correct
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create_ride_form_submission(Request $request){

        //Vérification des champs du formulaire
        $validator = $this->verification_info($request);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }


        return $this->create_ride($request);
    }

    public function verification_info(Request $request){
        $validator = Facades\Validator::make($request->all(),[
            'departure'=> 'required',
            'date'=>'required',
            'time'=>'required',
            'final'=>'required|different:departure',
            'rdv'=>'required',
            'nb_passengers'=>'required',
            'price'=>'required',
            'privacy'=>'required',
            'group' => 'required_if:privacy,==,private',
            'stage.*' => 'different:departure',
            'stage.*' => 'different:final'
        ],[
            'departure.required'=>'Ville de départ ne peut pas être vide.',
            'date.required'=>'La date ne peut être vide.',
            'time.required'=>'L\'heure ne peut être vide.',
            'final.required'=>'Ville d\'arrivée ne peut être vide',
            'final.different'=>'Ville d\'arrivée doit être différent de la ville de départ',
            'rdv.required'=>'Les precisions du rdv ne peuvent être vide.',
            'nb_passengers.required'=>'Le nombre de passagers ne peut être vide.',
            'price.required'=>'Le prix ne peut être vide.',
            'privacy.required'=>'La confidentialité ne peut être vide.',
            'group.required_if'=>'Il faut sélectionner un groupe pour les trajets privés',
            'stage.*.different'=>'Les étapes doivent être diférente de la ville de départ et de la ville d\'arrivée',
        ]);

        return $validator;
    }

    public function create_ride(Request $request){
        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();
            if ($user->vehicle == 1) {
                $ride = new Trip;
                $ride->id_driver = $user->id;
                $ride = $this->transfer($ride,$request);
                $now = new \DateTime();
                $difference_in_seconds = $ride->date_trip->format('U') - $now->format('U');


                if($difference_in_seconds<0){
                    return back()->with('fail', "La date de départ de ce trajet est déjà passée, il est donc impossible de le créer.");
                }
                if ($request->privacy == 'public') {
                    $ride->private = 0;
                } else {
                    $ride->private = 1;
                    $data = Group::where('name', '=', $request->group)->first();

                    $ride->id_group = $data->id;
                }

                $query = $ride->save();


                if ($query) {

                    $this->stage($request,$ride);
                    if ($request->privacy == 'private') {
                        $this->notifyPrivateGroup($ride->id_group, $ride);
                    }
                        return back()->with('success', 'Le trajet a bien été enregistré.');

                } else {
                    return back()->with('fail', 'Something went wrong');
                }
            } else {
                return back()->with('not_driver', 'Vous n\'êtes pas enregistré en tant que conducteur, modifiez votre profil avant de créer un trajet. ');
            }
        }
    }

    public function stage(Request $request,Trip $ride){
        $count = 1;

        if(!empty($request->stage)) {
            foreach ($request->stage as $item) {
                if(!is_null($item)) {
                    $stage = new Stage;
                    $stage->stage = $item;
                    $stage->id_trip = $ride->id;
                    $stage->order = $count;
                    $count += 1;
                    $query = $stage->save();

                    if (!$query) {
                        return back()->with('fail', 'Something went wrong');
                    }
                }
            }
        }
    }

    public function show_trip_in_waiting(){
        if (session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();
            $id=$user->id;
            //tous les trajets
            $trips = DB::select("select *,t.id as t_id,u.id as u_id from trips t
            inner join link_user_trip lt
            on t.id=lt.id_trip
            inner join users u
            on lt.id_user=u.id
            where u.id=?",[$id]);
            $num_trip=0;
            foreach ($trips as $trip) {
                $driver= User::where('id',$trip->id_driver)->first();
                $trip_in_seconds =  strtotime($trip->date_trip);
                $current_time = time();
                $remaining_seconds=$trip_in_seconds - $current_time;
                $trips[$num_trip]->reste=$remaining_seconds;
                $trips[$num_trip]->name_driver=$driver->surname." ".$driver->name;
                $trips[$num_trip]->profile_pic_driver=$driver->profile_pic;
                $trips[$num_trip]->username_driver=$driver->username;
                $num_trip++;
            }
        }
        //Afficher tous les trajets en attente
        return view('trip/trip_in_waiting',['trips'=>$trips,'user'=>$user]);
    }

    public function show_trip_in_waiting_private(){
        if (session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();
            $id=$user->id;
            //tous les trajets privés
            $trips = DB::select("select *,t.id as t_id,u.id as u_id from trips t
            inner join link_user_trip lt
            on t.id=lt.id_trip
            inner join users u
            on lt.id_user=u.id
            where u.id=?
            and t.private=?",[$id,1]);
            $num_trip=0;
            foreach ($trips as $trip) {
                $driver= User::where('id',$trip->id_driver)->first();
                $trip_in_seconds =  strtotime($trip->date_trip);
                $current_time = time();
                $remaining_seconds=$trip_in_seconds - $current_time;
                $trips[$num_trip]->reste=$remaining_seconds;
                $trips[$num_trip]->name_driver=$driver->surname." ".$driver->name;
                $trips[$num_trip]->profile_pic_driver=$driver->profile_pic;
                $trips[$num_trip]->username_driver=$driver->username;
                $num_trip++;
            }
        }
        //Afficher tous les trajets en attente
        return view('trip/trip_in_waiting',['trips'=>$trips,'user'=>$user]);
    }

    public function modified_trip(Request $request){
        //$validator = $this->verification_info($request);

        $validator = Facades\Validator::make($request->all(),[
            'departure'=> 'required',
            'date'=>'required',
            'time'=>'required',
            'final'=>'required|different:departure',
            'rdv'=>'required',
            'nb_passengers'=>'required',
            'price'=>'required',
            'stage.*' => 'different:departure',
            'stage.*' => 'different:final'
        ],[
            'departure.required'=>'Ville de départ ne peut pas être vide.',
            'date.required'=>'La date ne peut être vide.',
            'time.required'=>'L\'heure ne peut être vide.',
            'final.required'=>'Ville d\'arrivée ne peut être vide',
            'final.different'=>'Ville d\'arrivée doit être différent de la ville de départ',
            'rdv.required'=>'Les precisions du rdv ne peuvent être vide.',
            'nb_passengers.required'=>'Le nombre de passagers ne peut être vide.',
            'price.required'=>'Le prix ne peut être vide.',
            'stage.*.different'=>'Les étapes doivent être diférente de la ville de départ et de la ville d\'arrivée',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        // Récupération des données du compte dans la BDD
        $id_trip =$request->id_trip;
        $ride = Trip::where('id', '=', $id_trip)->first();

        // Mise à jour des données de l'utilisateur connecté
        //* Pas besoin de vérifier si le champ a été modifié, SQL ne fera pas d'Update si la donné est la même
        //$ride = $this->transfer($trip,$request);



        $ride->starting_town = $request->departure;
        $ride->ending_town = $request->final;
        $ride->description = $request->info;
        $ride->precision = $request->rdv;
        $ride->price = $request->price;
        $ride->number_of_seats = $request->nb_passengers;
        $date=new \DateTime($request->date);
        $heure = explode(':',$request->time);
        $date->setTime($heure[0],$heure[1]);
        $ride->date_trip = $date;

        $now = new \DateTime();
        $difference_in_seconds = $ride->date_trip->format('U') - $now->format('U');
        if($difference_in_seconds<0){
            return back()->with('fail', "La date de départ de ce trajet est déjà passée, il est donc impossible de le créer.");
        }
        $query = $ride->save();

        if ($query) {

            $count = 1;
            $stage = Stage::where('id_trip', '=', $id_trip);
            $stage->delete();
            if(!empty($request->stage)) {
                foreach ($request->stage as $item) {
                    if(!is_null($item)) {
                        $stage = new Stage;
                        $stage->stage = $item;
                        $stage->id_trip = $ride->id;
                        $stage->order = $count;
                        $count += 1;
                        $query = $stage->save();

                        if (!$query) {
                            return back()->with('fail', 'Something went wrong');
                        }
                    }
                }
            }
            return back()->with('success', 'Le trajet a bien été modifié.');
        } else {
            return back()->with('fail', 'Something went wrong');
        }
    }

    public function transfer(Trip $ride,Request $request){
        $ride->starting_town = $request->departure;
        $ride->ending_town = $request->final;
        $ride->description = $request->info;
        $ride->precision = $request->rdv;
        $ride->price = $request->price;
        $ride->number_of_seats = $request->nb_passengers;
        $date=new \DateTime($request->date);
        $heure = explode(':',$request->time);
        $date->setTime($heure[0],$heure[1]);
        $ride->date_trip = $date;

        return $ride;
    }

    /**
     * @param int $id:id de utilisateur qui est enlevé
     * @param int $idRide:id de trajet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function  delete_user_from_ride(int $id,int $idRide)
    {
        //Cas normal
        if (session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            //on enlève le tuple de utilisateur
            $trip = Trip::where('id', '=', $idRide)->first();
            $trip_in_seconds =  strtotime($trip->date_trip);
            $current_time = time();
            $remaining_seconds=$trip_in_seconds - $current_time;
            $passager=User::where('id',$id)->first();
            $conducteur=User::where('id',$trip->id_driver)->first();
            //il reste au moin 24 h
            if($remaining_seconds>86400) {
                $deleted = DB::delete('delete from link_user_trip where id_user=? And id_trip=?', [$id, $idRide]);
                if ($deleted) {
                    $update = DB::update('update trips set number_of_seats= number_of_seats +1 where id=?', [$idRide]);
                    if ($update) {
                        //si le trip n'est pas encore validé,envoyer une notification
                        $conducteur->notify(new tripRequestCanceled($passager, $conducteur, $trip));
                        return back()->with("success","Successfully deleted");
                    } else {
                        return back()->with('fail',"delete failed ");
                    }
                } else {
                    return back()->with('fail',"delete failed ");
                }
            } else {
                return back()->with('fail',"delete failed ");
            }
        }
    }



    private function notifyPrivateGroup(int $idGroup, Trip $trip)
    {
        // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $userLogged = User::where('username', '=', $username)->first();

        $users = DB::table('link_users_groups')
                    ->where('id_group','=', $idGroup)
                    ->get();
        foreach($users as $user)
        {
            $userToNotify = User::find($user->id_member);

            $userToNotify->notify(new newPrivateTrip($userLogged,$userToNotify,$trip));
        }

    }

    /**
     * Function used to visualize all the trips which are created by the user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function view_my_created_trips(){
        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            $data = DB::select('SELECT * FROM `trips` WHERE id_driver=:id_driver', ['id_driver' => $user->id]);
            //$stages_trips = DB::select('SELECT * FROM `stages_trip` INNER JOIN `trips` ON `stages_trip.id_trip = trips.id`WHERE trips.id_driver=:id_driver', ['id_driver' => $user->id]);
            $stages_trips = $users = DB::table('stages_trip')
                ->join('trips', 'stages_trip.id_trip', '=', 'trips.id')
                ->where('trips.id_driver','=',$user->id)
                ->get();

        }


        return view('trip/my_created_trips',['data'=>$data],['stages_trips'=>$stages_trips]);
    }

    /**
     * function used to delete trip by ID
     * @param $id id of the trip which the user wants to delete
     */
    function delete_trip($id){
        if(session()->has('LoggedUser')) {
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            //in order to get the trip's data
            $trip = Trip::where('id', '=', $id)
                ->where ('id_driver','=',$user->id)
                ->first();

            $whereArray = array('id' => $id,'id_driver' => $user->id);
            $query = DB::table('trips');
            foreach($whereArray as $field => $value) {
                $query->where($field, $value);
            }

            $trip_in_seconds =  strtotime($trip->date_trip);
            $current_time = time();
            $remaining_seconds=$trip_in_seconds - $current_time;

            //there are 86400 in one day
            if($remaining_seconds<86400){
                return back()->with('fail', "Le départ de ce trajet est dans moins de 24h, il est donc impossible de le supprimer.");
            }
            $check = $query->delete();
            if($check != null){

                //notifiate each user which is this trip's passanger
                $link_user_trip = LinkUserTrip::where('id_trip', $id);
                foreach ($link_user_trip as $link){
                    $passager = User::where('id', '=', $link->id_user)->first();
                    $passager -> notify(new tripRequestCanceled($user,$passager,$trip));
                }

                //delete the trip
                LinkUserTrip::where('id_trip', $id)->delete();
                Stage::where('id_trip', $id)-> delete();

                //on supprime les notifs
                DB::table('notifications')
                    ->where('data->id_trip', '=', $id)
                    ->delete();

                return back()->with('success', 'Le trajet a bien été supprimé');
            }else{
                return back()->with('fail', 'Trajet inexistant');
            }

        }
    }

    /**
     * Fonction permettant au créateur d'un trajet d'accepter la requête d'un autre utilisateur pour participer à ce trajet
     */
    function acceptTripRequest($userID, $tripID)
    {
        if(session()->has('LoggedUser'))
        {
            $data = DB::table('link_user_trip') -> select('validated') -> where("id_user", $userID) -> where("id_trip", $tripID) -> first(); // Récupèration du lien trajet-passager lié à la notif/requête
            if ($data->validated == 0)
            {
                $affected = DB::table('link_user_trip') -> where ('id_trip', $tripID) -> where ('id_user', $userID) -> update(['validated' => 1]); //MaJ du champ validated

                $trip = Trip::find($tripID); // Récupèration du trajet
                $driver = User::find($trip -> id_driver); // Récupération du conducteur
                $passenger = User::find($userID); // Récupération de l'utilisateur passager

                $passenger -> notify(new tripRequestAccepted($driver, $passenger, $trip)); // Notification du passager de l'acceptation
                return back()->with('success', "La requête a bien été acceptée");
            }
            else{
                return back()->with('fail', "Vous avez déja répondu à cette demande");
            }
        }
        else{
            return back()->with('fail', "Erreur, vous devez être connecté.e pour réaliser cette action");
        }
    }

    /**
     * Fonction permettant au créateur d'un trajet de refuser la requête d'un autre utilisateur pour participer à ce trajet
     */
    function refuseTripRequest($userID, $tripID)
    {
        if(session()->has('LoggedUser'))
        {
            $data = DB::table('link_user_trip') -> select('validated') -> where("id_user", $userID) -> where("id_trip", $tripID) -> first(); // Récupèration du lien trajet-passager lié à la notif/requête
            if ($data->validated == 0)
            {
                $affected = DB::table('link_user_trip') -> where ('id_trip', $tripID) -> where ('id_user', $userID) -> update(['validated' => 2]); //MaJ du champ validated

                $trip = Trip::find($tripID); // Récupèration du trajet
                $driver = User::find($trip -> id_driver); // Récupération du conducteur
                $passenger = User::find($userID); // Récupération de l'utilisateur passager

                $passenger -> notify(new tripRequestRefused($driver, $passenger, $trip)); // Notification du passager de l'acceptation
                return back()->with('success', "La requête a bien été refusée");
            }
            else{
                return back()->with('fail', "Vous avez déja répondu à cette demande");
                }
        }
        else{
            return back()->with('fail', "Erreur, vous devez être connecté.e pour réaliser cette action");
        }
    }
}
