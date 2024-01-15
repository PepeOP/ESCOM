<?php

class AuthController {

    public function __construct($dbConnection) {
        // Aquí deberías establecer la conexión con la base de datos
        $this->dbConnection = $dbConnection;
    }

    public function login($data) {
        $curp = $data['curp_login'];
        $pass = $data['password_login'];


        $userQuery = $this->dbConnection->query("SELECT * FROM distinciones.users WHERE curp = '$curp'");

        if ($userQuery->rowCount() == 0) {
            return array(
                "error" => "CURP o contraseña incorrectas.",
                "data" => null
            );
        }

        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $passwordFromDb = $user['password'];
            if(md5($pass . "pepe") != $passwordFromDb) {
                return array(
                    "error" => "Contraseña o curp incorrectas.",
                    "data" => null
                );
            }

            $fecha = new DateTime(); // Fecha y hora actuales
            $fecha->modify('+50 years'); // Añadir 50 años
            $expires_on = $fecha->format('Y-m-d H:i:s'); // Formatear para SQL

            // Crear token de sesion
            $email = $user['email'];
            $user_id = $user['id'];
            $token = md5($email . $passwordFromDb . $fecha->getTimestamp());

            $this->dbConnection->query("INSERT INTO distinciones.sessions (token, user_id, expires_on) VALUES ('$token', '$user_id', '$expires_on')");

            return array(
                "error" => null,
                "data" => array(
                    "token" => $token,
                    "message" => "Iniciado sesion con exito!"
                )
            );

        }

        return array(
            "error" => "No se encontro ningun usuario con ese CURP.",
            "data" => null
        );


    }

    public function register($data) {
        try {

            if(!isset($data['curp_register']) && !isset($data['email_register']) && !isset($data['password_register'])) {
                return array(
                    "error" => "Debes incluir todos los campos para registrarte.",
                    "data" => null
                );
            }

            $curp = $data['curp_register'];
            $email = $data['email_register'];
            $pass = $data['password_register'];

            if (empty($curp) || empty($email) || empty($pass)) {
                // Manejar el error, por ejemplo, devolviendo un mensaje de error
                return array(
                    "error" => "Todos los campos son obligatorios.",
                    "data" => null
                );
            }

            $patronCurp = "/^[A-Z\d]{18}$/";
            if (!preg_match($patronCurp, $curp)) {
                return array(
                    "error" => "Formato de CURP inválido.",
                    "data" => null
                );
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return array(
                    "error" => "Formato de correo electrónico inválido.",
                    "data" => null
                );
            }


            $patronPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            if (!preg_match($patronPass, $pass)) {
                return array(
                    "error" => "Revisa que tu contraseña contenga un mínimo ocho caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial (@$!%*?&).",
                    "data" => null
                );
            }

            $pass = md5($pass . "pepe");

            $administrativos = $this->dbConnection->query("SELECT * FROM distinciones.administrativos WHERE curp = '$curp' LIMIT 1");
            $docentes = $this->dbConnection->query("SELECT * FROM distinciones.docentes WHERE curp = '$curp' LIMIT 1");

            if ($administrativos->rowCount() == 0 && $docentes->rowCount() == 0) {
                return array(
                    "error" => "No hay ningun preregistro para el CURP $curp",
                    "data" => null
                );
            }

            $usersQuery = $this->dbConnection->query("SELECT * FROM distinciones.users WHERE curp = '$curp'");
            $usersQueryEmail = $this->dbConnection->query("SELECT * FROM distinciones.users WHERE email = '$email'");

            if ($usersQueryEmail->rowCount() >= 1) {
                return array(
                    "error" => "Correo vinculado a otra cuenta, debes usar otro",
                    "data" => null
                );
            }

            if ($usersQuery->rowCount() >= 1) {
                return array(
                    "error" => "Ya has realizado tu preregistro con el CURP: $curp",
                    "data" => null
                );
            }

            $this->dbConnection->query("INSERT INTO distinciones.users (curp, email, password) VALUES ('$curp', '$email', '$pass');");
            http_response_code(200); // Código de estado HTTP para éxito
            return array(
                "error" => null,
                "data" => array(
                    "curp" => $curp,
                    "email" => $email,
                    "message" => "Se ha realizado con exito tu preregistro"
                )
            );
        } catch (Exception $e) {
            http_response_code(500); // Código de estado HTTP para error interno
            return array(
                "error" => $e,
                "data" => null
            );
        }
    }
}