<?php

namespace Repository;

use Entity\User;
use Service\UserManager;

class UserRepository extends RepositoryAbstract {
    
    public function findAll(){
        // On veut récupérer la liste de tous les users en bdd
        $dbUsers = $this->db->fetchAll('SELECT * FROM users');
        $users = [];
        
        foreach ($dbUsers as $dbUser) {
            
            $user = $this->buildUserFromArray($dbUser);
            $users[] = $user;
           
      
            $user
                ->setId($dbUser['id_user'])
                ->setLastname($dbUser['lastname'])
                ->setFirstname($dbUser['firstname'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setAddress($dbUser['address'])
                ->setZipcode($dbUser['zipcode'])
                ->setCity($dbUser['city'])
                ->setPhone($dbUser['phone'])
                ->setStatus($dbUser['status'])
            ;
            
           
            
            }
    

        return $users;
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
                ->setFirstname($dbUser['firstname'])
                ->setLastname($dbUser['lastname'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setAddress($dbUser['address'])
                ->setZipcode($dbUser['zipcode'])
                ->setCity($dbUser['city'])
                ->setPhone($dbUser['phone'])
                ->setStatus($dbUser['status'])
            ;
            
            /*if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $user['status'] = $user->getStatus();
            
            }*/
       
            
            
           return $user;
 
        }
      
    }
    
  public function find($id){
        
        $query = <<<EOS
SELECT * FROM users WHERE id_user = :id_user
EOS;
        
        $dbUser = $this -> db -> fetchAssoc(
            $query,
            [':id_user' => $id]
        );
        
        $user = $this->buildUserFromArray($dbUser);
         
        return $user;
    }
    
    // On veut récupérer un utilisateur par son nom de famille
    public function findByLastname($lastname){
        
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE lastname = :lastname',
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
            
            /*if($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $user['status'] = $user->getStatus();*/
            
            }
        
        return $user;
    }
    
    public function insert(User $user){
        
        $data = [ 
                'lastname' => $user->getLastname(),// valeurs dans la BDD
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),
                'phone' => $user->getPhone(),
            ];
        
         /*if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $data['status'] = $user->getStatus();
            
        }*/
        
        $this->db->insert(
            'users', // Nom de la table dans laquelle les modifications sont effectuées
            $data
        );
                 
          
    }

    // Fonction pour modifier son profil dans la page profil et en BDD pour les admin
    public function update(User $user){ // Vérifier l'instanciation de l'objet $user 
        
        $data = [ 
                'lastname' => $user->getLastname(),// valeurs dans la BDD
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'phone' => $user->getPhone(),
                'city' => $user->getCity(),
                'status' => $user->getStatus(),              
            ];
        
        /* if ($withStatus){
         // si l'utilisateur est admin
            $data['status'] = $user->getStatus();
           
        }*/
        
        $this->db->update(
            'users', // Nom de la table dans laquelle les modifications sont effectuées
            $data,
                 
                ['id_user' => $user->getId()] // clause WHERE
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
    public function delete(User $user ){
        if($this->app['user.manager']->isAdmin()){
            
            $this-> db->delete('users',
                ['id_user'=> $user->getId()]
        
            );
        }
 
    }
   
      private function buildUserFromArray(array $dbUser){
         
            
            $user = new user(); // $user est un objet instance de la classe Entity user
            $user
                ->setId($dbUser['id_user'])
                ->setLastname($dbUser['lastname'])
                ->setFirstname($dbUser['firstname'])
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

}