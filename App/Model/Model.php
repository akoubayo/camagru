<?php
namespace App\Model;

use \PDO;

/**
*
*/

class Model
{
    private $db;
    private $req;
    private $array = array();
    private $debug = false;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost:8889;dbname=camagru;charset=utf8', 'root', 'root');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $this->db->exec("SET CHARACTER SET utf8");
        } catch (Exception $e) {
                die('Erreur : '.$e->getMessage());
        }
    }

    public static function find($id)
    {
        $class = static::maClass();
        $new = new $class();
        $req = $new->db->prepare("SELECT * FROM ".$new->table." WHERE id_". $new->table . " = ? ");
        $req->execute(array($id));
        $ret = $new->returnObject($req, $class);
        if (count($ret) == 1) {
            $ret = $ret[0];
        }
        return $ret;
    }

    public static function insert($data)
    {
        $ret = '';
        $class = static::maClass();
        $new = new $class();
    }

    public function save()
    {
        $req = 'INSERT INTO ' . $this->table . '(';
        $val = 'VALUES(';
        $array = array();
        foreach ($this->champs as $value) {
            if(isset($this->$value) && !empty($this->$value)){
                $req .= $value . ', ';
                $val .= ':' . $value . ', ';
                $array[$value] = $this->$value;
            }
        }
        $req = substr($req, 0, -2) . ') ' . substr($val, 0, -2) . ')';
        $req = $this->db->prepare($req);
        $req->execute($array);
    }

    public function update()
    {
        $this->req = 'UPDATE ' . $this->table . ' SET ';
        $idTable = 'id_' . $this->table;
        $this->array = array();
        foreach ($this->champs as $value) {
            if(isset($this->$value) && !empty($this->$value)){
                $this->req .= $value . ' = :' . $value . ', ';
                $this->array[$value] = $this->$value;
            }
        }
        $this->req = substr($this->req, 0, -2) . ' WHERE id_' . $this->table . ' = ' . $this->$idTable;
        $req = $this->db->prepare($this->req);
        $req->execute($this->array);
        $this->req = '';
        $this->array = array();
    }

    public function where($data)
    {

        if ($this->req == '') {
            $this->req = "SELECT * FROM ".$this->table." WHERE ";
            $this->array = array();
        } else {
            $this->req .= " AND ";
        }
        foreach ($data as $value) {
            if (in_array($value[0], $this->champs)) {
                $this->req .= $value[0] . " " . $value[1] . " :" .$value[0] . " AND ";
                $this->array[$value[0]] = $value[2];
            }
        }
        $this->req = substr($this->req, 0, -4);
        return $this;
    }

    public function whereOr($data)
    {
        if($this->req == '') {
            $this->req = "SELECT * FROM ".$this->table." WHERE ";
        } else {
            $this->req .= " OR ";
        }
        foreach ($data as $value) {
            if (in_array($value[0], $this->champs)) {
                $this->req .= $value[0] . " " . $value[1] . " :" .$value[0] . " OR ";
                $this->array[$value[0]] = $value[2];
            }
        }
        $this->req = substr($this->req, 0, -3);
        return $this;
    }

    public function get()
    {
        $req = $this->db->prepare($this->req);
        $req->execute($this->array);
        return $this->returnObject($req, get_class($this));
    }

    protected function returnObject($req, $class)
    {
        $ret = false;
        $i = 0;
        while ($don = $req->fetch(PDO::FETCH_ASSOC)) {
            $ret[$i] = new $class();
            foreach ($don as $key => $value) {
                $ret[$i]->$key = $value;
            }
            $i++;
        }
        if ($this->debug == true) {
            if ($ret == false) {
                echo "<br/>Aucune donnée trouvée</br>";
            } else {
                var_dump($ret);
            }
        }
        $this->req = '';
        $this->array = array();
        return $ret;
    }

    public function debug()
    {
        var_dump($this->req);echo '<br/>';
        var_dump($this->array);
        $this->debug = true;
        return $this;
    }
}
