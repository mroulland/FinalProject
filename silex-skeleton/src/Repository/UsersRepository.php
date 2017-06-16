<?php
namespace Repository;

use Entity\User;


// Fonction pour éditer les users en ADMIN
class UsersRepository extends RepositoryAbstract
{

    public function findAll(){
        // On veut récupérer la liste de tous les users en bdd
        $dbUsers = $this->db->FetchAssoc('SELECT * FROM users');

        if(!empty($dbUsers)){
            $users = new User();

            $users
                ->setLastname($dbUsers['firstname'])
                ->setFirstname($dbUsers['firstname'])
                ->setEmail($dbUsers['email'])
                ->setPassword($dbUsers['password'])
                ->setAddress($dbUsers['address'])
                ->setZipcode($dbUsers['zipcode'])
                ->setCity($dbUsers['city'])
                ->setPhone($dbUsers['phone'])
                ->setStatus($dbUsers['status'])
            ;
            return $users;
        }
        return null; 
    }

    // On veut récupérer un utilisateur par son mail
    public function findByEmail($email){
        
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE email= :email',
            [':email' => $email]
        );

        // Si l'utilisateur existe, on instancie la classe user pour récupérer ses données
        if(!empty($dbUser)){
            $user = new User();

            $user
                ->setNom($dbUser['firstname'])
                ->setPrenom($dbUser['lastname'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setAddress($dbUser['address'])
                ->setZipcode($dbUser['zipcode'])
                ->setCity($dbUser['city'])
                ->setPhone($dbUser['phone'])
                ->setStatus($dbUser['status'])
            ;
            
            return $user;
        }
        return null;
    }
    
    // On veut récupérer un utilisateur par son nom de famille
    public function findByLastname($lastname){
        
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE lastname= :lastname',
            [':lastname' => $lastname]
        );

        // Si l'utilisateur existe, on instancie la classe user pour récupérer ses données
        if(!empty($dbUser)){
            $user = new user();

            $user
                ->setLastname($dbUser['nom'])
                ->setFirstname($dbUser['prenom'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setAddress($dbUser['address'])
                ->setZipcode($dbUser['zipcode'])
                ->setCity($dbUser['city'])
                ->setPhone($dbUser['phone'])
                ->setStatus($dbUser['status'])
            ;
            
            return $user;
        }
        return null;
    }
    
    public function insert(User $user){
        
        $this->db->insert(
            'user',
             
             [ // valeurs à modifier
                'lastname' => $user->getLastname(),// valeurs
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getpassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),
                'status' => $user->getStatus(),              
            ]
            
           
        );
    }

    // Modification
    public function update(User $user){ // Vérifier l'instanciation de l'objet $user 
        $this->db->update(
            'users', // nom de la table
            [ // valeurs à modifier
                'lastname' => $user->getLastname(),// valeurs
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getpassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),
                'status' => $user->getStatus(),              
            ],
                 
                ['id' => $user->getId()] // clause WHERE
        );
    }
    
    // Enregistrement
    public function save(User $user){
        
        if(!empty($user->getId())) {
            $this->update($user);
        }else{
            $this->insert($user);
        }
        
    }
    
    // Suppression
    public function delete(user $user ){
        
        $this-> db->delete('user',
                ['id'=> $user->getId()]
        
        );
        
    }

}

