<?php

  class user {
    var $name;
    var $password;
    var $email;
    
    private $db;


    function __construct( $details = null ) {
      $this->name = $details['name'];
      $this->password = $details['password'];
      $this->email = $details['email'];
    }

    function getDetails(){
      $details = [
        "name" => $this->name,
        "email" => $this->email,
      ];

      return $details;
    }

    function setDB( $db ){
      $this->db = $db;
    }

    function store(){
      $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO users (name, password, email) VALUES ('$this->name', '$hashed_password', '$this->email')";

      if($this->db->query($sql) === true){
        return 
         [ 
          "success" => true,
          "id" => $this->db->insert_id,
          "message" => "Records inserted successfully."];
      } else{
        return 
        [ 
          "success" => false,
          "message" => str_replace("for key 'users_email_unique'","",mysqli_error($this->db))
        ];
      }
    }

    function getAll(){
      $sql = "SELECT * FROM users";
      if($result = mysqli_query($this->db, $sql)){
        $data = [];
        while($row = $result->fetch_assoc()){
          array_push($data,$row);
        }
        return $data;
      }else{
        return [];
      }
    }

    function fetch($id){
      $sql = "SELECT id, name, email, created_at, updated_at FROM users WHERE id = '$id' ";
      if($result = mysqli_query($this->db, $sql)){
        $data = [];
        while($row = $result->fetch_assoc()){
          array_push($data,$row);
        }
        return $data;
      }else{
        return [];
      }
    }


    function update($updates){
      $sql = "UPDATE users SET name='$updates->name', email='$updates->email', mobile_number='$updates->number' WHERE id = '$updates->id' ";
      if(mysqli_query($this->db, $sql)){
        return "Records were updated successfully.";
      } else {
        return "ERROR: Could not able to execute $sql. " . mysqli_error($this->db);
      }
    }

    function destroy($id){
      $sql = "DELETE FROM users WHERE id='$id'";
      if(mysqli_query($this->db, $sql)){
        return "User successfully remove.";
      } else {
        return "ERROR: Could not able to execute $sql. " . mysqli_error($this->db);
      }
    }
     
  }



?>