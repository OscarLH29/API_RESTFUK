<?php
    // archivo de configuracion contiene una clase con configuraciones del servidor
    class db{
        private $host = 'brzl99hczpnkjssrgtdn-mysql.services.clever-cloud.com';
        private $user = 'umyiyjgabat1wfcx';
        private $pass = 'fqwDR92pqO0xaqGA5tfM';
        private $base = 'brzl99hczpnkjssrgtdn';

        // conectar a la bd
        public function conectar() {
            $conexion_mysql = "mysql:host=$this->host;dbname=$this->base";
            $conexionDB = new PDO($conexion_mysql, $this->user, $this->pass);
            $conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // por si la codificacion de caracteres causa problemas
            $conexionDB -> exec("set names utf8");
            return $conexionDB;
        }
    }

?>