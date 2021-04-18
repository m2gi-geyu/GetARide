# Projet "GET A RIDE"
Ce projet a été développé avec le framework Laravel dans le cadre d'un enseignement universitaire.

## Licence du projet
_GNU General Public License v3.0_

## Prérequis
* PHP >= 7.3.21
* MySql >= 8.0.21
* Composer
* node
* npm
* Git


## Installation du projet
Commandes à exécuter dans un terminal

1. Cloner le projet
2. Dans le terminal, se déplacer dans le répertoire cloné
3. Installer des dépendances via le terminal:
    * **composer install**
4. Dans le terminal, Créer le fichier contenant les variables d’environnement :
    * **cp .env.example .env**
5. Dans le terminal, créer une clé:
    * **php artisan key:generate**
6. Dans le terminal, installer des dépendances et compiler le JavaScript :
    * **npm install**
    * **npm run dev**
7. A ce stade il faut :
    * Vérifier qu'il y a un dossier bootstrap à la racine du repository
    * Vérifier qu'il y a un dossier bootstrap dans /GetARide/node_modules/

8. Configurer les variables d’environnement :
    1. Configurer la base de donnée (Une base de donnée vierge doit déjà avoir été créé au préalable) Les lignes à modifier concernées:
    
    ![lignes_à_modifs](https://user-images.githubusercontent.com/62764644/115121730-86d57d80-9fb4-11eb-8aff-7adcc2a467a4.png)
    
    
    2. Configurer le serveur SMTP pour l’envoi de mail.  Nous avons utilisé nos adresses mail Google personnelle pour travailler. Pour la partie SMTP il faut conserver et modifier SEULEMENT ces lignes:
   
    ![lignes_à_modifs2](https://user-images.githubusercontent.com/62764644/115121782-d1ef9080-9fb4-11eb-9801-57905685cddc.png)

10. Dans vos paramètres de compte Google, dans l’onglet sécurité, il faut activer les accès moins sécurisé des applications

    ![param_mails](https://user-images.githubusercontent.com/62764644/115121813-fa778a80-9fb4-11eb-8de0-8495abf2f95f.png)
    
11. Dans le terminal, toujours dans le dossier cloné, créer les Tables de bases de données :
    * **php artisan migrate**
12. Et enfin, toujours dans le terminal et dans le dossier cloné, lancer le serveur:
    * **php artisan serve**
    
    
_Enjoy!_
   

