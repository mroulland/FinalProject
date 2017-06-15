<?php

namespace Repository;

use Doctrine\DBAL\Connection;


class RepositoryAbstract {
     /**
     *
     * @var Connection
     */
    protected $db;
    # Protected et non private pour que les class enfants y ait accès #

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
}
