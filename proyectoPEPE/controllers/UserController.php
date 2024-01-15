<?php

class UserController
{
    public function __construct($dbConnection) {
        // Aquí deberías establecer la conexión con la base de datos
        $this->dbConnection = $dbConnection;
    }


    public function addNewUser($data) {
        try {
            $nombre = $data['nombre'];
            $dependencia = $data['dependencia'];
            $distincion = $data['distincion'];
            $categoria = $data['categoria'];
            $curp = $data['curp'];

            $table = $categoria == 'Docente' ? 'docentes' : 'administrativos';

            // TODO registrar usuario
            $stmt = $this->dbConnection->prepare("INSERT INTO $table (nombre, dependencia, distincion, categoria, curp) VALUES (:nombre, :dependencia, :distincion, :categoria, :curp)");

            // Vincular los parámetros a la sentencia
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':dependencia', $dependencia);
            $stmt->bindParam(':distincion', $distincion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':curp', $curp);

            // Ejecutar la sentencia
            $stmt->execute();


            http_response_code(200); // Código de estado HTTP para éxito
        } catch (Exception $e) {
            http_response_code(500); // Código de estado HTTP para error interno
            echo 'Error al crear el usuario: ' . $e->getMessage();
        }
    }

    public function logout(mixed $data) {
        try {
            $token = $data['token'];
            $query = $this->dbConnection->query("DELETE FROM distinciones.sessions WHERE token = '$token'");
            $query->execute();

            return array(
                "error" => null,
                "data" => array(
                    "message" => "Token eliminado correctamente."
                )
            );
        } catch (Exception $e) {
            return array(
                "error" => "Error al borrar el token de la base de datos: " . $e,
                "data" => null
            );
        }

    }

    public function validateToken(mixed $data) {
        try {
            $token = $data['token'];

            $query = $this->dbConnection->query("SELECT * FROM distinciones.sessions WHERE token = '$token'");

            $session = $query->fetch(PDO::FETCH_ASSOC);

            if(!$session) {
                return array(
                    "error" => null,
                    "data" => array (
                        "is_valid" => false
                    )
                );
            }

            $expires_on = $session['expires_on'];

            if ($query->rowCount() == 0) {
                return array(
                    "error" => null,
                    "data" => array (
                        "is_valid" => false
                    )
                );
            }

            $expiresOnDateTime = new DateTime($expires_on);
            $currentDateTime = new DateTime();

            // Comparar las fechas
            if ($expiresOnDateTime > $currentDateTime) {
                return array(
                    "error" => null,
                    "data" => array("is_valid" => true)
                );
            } else {
                return array(
                    "error" => null,
                    "data" => array("is_valid" => false)
                );
            }
        } catch (Exception $e) {
            return array(
                "error" => "Error al validar el token: " . $e,
                "data" => null
            );
        }

    }

    public function getUserData(mixed $data) {
        try {
            $token = $data['token'];

            $queryAdministrativos = $this->dbConnection->query("SELECT
                                                    a.*
                                                FROM distinciones.sessions s
                                                JOIN distinciones.users u on s.user_id = u.id
                                                JOIN distinciones.administrativos a on u.curp = a.curp
                                                WHERE s.token = '763f923b714aa5f106b263561aabe90e';"
            );

            $queryDocentes = $this->dbConnection->query("SELECT
                                                    a.*
                                                FROM distinciones.sessions s
                                                JOIN distinciones.users u on s.user_id = u.id
                                                JOIN distinciones.docentes a on u.curp = a.curp
                                                WHERE s.token = '763f923b714aa5f106b263561aabe90e';"
            );

            $administrativos = $queryAdministrativos->fetchAll(PDO::FETCH_ASSOC);
            $docentes = $queryDocentes->fetchAll(PDO::FETCH_ASSOC);


            return array(
                "error" => null,
                "data" => array (
                    "administrativos" => $administrativos,
                    "docentes" => $docentes
                )
            );
        } catch (Exception $e) {
            return array(
                "error" => "Error al validar el token: " . $e,
                "data" => null
            );
        }
    }

}