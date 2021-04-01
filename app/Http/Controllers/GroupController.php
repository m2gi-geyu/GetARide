<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\LinkUsersGroup;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Fonction group_form retournant la page/vue de création d'un nouveau groupe
     * @return view la page/vue de connexion
     */
    function group_form(){
        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            $data = DB::select('SELECT * FROM `users` WHERE username=:username', ['username' => $user->username]);
        }
        return view('group/creategroup',['data'=>$data]);
    }


    /**
     * Fuction which returns "group/addingmembers" view
     * @return view the view which is used to add members to a the newest group of the user
     */
    function adding_members_view(){

        if(session()->has('LoggedUser')){
            $user = User::where('username','=',session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo'=>$user
            ];

        }
        return view('group/addingmembers', $data);
    }


    /**
     *Function which creates a new group
     */
    function create_new_group(Request $request){
        $request ->validate([
            'group_name'=> 'required|max:255',
        ],[ // Vérification des données du formulaire
            'group_name.required' => 'Le nom du groupe ne peut pas être vide',
            'group_name.max' => 'Le nom du groupe est trop long',
        ]);

        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            //vérifier si l'utilisateur a déjà crée un groupe avec le même nom
            $test_group =DB::table('groups')
                ->where('id_creator', '=', $user->id)
                ->where ('name','like','%'.$request->group_name)
                ->first();

            if($test_group!=null){
                return back()->with('fail','OUPS! Vous avez déjà crée un groupe ayant le même nom');
            }


            $group= new Group; //instanciation d'un groupe et récolte des données entrées
            $group->name = $request->group_name;
            $group->id_creator = $user->id;
            $query = $group ->save(); //sauvegarde des infos dans la base de données (table groups)
            if($query){
                event(new Registered($group));
                return redirect('group/addingmembers');
            }else{
                return back()->with('fail','OUPS! Veuillez rééessayer plus tard.');
            }

        }



    }



    /**
     *Function which is the motor/brain of the search bar of the "addingmmembers view
     * We use this function with ajax/jquery ta make searchs quickly
     */
    function search_user(Request $request){
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::where('username', '=', $username)->first();

        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('users')
                    ->where('username', 'like', '%'.$query.'%')
                    ->where('username', 'not like', '%'.$user->username.'%')
                    ->orderBy('id', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('users')
                    ->where('username', 'not like', '%'.$user->username.'%')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
        <tr>
         <td>'.$row->username.'</td>
         <td><a href="/group/add_member/'.$row->id.'"><button type="submit" class="btn btn-block btn-primary">Ajouter au groupe</button></td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }


    /**
     * @param $id id of the member which the groupe's crator wants to add to his newest group
     * @return \Illuminate\Http\RedirectResponse it redirects to the current view
     */
    function add_member( $id){
        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données


            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();


            //On récupère le DERNIER (donc le plus nouveau) groupe crée par l'utilisateur
            $group =DB::table('groups')
                ->where('id_creator', '=', $user->id)
                ->orderBy('id', 'desc')
                ->first();


            //test si le membre a déjà été ajouté à ce groupe ou non
            $link_user_group_test = DB::table('link_users_groups')
                ->where('id_member', '=', $id,)
                ->where( 'id_group','=',$group->id)
                ->first();

            if($link_user_group_test!=null){
                return back()->with('fail','Cet utilisateur a déjà été ajouté à ce groupe');
            }

            //Un utilisateur ne peut pas s'auto ajouter dans le groupe qu'il a crée
            if($id==$user->id){
                return back()->with('fail','Vous ne pouvez pas vous ajouter à avotre propre groupe');
            }

            //tester s'il y a plus de 30 membres dans un groupe ou non
            $test_30_members = DB::table('link_users_groups')
                ->where('id_group','=',$group->id)->get();

            $test_30_members_count = $test_30_members->count();
            if($test_30_members_count>30){
                return back()->with('fail','Il y a déjà 30 membres dans votre roupe! Vous avez atteint la limite');
            }

            //sinon tout va bien et on peut faire la requête et créer la table associée
            $link_user_group = new LinkUsersGroup;
            $link_user_group->id_group = $group->id;
            $link_user_group->id_member = $id;
            $query = $link_user_group ->save(); //sauvegarde des infos dans la base de données (table groups)
            if($query){
                event(new Registered($group));
                return back()->with('success','un membre a été ajouté avec succès');
            }else{
                return back()->with('fail','OUPS! Veuillez rééessayer plus tard.');
            }

        }

    }


    function view_my_created_groups(){
        if(session()->has('LoggedUser')) { // Si l'utilisateur est toujours connecté, on met à jour les données
            // Récupération du nom de l'utilisateur et du tuble de la BDD correspondant à son compte
            $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
            $user = User::where('username', '=', $username)->first();

            $data = DB::select('SELECT * FROM `groups` WHERE id_creator=:id_creator', ['id_creator' => $user->id]);
        }


        return view('group/mycreatedgroups',['data'=>$data]);
    }

}
