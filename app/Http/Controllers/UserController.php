<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use MongoDB\Driver\Session;
use App\Models\LinkUsersGroup;

class UserController extends Controller
{
    //protected $user; //TODO: Limiter la duplication de code (appeler User::where qu'une seule fois)

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        /*$this->middleware('auth');*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    /**
     * Renvoie la page du formulaire de modification des données du compte avec les données
     * actuelles du compte pour les afficher
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function form()
    {
        // Récupération des données du compte dans la BDD
        $user = User::find(session()->get('LoggedUserID'));
        return view('user/edit') -> with($user -> toArray()); // et accès à la page de modifications du compte avec les données de celui-ci à afficher
    }

    /**
     * Vérifie que les données du formulaire ne sont pas erronées avant de les envoyer vers
     * la fonction de mise à jour.
     * Si données erronées: affiche popup d'erreur avec liste des problèmes
     * @param  \Illuminate\Http\Request $request requête de l'utilisateur (données du formulaire)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formSubmit(Request $request)
    {
        return $this -> formCheck($request);
    }

    public function formCheck(Request $request){
        $user = User::where('username', '=', session('LoggedUser'))->first();
        // Récupération des données du formulaire
        $validator = Validator::make($request->all(),[
            'email' => 'max:255|unique:users,email,'.$user->id,
            'nom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'prenom' => 'required|max:255|regex:/^[a-zA-Z0-9-_]+/i',
            'mdp' => 'nullable|max:255|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/i',
            'phone' => 'required|min:10|unique:users,phone,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'civilite' => 'required',
        ], [ // Vérification des données du formulaire
            'email.unique' => 'Email déjà pris',
            'phone.unique' => 'Numéro de téléphone déjà pris',
            'civilite.required' => 'Civilité doit être cochée.',
            'phone.regex' => 'Téléphone doit être uniquement en chiffres',
            'email.required' => 'Email ne peut pas être vide.',
            'nom.required' => 'Nom ne peut pas être vide.',
            'prenom.required' => 'Prénom ne peut pas être vide.',
            'mdp.confirmed' => 'Confirmation différente du mot de passe.',
            'phone.required' => 'Numéro de téléphone ne peut pas être vide.',
            'email.max' => 'Email trop long.',
            'nom.max' => 'Nom trop long.',
            'prenom.max' => 'Prénom trop long.',
            'mdp.max' => 'Mot de passe trop long.',
            'mdp.regex' => 'Nouveau mot de passe incorrect : il faut au moins 8 caractères dont au moins un caractère spécial, une majuscule et une minuscule.',
            'nom.regex' => 'Nom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'prenom.regex' => 'Prénom incorrect : lettres minuscules/majuscules, chiffres et tirets seulement.',
            'avatar.mimes' => 'Format d image incorrect.',
            'avatar.max' => 'Image trop lourde.',
            'phone.min' => 'Numéro de téléphone trop court (il faut 10 chiffres).',
            'phone.max' => 'Numéro de téléphone trop long (il faut 10 chiffres.',
        ]);

        if($validator->fails()){ // Si formulaire erroné, message d'erreur et reste sur le formulaire
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        return $this -> updateAccount($request); // Tout est ok, donc on met à jour les données
    }

    /**
     * Après la vérification, effectue la mise à jour des données du compte de l'utilisateur avec
     * celles rentrées dans le formulaire
     * @param \Illuminate\Http\Request $request requête de l'utilisateur (données du formulaire)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request){
        // Récupération des données du compte dans la BDD
        $user = User::find(session()->get('LoggedUserID'));
        // Mise à jour des données de l'utilisateur connecté
        //* Pas besoin de vérifier si le champ a été modifié, SQL ne fera pas d'Update si la donné est la même
        $user -> surname = $request -> nom;
        $user -> name = $request -> prenom;
        $user -> email = $request -> email;
        if ($request -> mdp != null){ // Si il y a un nouveau mot de passe...
            $user -> password = Hash::make($request -> mdp); //... On remplace l'actuel
        }
        $user -> phone = $request -> phone;
        $user -> gender = $request -> civilite;
        if($request->hasFile('avatar')){
            Storage::delete(($user->username.'/'.$request->session()->get('LoggedUserPic')));
            $filename = $request->avatar->getClientOriginalName();
            $request->avatar->storeAs($user->username,$filename,'public');
            $user->profile_pic = $filename;
        }
        $user -> vehicle = $request -> voiture;

        $user -> save(); // Sauvegarder les changements

        $request->session()->put("LoggedUserPic", $user->profile_pic);
        return Redirect::back(); // Rediriger vers la même page (rafraîchir)
    }

    /**
     * Show the basic user informations and modifications fields.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteUserAccount()
    {
        $user = User::find(session()->get('LoggedUserID')); // Récupération du compte dans la BDD
        $id = $user->id; // Pour avoir l'ID plus rapidement
        $path = $user->username;
        Storage::deleteDirectory(public_path('$path')); // Supression du dossier de l'utilisateur
        //Supression de chaque tuple de la BDD référençant l'utilisateur
        DB::table('ratings') -> where('id_rater', $id) -> delete(); // Supression des notes déposées 
        DB::table('ratings') -> where('id_rated', $id) -> delete(); // Supression des notes déposées
        DB::table('trips') -> where('id_driver', $id) -> delete(); // Supression des trajets créés par l'utilisateur
        // TODO: Suppression de chaque lien 'link_user_trip' où les trajets supprimées apparaissent
        DB::table('groups') -> where('id_creator', $id) -> delete(); // Supression des groupes créées par l'utilisateur
        // TODO: Suppression de chaque lien 'link_user_groups' où les groupes supprimées apparaissent
        DB::table('link_users_groups') -> where('id_member', $id) -> delete(); // Supression de l'appartenance à des groupes
        DB::table('link_user_trip') -> where('id_user', $id) -> delete(); // Suppression de l'appartenance à des trajets
        //DB::table('notifications') -> where('id_driver', $id) -> delete(); // Suppression des notifications concernant l'utilisateur
        $user -> delete(); // Suppression du compte dans la BDD
        return redirect('logout'); // Renvoyer vers la "page de déconnexion"
    }


    public function searchUser_view(){
        if(session()->has('LoggedUser')) {
            $user = User::find(session()->get('LoggedUserID'));
            $data = [
                'LoggedUserInfo' => $user
            ];
        }
        return view('user/search', $data);
    }

    public function searchUser(Request $request){
        $username = session()->get('LoggedUser'); // pseudo de l'utilisateur connecté
        $user = User::find(session()->get('LoggedUserID'));

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
        <!-- Lien Utilisateur -->
         <td><a href="/user/check_user_profile/'.$row->id.'">'.$row->username.'</a></td>;
         <td>
         <!-- Bouton Modal pour ajouter l`user dans un groupe privé -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal'.$row->id.'">
                Ajouter à un groupe
            </button>
            
            <!-- Fenetre Modale -->
            <div class="modal fade" id="Modal'.$row->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter '.$row->username.'à un groupe privé</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="Modal-body-'.$row->id.'">';
                    $groups = $user->getGroup();
                    foreach($user->getGroup() as $group)
                    {
                        $count = DB::table('link_users_groups')
                            ->where('id_group','=',$group->id)
                            ->where('id_member','=',$row->id)
                            ->count();

                        //Si il n'y a pas de lien group <-> user alors on peut l'ajouter dans le groupe
                        if($count == 0)
                        {
                            //Formulaire pour ajouter l'utilisateur à un groupe privé, voir add_member.js
                            $output .=' <form id="add-member-form" action="'.route('SearchAddMember').'" method="post">
                                            <input type="hidden" id="member-id-js" value="'.$row->id.'">
                                            <input type="hidden" id="group-id-js" value="'.$group->id.'">
                                            <button type="submit" class = "btn btn-outline-dark">Ajouter au groupe '.$group->name.'</button>
                                        </form>
                            ';
                            //$output .= '<p>'.$group->name.'</p>';
                        }
                    }
    $output .= '</div>
                </div>
            </div>
            </div>
       </td>
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



    function view_profile($id){
        $user = DB::table('users')
            ->where('id', '=', $id)
            ->first();

        $created_trips = DB::table('trips')
            ->where('id_driver','=',$id)
            ->where('private','=',0)
            ->get();
            //return back()->with("success", $user->username);
            return view('user/check_user_profile', ['user'=>$user],['created_trips'=>$created_trips]);

    }

    /*function addMember($id, $userName)
    {
        return 
        '<td>
         <!-- Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#'.$row->username.'Modal">
                Ajouter à un groupe
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="'.$row->username.'Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    '.$row->username.'
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
            </div>
       <\td>';
    }*/

    public function addMember(Request $request)
    {
        //On fait un nouveau lien avec les infos transmises dans la requête POST venant de add_member.js
        $link_user_group = new LinkUsersGroup;
        $link_user_group->id_group = $request->input('idGroup');
        $link_user_group->id_member = $request->input('idMember');
        $query = $link_user_group ->save(); //sauvegarde des infos dans la base de données (table groups)
        
        return response()->json(['status'=> 'OK']);
    }
}
