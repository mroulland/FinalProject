<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract 
{
    public function insert(User $user){
        // Fonction pour l'inscription
       $this->db->insert(
            'users', // Nom de la table
            [   // Nom des champs dans la bddd
                'lastname' => $user->getLastname(),
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'phone' => $user->getPhone()
            ]
        ); 
    }
    
    public function update(User $user){
        // Fonction pour modifier son profil dans la page profil
        $this->db->update(
            'users', // Nom de la table à modifier
            [
                'lastname' => $user->getLastname(),
                'firstname' => $user->getFirstname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'phone' => $user->getPhone(),
                'address' => $user->getAddress(),
                'zip_code' => $user->getZipCode(),
                'city' => $user->getCity()
            ],
            ['id' => $user->getId()]
        );
    }
    
    public function findByEmail($email){
        // Fonction permettant de trouver un utilisateur par son mail dans la bdd
        // Pour la connexion
        $dbUser = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE email = :email', 
            [':email' => $email]
        );
        // Si la requête donne un résultat
        if(!empty($dbUser)) {
            $user = new User();
            
            $user
                ->setLastname($dbUser['lastname'])
                ->setFirstname($dbUser['firstname'])
                ->setEmail($dbUser['email'])
                ->setPassword($dbUser['password'])
                ->setPhone($dbUser['phone'])
                ->setAddress($dbUser['address'])
                ->setZipCode($dbUser['zip_code'])
                ->setCity($dbUser['city'])
                ->setStatus($dbUser['status'])
            ;
            
            return $user; // Retourne un objet avec les infos de l'utilisateur
        }
        return null; // Le return null explicite n'est pas nécessaire mais pratique == else
    }
}
