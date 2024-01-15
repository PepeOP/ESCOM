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
            return array(
                "error" => null,
                "data" => array(
                    "message" => "Usuario creado correctamente."
                )
            );
        } catch (Exception $e) {
            http_response_code(500); // Código de estado HTTP para error interno
            return array(
                "error" => "Error al crear el usuario:  " . $e,
                "data" => null
            );
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

    public function validateTokenAdmin(mixed $data) {
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

            $user_id = $session['user_id'];

            $queryUser = $this->dbConnection->query("SELECT * FROM distinciones.users WHERE id = '$user_id'");
            $user = $queryUser->fetch(PDO::FETCH_ASSOC);

            if(!$user) {
                return array(
                    "error" => null,
                    "data" => array (
                        "is_valid" => false
                    )
                );
            }

            $is_admin = $user['is_admin'];

            if(!$is_admin) {
                return array(
                    "error" => null,
                    "data" => array (
                        "is_valid" => false
                    )
                );
            }

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
                                                WHERE s.token = '$token';"
            );

            $queryDocentes = $this->dbConnection->query("SELECT
                                                    d.*
                                                FROM distinciones.sessions s
                                                JOIN distinciones.users u on s.user_id = u.id
                                                JOIN distinciones.docentes d on u.curp = d.curp
                                                WHERE s.token = '$token';"
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

    public function acceptInvitation(mixed $data) {
        try {
            $token = $data['token'];
            $accepted = $data['accepted'] ? 1 : 0;
            $guests = $data['guests'] ? 1 : 0;
            $disability = $data['disability'] ? 1 : 0;
            $disability_reason = $data['disability_reason'];



            $queryUser = $this->dbConnection->query("SELECT
                                                                u.*
                                                            FROM distinciones.sessions s
                                                            JOIN distinciones.users u on s.user_id = u.id
                                                            WHERE s.token = '$token';"
            );

            $user = $queryUser->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return array(
                    "error" => "eL TOKEN PROPORCIONADO NO CORRESPONDE A NINGUN USUARIO.",
                    "data" => null
                );
            }

            $curp = $user['curp'];

            $invitationQuery = $this->dbConnection->query("SELECT * FROM distinciones.invitaciones WHERE curp = '$curp'");

            if ($invitationQuery->rowCount() != 0) {
                return array(
                    "error" => "Ya has aceptado la invitacion.",
                    "data" => null
                );
            }


            $queryGuest = $this->dbConnection->query("INSERT INTO distinciones.invitaciones (curp, accepted, guests, disability, disability_reason) VALUES ('$curp', '$accepted', '$guests', '$disability', '$disability_reason')");

            $administrativosQuery = $this->dbConnection->query("SELECT * FROM distinciones.docentes WHERE curp = '$curp'");
            $docentesQuery = $this->dbConnection->query("SELECT * FROM distinciones.administrativos WHERE curp = '$curp'");

            $administrativos = $administrativosQuery->fetchAll(PDO::FETCH_ASSOC);
            $docentes = $docentesQuery->fetchAll(PDO::FETCH_ASSOC);

            http_response_code(200);
            return array(
                "error" => null,
                "data" => array (
                    "curp" => $curp,
                    "accepted" => $accepted,
                    "guests" => $guests,
                    "disability" => $disability,
                    "disability_reason" => $disability_reason,
                    "message" => "Invitacion aceptada con exito!",
                    "administrativos" => $administrativos,
                    "docentes" => $docentes
                )
            );
        } catch (Exception $e) {
            echo $e;
            http_response_code(500);
            return array(
                "error" => "Error en el servidor",
                "data" => null
            );
        }
    }

    public function deleteUser(mixed $data) {
        try {
            $token = $data['token'];
            $id = $data['id'];
            $category = $data['category'];

            $category = $data['category'] == "administrativo" ? 'administrativos' : "docentes";

            $query = $this->dbConnection->query("DELETE FROM distinciones.$category WHERE no = '$id'");
            $query->execute();

            return array(
                "error" => null,
                "data" => array (
                    "message" => "Usuario eliminado correctamente"
                )
            );
        } catch (Exception $e) {
            echo $e;
            http_response_code(500);
            return array(
                "error" => "Error en el servidor",
                "data" => null
            );
        }
    }

    public function editUser(mixed $data) {
        try {
            $no = $data['id'];
//            $nombre = $data['nombre'];
            $dependencia = $data['dependencia'];
            $distincion = $data['distincion'];
            $categoria = $data['categoria'];
//            $curp = $data['curp'];

            $table = $categoria == 'Docente' ? 'docentes' : 'administrativos';

            $stmt = $this->dbConnection->prepare("UPDATE distinciones.$table SET dependencia=:dependencia, distincion=:distincion WHERE no = '$no'");

            // Vincular los parámetros a la sentencia
            $stmt->bindParam(':dependencia', $dependencia);
            $stmt->bindParam(':distincion', $distincion);

            // Ejecutar la sentencia
            $stmt->execute();

            http_response_code(200); // Código de estado HTTP para éxito
            return array(
                "error" => null,
                "data" => array(
                    "message" => "Usuario editado correctamente."
                )
            );
        } catch (Exception $e) {
            echo $e;
            http_response_code(500);
            return array(
                "error" => "Error en el servidor",
                "data" => null
            );
        }
    }



}