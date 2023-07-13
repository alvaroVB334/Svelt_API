<?php

namespace Queries;

use PDO;
use PDOException;

class SuperUser
{

    /**
     * Función que hace el post de superusuarios con la id del usuario que solicita el post
     * @param idSuperUser-> id del usuario a introducir en dicha tabla
     */
    public function postSuperUser($idSuperUser, $conexPDO)
    {
        $result = null;

        try {
            //code...
            if (isset($idSuperUser) && $conexPDO != null) {
                $query = $conexPDO->prepare("INSERT INTO svelt.superuser(idSuperUser) values(:idSuperUser)");

                $query->bindParam(":idSuperUser", $idSuperUser);

                $result = $query->execute();
            }
        } catch (PDOException $e) {
            print("Error al conectar a la BD " . $e->getMessage());
        }

        return $result;
    }
}
