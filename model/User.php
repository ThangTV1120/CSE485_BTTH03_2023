<?php
class User {
    private $id;
    private $name;
    private $email;
    private $password;
  
    public function __construct($name, $email, $password) {
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
    }
  
    public function getId() {
      return $this->id;
    }
  
    public function getName() {
      return $this->name;
    }
  
    public function getEmail() {
      return $this->email;
    }
  
    public function getPassword() {
      return $this->password;
    }
  
    public function setName($name) {
      $this->name = $name;
    }
  
    public function setEmail($email) {
      $this->email = $email;
    }
  
    public function setPassword($password) {
      $this->password = $password;
    }
  
    public function validate() {
      $errors = array();
  
      // Validate name
      if (empty($this->name)) {
        $errors['name'] = 'Name is required';
      }
  
      // Validate email
      if (empty($this->email)) {
        $errors['email'] = 'Email is required';
      } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email is invalid';
      }
  
      // Validate password
      if (empty($this->password)) {
        $errors['password'] = 'Password is required';
      } elseif (strlen($this->password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
      }
  
      return $errors;
    }
  
    public function save() {
      $errors = $this->validate();
  
      if (count($errors) > 0) {
        throw new Exception('Validation failed: ' . json_encode($errors));
      }
  
      // Insert or update the user in the database
      // ...
    }
  
    // ...
  }
  
