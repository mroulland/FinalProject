<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract {
    
    public function findAll($withStatus = false){
        // On veut récupérer la liste de tous les users en bdd
        $dbUsers = $this->db->fetchAll('SELECT * FROM users');
        $users = [];
        
        foreach ($dbUsers as $dbUser) {
            $user = new User();

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
            
            if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $user['status'] = $user->getStatus();
            
            }

            $users[] = $user;
        }

        return $users;
    }

    // On veut récupérer un utilisateur par son mail
    public function findByEmail($email, $withStatus = false){
        
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
            
            if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $user['status'] = $user->getStatus();
            
            }
            
            
           return $user;
 
        }
      
    }
    
  
    
    // On veut récupérer un utilisateur par son nom de famille
    public function findByLastname($lastname, $withStatus = false){
        
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
            
            if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $user['status'] = $user->getStatus();
            
            }
            
            

            
           
        
        }
        
        return $user;
    }
    
    public function insert(User $user, $withStatus = false){
        
        $data = [ 
                'lastname' => $user->getLastname(),// valeurs dans la BDD
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getpassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),              
            ];
        
         if ($withStatus){ // sous-entendu 'true' (si l'utilisateur est admin)
            $data['status'] = $user->getStatus();
            
        }
        
        $this->db->insert(
            'users', // Nom de la table dans laquelle les modifications sont effectuées
            $data
        );
                 
          
    }

    // Fonction pour modifier son profil dans la page profil et en BDD pour les admin
    public function update(User $user, $withStatus = false){ // Vérifier l'instanciation de l'objet $user 
        
        $data = [ 
                'lastname' => $user->getLastname(),// valeurs dans la BDD
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getpassword(),
                'address' => $user->getAddress(),
                'zipcode' => $user->getZipcode(),
                'city' => $user->getCity(),
                'phone' => $user->getPhone(),              
            ];
        
         if ($withStatus){
         // si l'utilisateur est admin
            $data['status'] = $user->getStatus();
           
        }
        
        $this->db->update(
            'users', // Nom de la table dans laquelle les modifications sont effectuées
            $data,
                 
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
    public function delete(User $user ){
        if(isAdmin()){
            
            $this-> db->delete('user',
                ['id'=> $user->getId()]
        
            );
        }
        
        
    }
   
}
