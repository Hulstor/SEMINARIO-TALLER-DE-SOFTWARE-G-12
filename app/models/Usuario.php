<?php

require_once __DIR__ . '/../core/Model.php';

class Usuario extends Model {

    public function buscarPorEmail($email){

        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':email'=>$email
        ]);

        return $stmt->fetch();
    }

}