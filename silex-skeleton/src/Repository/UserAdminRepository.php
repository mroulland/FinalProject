<?php
namespace Repository;

use Entity\User;


// Fonction pour éditer les membres en ADMIN
class UserRepository extends RepositoryAbstract
{

    public function findAll(){
        // On veut récupérer la liste de tous les membres en bdd
        $dbUsers = $this->db->FetchAssoc('SELECT * FROM membres');

        if(!empty($dbusers)){
            $users = new Membre();

            $users
                ->setNom($dbUsers['nom'])
                ->setPrenom($dbUsers['prenom'])
                ->setEmail($dbUsers['email'])
                ->setMdp($dbUsers['mdp'])
                ->setAdresse($dbUsers['adresse'])
                ->setCodePostal($dbUsers['code_postal'])
                ->setVille($dbUsers['ville'])
                ->setTelephone($dbUsers['telephone'])
                ->setStatut($dbUsers['statut'])
            ;
            return $users;
        }
        return null; 
    }


    public function findById($email){
        // On veut récupérer un utilisateur par son mail
        $dbMembre = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE email= :email',
            [':email' => $email]
        );

        // Si le membre existe, on instancie la classe Membre pour récupérer ses données
        if(!empty($dbMembre)){
            $membre = new Membre();

            $membre
                ->setNom($dbMembre['nom'])
                ->setPrenom($dbMembre['prenom'])
                ->setEmail($dbMembre['email'])
                ->setMdp($dbMembre['mdp'])
                ->setAdresse($dbMembre['adresse'])
                ->setCodePostal($dbMembre['code_postal'])
                ->setVille($dbMembre['ville'])
                ->setTelephone($dbMembre['telephone'])
                ->setStatut($dbMembre['statut'])
            ;
            
            return $membre;
        }
        return null;
    }

    public function findByName($email){
        // On veut récupérer un utilisateur par son mail
        $dbMembre = $this->db->fetchAssoc(
            'SELECT * FROM users WHERE email= :email',
            [':email' => $email]
        );

        // Si le membre existe, on instancie la classe Membre pour récupérer ses données
        if(!empty($dbMembre)){
            $membre = new Membre();

            $membre
                ->setNom($dbMembre['nom'])
                ->setPrenom($dbMembre['prenom'])
                ->setEmail($dbMembre['email'])
                ->setMdp($dbMembre['mdp'])
                ->setAdresse($dbMembre['adresse'])
                ->setCodePostal($dbMembre['code_postal'])
                ->setVille($dbMembre['ville'])
                ->setTelephone($dbMembre['telephone'])
                ->setStatut($dbMembre['statut'])
            ;
            
            return $membre;
        }
        return null;
    }


    public function update(User $user){ // Vérifier l'instanciation de l'objet $user 
        $this->db->update(
            'users', // nom de la table
            [ // valeurs à modifier
                'article'
            ]
        )
    }

}