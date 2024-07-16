<?php
class QueryBuilder {
    protected $db;
    protected $query;
    protected $table;
    protected $fields;
    protected $conditions;
    protected $values;

    // Query Credential
     public function __construct(Database $db) {
        $this->db = $db;
        $this->reset();
    }
       public function table($table) {
        $this->table = $table;
        return $this;
    }
      public function select($fields = '*') {
        $this->fields = is_array($fields) ? implode(', ', $fields) : $fields;
        $this->query = "SELECT {$this->fields} FROM {$this->table}";
        return $this;
    }
        public function execute() {
        $this->db->query($this->query);
        foreach ($this->values as $param => $value) {
            $this->db->bind(":{$param}", $value);
        }
        $result = $this->db->execute();
        $this->reset();
        return $result;
    }
     protected function reset() {
        $this->query = '';
        $this->table = '';
        $this->fields = '';
        $this->conditions = '';
        $this->values = [];
    }
    public function where($field, $operator, $value) {
        if (empty($this->conditions)) {
        $this->conditions = " WHERE {$field} {$operator} :{$field}";
        } else {
            $this->conditions .= " AND {$field} {$operator} :{$field}";
        }
        $this->values[$field] = $value;
        return $this;
        
    }
      public function getQuery() {
        return $this->query;
    }

  
    // General Query for CRUD
    public function all() {
        $this->db->query($this->query . $this->conditions);
        foreach ($this->values as $param => $value) {
            $this->db->bind(":{$param}", $value);
        }
        $result = $this->db->resultSet();
        $this->reset();
        return $result;
    }

        public function insert($data) {
        $this->fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $this->query = "INSERT INTO {$this->table} ({$this->fields}) VALUES ({$placeholders})";
        $this->values = $data;
        return $this;
    }
    public function get() {
        $this->db->query($this->query . $this->conditions);
        foreach ($this->values as $param => $value) {
            $this->db->bind(":{$param}", $value);
        }
        $result = $this->db->single();
        $this->reset();
        return $result;
    }

        public function delete() {
        $this->query = "DELETE FROM {$this->table}{$this->conditions}";
        return $this;
    }

     public function update($data) {
    $fields = '';
    foreach ($data as $field => $value) {
        $fields .= "{$field} = :{$field}, ";
        $this->values[$field] = $value;
    }
    $fields = rtrim($fields, ', ');
    $this->query = "UPDATE {$this->table} SET {$fields}{$this->conditions}";
    return $this;
}



}



?>