<?php

abstract class Model
{
    protected static $table;
    protected static $primaryKey;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function all()
    {
        $instance = new static();
        $instance->db->query('SELECT * FROM ' . static::$table . ' ORDER BY id DESC');
        return $instance->db->resultSet();
    }

    public static function find($id)
    {
        $instance = new static();
        $instance->db->query('SELECT * FROM ' . static::$table .' WHERE '. static::$primaryKey. '=:id');
        $instance->db->bind(':id', $id);
        return $instance->db->single();
        
    }

    public static function delete($id)
    {
        $instance = new static();
        $instance->db->query('DELETE FROM ' . static::$table . ' WHERE '. static::$primaryKey. '=:id');
        $instance->db->bind(':id', $id);
        $instance->db->execute();
        return $instance->db->rowCount();
    }

    public function insert()
    {
        $fields = get_object_vars($this);
        unset($fields['db']);

        $columns = implode(', ', array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));

        $sql = 'INSERT INTO ' . static::$table . ' (' . $columns . ') VALUES (' . $placeholders . ')';
        $this->db->query($sql);
        foreach ($fields as $field => $value) {
            $this->db->bind(':' . $field, $value);
        }
        $this->db->execute();
        return $this->db->rowCount();
    }

     public function update()
    {
        $fields = get_object_vars($this);
        unset($fields['db']);


        $setString = '';
        foreach ($fields as $field => $value) {
            $setString .= $field . ' = :' . $field . ', ';
        }
        $setString = rtrim($setString, ', ');

        $sql = 'UPDATE ' . static::$table . ' SET ' . $setString . ' WHERE '. static::$primaryKey. '=:id';
        $this->db->query($sql);
        foreach ($fields as $field => $value) {
            $this->db->bind(':' . $field, $value);
        }
        $this->db->bind(':id', $fields['id_blog']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function login($data){

    $this->db->query("SELECT * FROM admin WHERE username = :username");
    $this->db->bind('username', $data['username_admin']);
    $passDB = $this->db->single();
    if(isset($passDB['password'])){
        $passwordVerify = password_verify($data['password_admin'], $passDB['password']);
    }
    if($passwordVerify){
        return $data['username_admin'];
    }
}
    // Additional common methods can be added here (e.g., find, save, delete, etc.)
}
?>
