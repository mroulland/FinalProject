<?php

namespace Entity;

Class Abonnement {
    /**
    *
    *@var int
    */
    private $id_abonnement;

    /**
    *
    *@var int
    */
    private $id_membre;
    /**
    *
    *@var int
    */
    private $id_produit;

    /**
    *
    *@var int
    */
    private $id_livraison;

    /**
    *
    *@var date
    */
    private $date_debut;

    /**
    *
    *@var date
    */
    private $date_fin;

    /**
    *
    *@var periodicite
    */
    private $periodicite;



    public function getIdAbonnement(){
        return $this->id_abonnement;
    }

    public function getIdMembre(){
        return $this->id_membre;
    }

    public function getIdProduit(){
        return $this->id_produit;
    }

    public function getIdLivraison(){
        return $this->id_livraison;
    }

    public function getDateDebut(){
        return $this->date_debut;
    }

    public function getDateFin(){
        return $this->date_fin;
    }

    public function getPeriodicite(){
        return $this->periodicite;
    }



    public function setIdAbonnement($id_abonnement) {
        $this->id_abonnement = $id_abonnement;
        return $this;
    }

    public function setIdMembre($id_membre) {
        $this->id_membre = $id_membre;
        return $this;
    }

    public function setIdProduit($id_produit) {
        $this->id_produit = $id_produit;
        return $this;
    }

    public function setIdLivraison($id_livraison) {
        $this->id_livraison = $id_livraison;
        return $this;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
        return $this;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
        return $this;
    }

